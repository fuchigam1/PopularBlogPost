<?php
/**
 * [Controller] PopularBlogPosts
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
App::uses('PopularBlogPostApp', 'PopularBlogPost.Controller');
class PopularBlogPostsController extends PopularBlogPostAppController
{
	/**
	 * ControllerName
	 * 
	 * @var string
	 */
	public $name = 'PopularBlogPosts';

	/**
	 * Model
	 * 
	 * @var array
	 */
	public $uses = array('PopularBlogPost.PopularBlogPost');

	/**
	 * ぱんくずナビ
	 *
	 * @var array
	 */
	public $crumbs = array(
		array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index')),
		array('name' => 'ポピュラーブログポスト管理', 'url' => array('plugin' => 'popular_blog_post', 'controller' => 'popular_blog_posts', 'action' => 'index'))
	);

	/**
	 * 管理画面タイトル
	 *
	 * @var string
	 */
	public $adminTitle = 'ポピュラーブログポスト';

	/**
	 * beforeFilter
	 *
	 */
	public function beforeFilter()
	{
		parent::beforeFilter();
	}

	/**
	 * [ADMIN] 一覧
	 * 
	 */
	public function admin_index()
	{
		$this->pageTitle = $this->adminTitle . '一覧';
		$this->search = 'popular_blog_posts_index';
		$this->help = 'popular_blog_posts_index';

		$default = array('named' => array(
			'num' => $this->siteConfigs['admin_list_num'],
			'sortmode' => 0)
		);
		$this->setViewConditions($this->modelClass, array('default' => $default));

		$conditions = $this->createAdminIndexConditions($this->request->data);
		$this->paginate = array(
			'conditions'	=> $conditions,
			'fields'		=> array(),
			'order'	=> $this->modelClass .'.view_count DESC',
			'limit'			=> $this->passedArgs['num']
		);
		$this->set('datas', $this->paginate($this->modelClass));
		$this->set('blogContentDatas', array('0' => '指定しない') + $this->blogContentDatas);

		if ($this->RequestHandler->isAjax() || !empty($this->request->query['ajax'])) {
			Configure::write('debug', 0);
			$this->render('ajax_index');
			return;
		}
	}

	/**
	 * [ADMIN] 編集
	 * 
	 * @param int $id
	 */
	public function admin_edit($id = null)
	{
		$this->pageTitle = $this->adminTitle . '編集';
		parent::admin_edit($id);
	}

	/**
	 * [ADMIN] 削除
	 *
	 * @param int $id
	 */
	public function admin_delete($id = null)
	{
		parent::admin_delete($id);
	}

	/**
	 * [ADMIN] 全てのアクセスデータの削除
	 * 
	 */
	public function admin_delete_all()
	{
		$hasDeleteError = array();
		$datas = $this->{$this->modelClass}->find('all', array('recursive' => -1));
		if ($datas) {
			foreach ($datas as $data) {
				if (!$this->{$this->modelClass}->delete($data[$this->modelClass]['id'])) {
					$hasDeleteError[] = $data[$this->modelClass]['id'];
				}
			}
		} else {
			$this->setMessage('削除可能なデータがありませんでした。', true);
			$this->redirect(array('action' => 'index'));
		}

		$message = '';
		if ($hasDeleteError) {
			$message = 'データベース処理中にエラーが発生しました。';
			$errorId = implode(', ', $hasDeleteError);
			$message .= $message .'<br />削除に失敗したID: '. $errorId;
			$this->setMessage($message, true);
		} else {
			$message = '全てのアクセスカウントデータを削除しました。';
			$this->setMessage($message);
		}

		$this->redirect(array('action' => 'index'));
	}

	/**
	 * 一覧用の検索条件を生成する
	 *
	 * @param array $data
	 * @return array $conditions
	 */
	protected function createAdminIndexConditions($data)
	{
		$conditions = array();
		$blogContentId = '';
		$beginDateTime = '';
		$endDateTime = '';

		if (isset($data[$this->modelClass]['blog_content_id'])) {
			$blogContentId = $data[$this->modelClass]['blog_content_id'];
		}

		if (!empty($data[$this->modelClass]['update_date_begin_date'])) {
			$beginDateTime = $data[$this->modelClass]['update_date_begin_date'];
		}
		if (!empty($data[$this->modelClass]['update_date_begin_time'])) {
			$beginDateTime = $beginDateTime .' '. $data[$this->modelClass]['update_date_begin_time'];
		}

		if (!empty($data[$this->modelClass]['update_date_end_date'])) {
			$endDateTime = $data[$this->modelClass]['update_date_end_date'];
		}
		if (!empty($data[$this->modelClass]['update_date_end_time'])) {
			$endDateTime = $endDateTime .' '. $data[$this->modelClass]['update_date_end_time'];
		}

		if (!empty($data[$this->modelClass]['update_date_begin'])) {
			if ($beginDateTime) {
				$conditions['PopularBlogPost.update_date >='] = $beginDateTime;
			}
		}
		if (!empty($data[$this->modelClass]['update_date_end'])) {
			if ($endDateTime) {
				$conditions['PopularBlogPost.update_date <='] = $endDateTime;
			}
		}

		unset($data['_Token']);
		unset($data[$this->modelClass]['name']);
		unset($data[$this->modelClass]['blog_content_id']);
		unset($data[$this->modelClass]['update_date_begin']);
		unset($data[$this->modelClass]['update_date_end']);
		unset($data[$this->modelClass]['update_date_begin_date']);
		unset($data[$this->modelClass]['update_date_end_date']);
		unset($data[$this->modelClass]['update_date_begin_time']);
		unset($data[$this->modelClass]['update_date_end_time']);

		// 条件指定のないフィールドを解除
		foreach($data[$this->modelClass] as $key => $value) {
			if ($value === '') {
				unset($data[$this->modelClass][$key]);
			}
		}

		if ($data[$this->modelClass]) {
			$conditions = $this->postConditions($data);
		}

		// １つの入力指定から複数フィールド検索指定
		if ($blogContentId) {
			$conditions['and'] = array(
				$this->modelClass .'.blog_content_id' => $blogContentId
			);
		}

		if ($conditions) {
			return $conditions;
		} else {
			return array();
		}
	}

}
