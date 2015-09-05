<?php
/**
 * [ADMIN] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
$title = 'ポピュラーブログポスト';
$description = 'ブログ記事のアクセスランキングを表示できます。';
$author = 'arata';
$url = 'http://www.materializing.net/';
$adminLink = array('plugin' => Inflector::underscore($plugin), 'controller' => 'popular_blog_post_configs', 'action' => 'index');
$installMessage = 'ブログコンテンツ別に設定を追加し、有効化するとブログ記事詳細のアクセスをカウントします。';
