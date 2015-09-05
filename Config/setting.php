<?php
/**
 * [ADMIN] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
/**
 * システムナビ
 */
$config['BcApp.adminNavi.popular_blog_post'] = array(
		'name'		=> 'ポピュラーブログポスト プラグイン',
		'contents'	=> array(
			array('name' => 'アクセス一覧',
				'url' => array(
					'admin' => true,
					'plugin' => 'popular_blog_post',
					'controller' => 'popular_blog_posts',
					'action' => 'index')
			),
			array('name' => '設定一覧',
				'url' => array(
					'admin' => true,
					'plugin' => 'popular_blog_post',
					'controller' => 'popular_blog_post_configs',
					'action' => 'index')
			),
			array('name' => 'README',
				'url' => array(
					'admin' => true,
					'plugin' => 'popular_blog_post',
					'controller' => 'popular_blog_posts',
					'action' => 'readme')
			)
	)
);
