<?php
/**
 * [ADMIN] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
?>
<tr>
	<th>ポピュラーブログポスト設定管理メニュー</th>
	<td>
		<ul>
			<li><?php $this->BcBaser->link('ランキング確認', array('admin' => true, 'plugin' => 'popular_blog_post', 'controller' => 'popular_blog_posts', 'action'=>'index')) ?></li>
			<li><?php $this->BcBaser->link('ポピュラーブログポスト設定一覧', array('admin' => true, 'plugin' => 'popular_blog_post', 'controller' => 'popular_blog_post_configs', 'action'=>'index')) ?></li>
		</ul>
	</td>
</tr>
