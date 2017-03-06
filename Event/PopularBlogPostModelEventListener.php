<?php

/**
 * [ModelEventListener] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
class PopularBlogPostModelEventListener extends BcModelEventListener {

	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = array(
		'Blog.BlogPost.beforeFind',
		'Blog.BlogPost.afterDelete',
		'Blog.BlogContent.beforeFind',
		'Blog.BlogContent.afterDelete',
	);

	/**
	 * プラグインのモデル名
	 * 
	 * @var string
	 */
	private $pluginModelName = 'PopularBlogPost';

	/**
	 * blogBlogPostBeforeFind
	 * 
	 * @param CakeEvent $event
	 */
	public function blogBlogPostBeforeFind(CakeEvent $event) {
		if (!BcUtil::isAdminSystem()) {
			$Model		 = $event->subject();
			// ブログ記事取得の際に人気記事ランキング表示情報も併せて取得する
			// もしなんらかの事故で複数の同一 blog_post_id が発生した場合に、
			// ブログ記事一覧表示に同一記事が複数表示されるため、フロント側でのみリレーションを張る
			$association = array(
				$this->pluginModelName => array(
					'className'	 => $this->plugin . '.' . $this->pluginModelName,
					'foreignKey' => 'blog_post_id'
				)
			);
			$Model->bindModel(array('hasOne' => $association));
		}
	}

	/**
	 * blogBlogPostAfterDelete
	 * - ブログ記事削除時、そのブログ記事が持つPopularBlogPostを削除する
	 * 
	 * @param CakeEvent $event
	 */
	public function blogBlogPostAfterDelete(CakeEvent $event) {
		$Model = $event->subject();

		$PopularBlogPostModel	 = ClassRegistry::init('PopularBlogPost.PopularBlogPost');
		$data					 = $PopularBlogPostModel->find('first', array(
			'conditions' => array('PopularBlogPost.blog_post_id' => $Model->id),
			'recursive'	 => -1
		));
		if ($data) {
			if (!$PopularBlogPostModel->delete($data['PopularBlogPost']['id'])) {
				$this->log(sprintf('ID：%s の PopularBlogPost の保存に失敗しました。', $Model->data['PopularBlogPost']['id']));
			}
		}
	}

	/**
	 * blogBlogContentBeforeFind
	 * 
	 * @param CakeEvent $event
	 * @return array
	 */
	public function blogBlogContentBeforeFind(CakeEvent $event) {
		$Model		 = $event->subject();
		// ブログ設定取得の際に人気記事ランキング表示設定情報も併せて取得する
		$association = array(
			'PopularBlogPostConfig' => array(
				'className'	 => $this->plugin . '.PopularBlogPostConfig',
				'foreignKey' => 'blog_content_id'
			)
		);
		$Model->bindModel(array('hasOne' => $association));
	}

	/**
	 * blogBlogContentAfterDelete
	 * - ブログ削除時、そのブログが持つPopularBlogPost設定を削除する
	 * 
	 * @param CakeEvent $event
	 */
	public function blogBlogContentAfterDelete(CakeEvent $event) {
		$Model = $event->subject();

		$PopularBlogPostConfigModel	 = ClassRegistry::init('PopularBlogPost.PopularBlogPostConfig');
		$data						 = $PopularBlogPostConfigModel->find('first', array(
			'conditions' => array('PopularBlogPostConfig.blog_content_id' => $Model->id),
			'recursive'	 => -1
		));
		if ($data) {
			if (!$PopularBlogPostConfigModel->delete($data['PopularBlogPostConfig']['id'])) {
				$this->log(sprintf('ID：%s の PopularBlogPost 設定の削除に失敗しました。', $data['PopularBlogPostConfig']['id']));
			}
		}
	}

}
