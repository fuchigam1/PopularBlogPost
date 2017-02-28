<?php

/**
 * [ControllerEventListener] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
class PopularBlogPostControllerEventListener extends BcControllerEventListener {

	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = array(
		'initialize',
	);

	/**
	 * initialize
	 * 
	 * @param CakeEvent $event
	 */
	public function initialize(CakeEvent $event) {
		$Controller				 = $event->subject();
		$Controller->helpers[]	 = 'PopularBlogPost.PopularBlogPost';
	}

}
