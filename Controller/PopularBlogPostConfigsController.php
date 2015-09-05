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
class PopularBlogPostConfigsController extends PopularBlogPostAppController
{
	/**
	 * ControllerName
	 * 
	 * @var string
	 */
	public $name = 'PopularBlogPostConfigs';

	/**
	 * Model
	 * 
	 * @var array
	 */
	public $uses = array('PopularBlogPost.PopularBlogPostConfig', 'PopularBlogPost.PopularBlogPost');

	/**
	 * ぱんくずナビ
	 *
	 * @var array
	 */
	public $crumbs = array(
		array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index')),
		array('name' => 'ポピュラーブログポスト設定管理', 'url' => array('plugin' => 'popular_blog_post', 'controller' => 'popular_blog_post_configs', 'action' => 'index'))
	);

	/**
	 * 管理画面タイトル
	 *
	 * @var string
	 */
	public $adminTitle = 'ポピュラーブログポスト設定';

	/**
	 * beforeFilter
	 *
	 */
	public function beforeFilter()
	{
		parent::beforeFilter();
	}

	/**
	 * [ADMIN] 設定一覧
	 * 
	 */
	public function admin_index()
	{
		$this->pageTitle = $this->adminTitle . '一覧';
		$this->search = 'popular_blog_post_configs_index';
		$this->help = 'popular_blog_post_configs_index';
		parent::admin_index();
	}

	/**
	 * [ADMIN] 編集
	 * 
	 * @param int $id
	 */
	public function admin_edit($id = null)
	{
		$this->pageTitle = $this->adminTitle . '編集';
		$this->help = 'popular_blog_post_configs_index';
		parent::admin_edit($id);
	}

	/**
	 * [ADMIN] 追加
	 * 
	 */
	public function admin_add()
	{
		$this->pageTitle = $this->adminTitle . '追加';

		if ($this->request->is('post')) {
			$this->{$this->modelClass}->create();
			if ($this->{$this->modelClass}->save($this->request->data)) {
				$this->setMessage('追加が完了しました。');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->setMessage('入力エラーです。内容を修正して下さい。', true);
			}
		} else {
			$this->request->data = $this->{$this->modelClass}->getDefaultValue();
		}

		// 設定データがあるブログは選択リストから除外する
		$dataList = $this->{$this->modelClass}->find('all');
		if ($dataList) {
			foreach ($dataList as $data) {
				unset($this->blogContentDatas[$data[$this->modelClass]['blog_content_id']]);
			}
		}

		$this->set('blogContentDatas', $this->blogContentDatas);
		$this->render('form');
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
	 * [ADMIN] 各ブログ別のポピュラーブログポスト設定データを作成する
	 *   ・ポピュラーブログポスト設定データがないブログ用のデータのみ作成する
	 * 
	 */
	public function admin_first()
	{
		if ($this->request->data) {
			$count = 0;
			if ($this->blogContentDatas) {
				foreach ($this->blogContentDatas as $key => $blog) {	
					$configData = $this->PopularBlogPostConfig->findByBlogContentId($key);
					if (!$configData) {
						$this->request->data['PopularBlogPostConfig']['blog_content_id'] = $key;
						$this->request->data['PopularBlogPostConfig']['status'] = true;
						$this->PopularBlogPostConfig->create($this->request->data);
						if (!$this->PopularBlogPostConfig->save($this->request->data, false)) {
							$this->log(sprintf('ブログID：%s の登録に失敗しました。', $key));
						} else {
							$count++;
						}
					}
				}
			}
			$message = sprintf('%s 件のポピュラーブログポスト設定を登録しました。', $count);
			$this->setMessage($message);
			$this->redirect(array('controller' => 'popular_blog_post_configs', 'action' => 'index'));
		}

		$this->pageTitle = $this->adminTitle . 'データ作成';
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

		if (isset($data[$this->modelClass]['blog_content_id'])) {
			$blogContentId = $data[$this->modelClass]['blog_content_id'];
		}
		if (isset($data[$this->modelClass]['status']) && $data[$this->modelClass]['status'] === '') {
			unset($data[$this->modelClass]['status']);
		}

		unset($data['_Token']);
		unset($data[$this->modelClass]['blog_content_id']);

		// 条件指定のないフィールドを解除
		foreach($data[$this->modelClass] as $key => $value) {
			if ($value === '') {
				unset($data[$this->modelClass][$key]);
			}
		}

		if ($data[$this->modelClass]) {
			$conditions = $this->postConditions($data);
		}

		if ($blogContentId) {
			$conditions = array(
				$this->modelClass .'.blog_content_id' => $blogContentId
			);
		}

		if($conditions) {
			return $conditions;
		} else {
			return array();
		}
	}

}
