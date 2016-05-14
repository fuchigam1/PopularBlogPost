<?php
/**
 * [PUBLISH][widgets] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
if (!isset($count)) {
	$count = 5;
} else {
	$count = $this->PopularBlogPost->convertNumeric($count);
}
if (isset($blogContent)) {
	$id = $blogContent['BlogContent']['id'];
} else {
	$id = $blog_content_id;
}
// ブログを「指定しない」場合は、全てのブログを対象とする
if (!$blog_content_id) {
	$id = '';
}
$datas = $this->PopularBlogPost->getPopularData($id, array(
	'limit' => $count,
	'order' => $order,
));

if (isset($this->Blog)) {
	$BlogHelper = $this->Blog;
} else {
	App::import('Helper', 'Blog.Blog');
	$BlogHelper = new BlogHelper($this);
}
?>
<div class="widget widget-popular-blog-post widget-popular-blog-post-<?php echo $id ?> blog-widget">
<?php if ($name && $use_title): ?>
	<h2><?php echo $name ?></h2>
<?php endif ?>
<?php if ($datas): ?>
	<ul>
		<?php foreach ($datas as $post): ?>
			<?php $postLink = preg_replace('/^\//', '', $BlogHelper->getPostLinkUrl($post)) ?>
			<?php $class = ($this->request->url == $postLink) ? ' class="current"' : '' ?>
			<li<?php echo $class ?>>
				<?php $BlogHelper->postTitle($post) ?>
				<?php if ($display_view_count): ?>
					<small><?php echo $post['PopularBlogPost']['view_count'] ?></small>
				<?php endif ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p class="no-data">記事がありません。</p>
<?php endif; ?>
</div>
