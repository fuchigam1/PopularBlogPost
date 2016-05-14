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
<script type="text/javascript">
	$(window).load(function () {
		$("#PopularBlogPostName").focus();
	});
</script>
<?php if ($this->request->params['action'] != 'admin_add'): ?>
	<?php echo $this->BcForm->create('PopularBlogPost', array('url' => array('action' => 'edit'))) ?>
	<?php echo $this->BcForm->input('PopularBlogPost.id', array('type' => 'hidden')) ?>
	<?php echo $this->BcForm->input('PopularBlogPost.blog_post_id', array('type' => 'hidden')) ?>
	<?php echo $this->BcForm->input('PopularBlogPost.blog_content_id', array('type' => 'hidden')) ?>
<?php else: ?>
	<?php echo $this->BcForm->create('PopularBlogPost', array('url' => array('action' => 'add'))) ?>
<?php endif ?>

<div id="PopularBlogPostTable">
	<table cellpadding="0" cellspacing="0" class="form-table section">
		<tr>
			<th class="col-head"><?php echo $this->BcForm->label('PopularBlogPost.id', 'NO') ?></th>
			<td class="col-input">
				<?php echo $this->BcForm->value('PopularBlogPost.id') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">ブログ名</th>
			<td class="col-input">
				<ul>
					<li><?php echo $blogContentDatas[$this->BcForm->value('PopularBlogPost.blog_content_id')] ?></li>
				</ul>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('PopularBlogPost.view_count', 'カウント') ?>
			</th>
			<td class="col-input">
				<?php
				echo $this->BcForm->input('PopularBlogPost.view_count', array(
					'type'	 => 'text', 'size'	 => 20,
					'type'	 => 'number', 'class'	 => 'popular-blog-post-view-count', 'style'	 => 'text-align: right')
				)
				?>
				<?php echo $this->BcForm->error('PopularBlogPost.view_count') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('PopularBlogPost.update_date', '最終更新日時') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->dateTimePicker('PopularBlogPost.update_date', array('size' => 12, 'maxlength' => 10), true) ?>
				<?php echo $this->BcForm->error('PopularBlogPost.update_date') ?>
			</td>
		</tr>
	</table>
</div>

<div class="submit">
	<?php if ($this->action == 'admin_add'): ?>
		<?php echo $this->BcForm->submit('登録', array('div' => false, 'class' => 'btn-red button')) ?>
	<?php else: ?>
		<?php echo $this->BcForm->submit('更新', array('div' => false, 'class' => 'btn-red button')) ?>
		<?php
		$this->BcBaser->link('削除', array('action' => 'delete', $this->BcForm->value('PopularBlogPost.id')), array('class' => 'btn-gray button'), sprintf('ID：%s のデータを削除して良いですか？', $this->BcForm->value('PopularBlogPost.id')), false);
		?>
	<?php endif ?>
</div>
<?php echo $this->BcForm->end() ?>
