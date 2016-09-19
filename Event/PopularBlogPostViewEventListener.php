<?php

/**
 * [ViewEventListener] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
class PopularBlogPostViewEventListener extends BcViewEventListener
{

	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = array(
		'Blog.Blog.afterRender',
	);

	/**
	 * プラグインのモデル名
	 * 
	 * @var string
	 */
	private $pluginModelName = 'PopularBlogPost';

	/**
	 * ランキングブログポスト設定モデル
	 * 
	 * @var Object
	 */
	private $PopularBlogPostConfigModel = NULL;

	/**
	 * ランキングブログポスト設定データ
	 * 
	 * @var array
	 */
	private $popularBlogPostConfig = array();

	/**
	 * PopularBlogPostConfig モデルを準備する
	 * 
	 */
	private function setUpModel()
	{
		if (ClassRegistry::isKeySet($this->plugin . '.PopularBlogPostConfig')) {
			$this->PopularBlogPostConfigModel = ClassRegistry::getObject($this->plugin . '.PopularBlogPostConfig');
		} else {
			$this->PopularBlogPostConfigModel = ClassRegistry::init($this->plugin . '.PopularBlogPostConfig');
		}
	}

	/**
	 * blogBlogBeforeRender
	 * 
	 * @param CakeEvent $event
	 */
	public function blogBlogAfterRender(CakeEvent $event)
	{
		if (BcUtil::isAdminSystem()) {
			return;
		}

		$View = $event->subject();
		if (!$this->isSingleAccess($View)) {
			return;
		}

		if (!$this->hasPopularBlogPostConfig($View)) {
			return;
		}

		if (!$this->isEnabledRecordSingleAccess($View)) {
			return;
		}

		$this->saveCountBlogAccess($View);
	}

	/**
	 * ブログ記事詳細へのアクセスかどうかを判定する
	 * 
	 * @param Opject $View
	 * @return boolean
	 */
	private function isSingleAccess($View)
	{
		if (Hash::get($View->viewVars, 'preview')) {
			return false;
		}

		if (!Hash::get($View->viewVars, 'single')) {
			return false;
		}

		if (Hash::get($View->request->params, 'action') != 'archives') {
			return false;
		}
		if (!Hash::get($View->request->params, 'pass') || !is_numeric($View->request->params['pass'][0])) {
			return false;
		}

		return true;
	}

	/**
	 * アクセスカウント設定を持っているか判定する
	 * 
	 * @param Opject $View
	 * @return boolean
	 */
	private function hasPopularBlogPostConfig($View)
	{
		if (!Hash::get($View->viewVars, 'blogContent')) {
			return false;
		}

		$this->setUpModel();
		$data = $this->PopularBlogPostConfigModel->find('first', array(
			'conditions' => array(
				'PopularBlogPostConfig.blog_content_id' => $View->viewVars['blogContent']['BlogContent']['id']
			),
			'recursive'	 => -1,
		));
		if ($data) {
			$this->popularBlogPostConfig = $data['PopularBlogPostConfig'];
			return true;
		}

		return false;
	}

	/**
	 * ブログ記事詳細へのアクセスカウントを記録して良い状態かを判定する
	 * 
	 * @param Opject $View
	 * @return boolean
	 */
	private function isEnabledRecordSingleAccess($View)
	{
		if (!$this->popularBlogPostConfig) {
			return false;
		}

		if (!$this->popularBlogPostConfig['status']) {
			return false;
		}

		if (Hash::get($View->viewVars, 'user') && Hash::get($View->viewVars, 'user.id')) {
			if ($this->popularBlogPostConfig['exclude_admin']) {
				return false;
			}
		}

		return true;
	}

	/**
	 * ブログ記事ごとに表示数をカウントして保存する
	 * 
	 * @param Object $View
	 */
	private function saveCountBlogAccess($View)
	{
		if (!isset($View->viewVars['post'][$this->pluginModelName])) {
			return;
		}

		$blogPost							 = $View->viewVars['post']['BlogPost'];
		$blogAccess[$this->pluginModelName]	 = $View->viewVars['post'][$this->pluginModelName];

		$blogAccess[$this->pluginModelName]['view_count'] ++;
		$saveData	 = array(
			$this->pluginModelName => array(
				'blog_post_id'		 => $blogPost['id'],
				'blog_content_id'	 => $blogPost['blog_content_id'],
				'view_count'		 => $blogAccess[$this->pluginModelName]['view_count'],
			)
		);
		$saveData	 = Hash::merge($blogAccess, $saveData);

		if (ClassRegistry::isKeySet('PopularBlogPost.PopularBlogPost')) {
			$PopularBlogPostModel = ClassRegistry::getObject('PopularBlogPost.PopularBlogPost');
		} else {
			$PopularBlogPostModel = ClassRegistry::init('PopularBlogPost.PopularBlogPost');
		}
		$PopularBlogPostModel->save($saveData, array('validate' => false));
	}

}
