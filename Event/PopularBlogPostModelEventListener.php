<?php
/**
 * [ModelEventListener] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
class PopularBlogPostModelEventListener extends BcModelEventListener
{
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
	public function blogBlogPostBeforeFind(CakeEvent $event)
	{
		$Model = $event->subject();
		// ブログ記事取得の際に人気記事ランキング表示情報も併せて取得する
		$association = array(
			$this->pluginModelName => array(
				'className' => $this->plugin .'.'. $this->pluginModelName,
				'foreignKey' => 'blog_post_id'
			)
		);
		$Model->bindModel(array('hasOne' => $association));
	}


	/**
	 * blogBlogPostAfterDelete
	 * 
	 * @param CakeEvent $event
	 */
	public function blogBlogPostAfterDelete(CakeEvent $event)
	{
		$Model = $event->subject();
		// ブログ記事削除時、そのブログ記事が持つPopularBlogPostを削除する
		$data = $Model->{$this->pluginModelName}->find('first', array(
			'conditions' => array($this->pluginModelName .'.blog_post_id' => $Model->id),
			'recursive' => -1
		));
		if ($data) {
			if (!$Model->{$this->pluginModelName}->delete($data[$this->pluginModelName]['id'])) {
				$this->log(sprintf('ID：%s の'. $this->pluginModelName .'の保存に失敗しました。', $Model->data[$this->pluginModelName]['id']));
			}
		}
	}
	/**
	 * blogBlogContentBeforeFind
	 * 
	 * @param CakeEvent $event
	 * @return array
	 */
	public function blogBlogContentBeforeFind(CakeEvent $event)
	{
		$Model = $event->subject();
		// ブログ設定取得の際に人気記事ランキング表示設定情報も併せて取得する
		$association = array(
			'PopularBlogPostConfig' => array(
				'className' => $this->plugin .'.PopularBlogPostConfig',
				'foreignKey' => 'blog_content_id'
			)
		);
		$Model->bindModel(array('hasOne' => $association));
	}

	/**
	 * blogBlogContentAfterDelete
	 * 
	 * @param CakeEvent $event
	 */
	public function blogBlogContentAfterDelete(CakeEvent $event)
	{
		$Model = $event->subject();
		// ブログ削除時、そのブログが持つPopularBlogPost設定を削除する
		$data = $Model->PopularBlogPostConfig->find('first', array(
			'conditions' => array('PopularBlogPostConfig.blog_content_id' => $Model->id),
			'recursive' => -1
		));
		if ($data) {
			if (!$Model->PopularBlogPostConfig->delete($data['PopularBlogPostConfig']['id'])) {
				$this->log(sprintf('ID：%s の'. $this->pluginModelName .'設定の削除に失敗しました。', $data['PopularBlogPostConfig']['id']));
			}
		}
	}

}
