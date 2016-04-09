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
		'name'		=> '人気記事ランキング表示 プラグイン',
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
	)
);
