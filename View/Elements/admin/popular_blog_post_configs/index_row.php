<?php
/**
 * [ADMIN] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
$classies = array();
if (!$this->PopularBlogPost->allowPublish($data)) {
	$classies = array('unpublish', 'disablerow');
} else {
	$classies = array('publish');
}
$class=' class="'.implode(' ', $classies).'"';
?>
<tr<?php echo $class; ?>>
	<td class="row-tools">
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_unpublish.png', array('width' => 24, 'height' => 24, 'alt' => '無効', 'class' => 'btn')),
			array('action' => 'ajax_unpublish', $data['PopularBlogPostConfig']['id']), array('title' => '無効', 'class' => 'btn-unpublish')) ?>
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_publish.png', array('width' => 24, 'height' => 24, 'alt' => '有効', 'class' => 'btn')),
			array('action' => 'ajax_publish', $data['PopularBlogPostConfig']['id']), array('title' => '有効', 'class' => 'btn-publish')) ?>

	<?php // ブログ設定編集画面へ移動 ?>
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_check.png', array('width' => 24, 'height' => 24, 'alt' => 'ブログ設定編集', 'class' => 'btn')),
			array('admin' => true, 'plugin' => 'blog', 'controller' => 'blog_contents', 'action' => 'edit', $data['PopularBlogPostConfig']['blog_content_id']),
			array('title' => 'ブログ設定編集'), 'ブログ設定編集画面へ移動します。よろしいですか？', false); ?>

	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')),
			array('action' => 'edit', $data['PopularBlogPostConfig']['id']), array('title' => '編集')) ?>
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_delete.png', array('width' => 24, 'height' => 24, 'alt' => '削除', 'class' => 'btn')),
		array('action' => 'ajax_delete', $data['PopularBlogPostConfig']['id']), array('title' => '削除', 'class' => 'btn-delete')) ?>
	</td>
	<td style="width: 45px;"><?php echo $data['PopularBlogPostConfig']['id']; ?></td>
	<td>
		<?php echo $this->BcBaser->link($blogContentDatas[$data['PopularBlogPostConfig']['blog_content_id']], array('action' => 'edit', $data['PopularBlogPostConfig']['id']), array('title' => '編集')) ?>
	</td>
	<td style="text-align:center" class="status">
		<?php echo $this->BcText->booleanMark($data['PopularBlogPostConfig']['exclude_admin']); ?>
	</td>
	<td style="white-space: nowrap">
		<?php echo $this->BcTime->format('Y-m-d', $data['PopularBlogPostConfig']['created']) ?>
		<br />
		<?php echo $this->BcTime->format('Y-m-d', $data['PopularBlogPostConfig']['modified']) ?>
	</td>
</tr>
