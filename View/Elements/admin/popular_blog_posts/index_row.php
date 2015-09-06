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
	<td class="row-tools">
	<?php if ($this->BcBaser->isAdminUser()): ?>
		<?php echo $this->BcForm->checkbox('ListTool.batch_targets.' . $data['PopularBlogPost']['id'], array('type' => 'checkbox', 'class' => 'batch-targets', 'value' => $data['PopularBlogPost']['id'])) ?>
	<?php endif ?>
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_unpublish.png', array('width' => 24, 'height' => 24, 'alt' => '無効', 'class' => 'btn')),
			array('action' => 'ajax_unpublish', $data['PopularBlogPost']['id']), array('title' => '無効', 'class' => 'btn-unpublish')) ?>
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_publish.png', array('width' => 24, 'height' => 24, 'alt' => '有効', 'class' => 'btn')),
			array('action' => 'ajax_publish', $data['PopularBlogPost']['id']), array('title' => '有効', 'class' => 'btn-publish')) ?>

	<?php // ブログ記事画面へ移動 ?>
	<?php echo $this->Blog->getPostLink($data,
		$this->BcBaser->getImg('admin/icn_tool_check.png', array('width' => 24, 'height' => 24, 'alt' => 'ブログ記事編集', 'class' => 'btn')),
		array('target' => '_blank')
	) ?>

	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')),
			array('action' => 'edit', $data['PopularBlogPost']['id']), array('title' => '編集')) ?>
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_delete.png', array('width' => 24, 'height' => 24, 'alt' => '削除', 'class' => 'btn')),
		array('action' => 'ajax_delete', $data['PopularBlogPost']['id']), array('title' => '削除', 'class' => 'btn-delete')) ?>
	</td>
	<td style="width: 45px;">
		<?php echo $data['PopularBlogPost']['id'] ?>
	</td>
	<td>
		<?php echo $blogContentDatas[$data['PopularBlogPost']['blog_content_id']] ?>
	</td>
	<td>
		<?php $this->BcBaser->link($data['BlogPost']['name'],
			array('admin' => true, 'plugin' => 'blog', 'controller' => 'blog_posts', 'action' => 'edit', $data['BlogPost']['blog_content_id'], $data['BlogPost']['id']),
			array('title' => 'ブログ記事編集'), 'ブログ記事編集画面へ移動します。よろしいですか？', false); ?>
	</td>
	<td>
		<?php echo $data['PopularBlogPost']['view_count'] ?>
	</td>
	<td style="white-space: nowrap">
		<?php echo $this->BcTime->format('Y-m-d', $data['PopularBlogPost']['update_date']) ?>
		<br>
		<?php echo $this->BcTime->format('H:i:s', $data['PopularBlogPost']['update_date']) ?>
	</td>
	<td style="white-space: nowrap">
		<?php echo $this->BcTime->format('Y-m-d', $data['PopularBlogPost']['created']) ?>
		<br />
		<?php echo $this->BcTime->format('Y-m-d', $data['PopularBlogPost']['modified']) ?>
	</td>
</tr>
