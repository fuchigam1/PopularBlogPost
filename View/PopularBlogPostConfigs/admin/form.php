<?php
/**
 * [ADMIN] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
$hasAddableBlog = false;
if (count($blogContentDatas) > 0) {
	$hasAddableBlog = true;
}
?>
<?php if($this->request->params['action'] != 'admin_add'): ?>
	<?php echo $this->BcForm->create('PopularBlogPostConfig', array('url' => array('action' => 'edit'))) ?>
	<?php echo $this->BcForm->input('PopularBlogPostConfig.id', array('type' => 'hidden')) ?>
	<?php echo $this->BcForm->input('PopularBlogPostConfig.blog_content_id', array('type' => 'hidden')) ?>
<?php else: ?>
	<?php echo $this->BcForm->create('PopularBlogPostConfig', array('url' => array('action' => 'add'))) ?>
<?php endif ?>

<?php if($this->request->params['action'] != 'admin_add'): ?>
<h2>
<?php $this->BcBaser->link($blogContentDatas[$this->request->data['PopularBlogPostConfig']['blog_content_id']] .' ブログ設定編集はこちら', array(
	'admin' => true, 'plugin' => 'blog', 'controller' => 'blog_contents',
	'action' => 'edit', $this->request->data['PopularBlogPostConfig']['blog_content_id']
)) ?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php $this->BcBaser->link('≫記事一覧こちら', array(
	'admin' => true, 'plugin' => 'blog', 'controller' => 'blog_posts',
	'action' => 'index', $this->request->data['PopularBlogPostConfig']['blog_content_id']
)) ?>
</h2>
<?php endif ?>

<div id="PopularBlogPostConfigConfigTable">
<table cellpadding="0" cellspacing="0" class="form-table section">
	<?php if($this->request->params['action'] != 'admin_add'): ?>
	<tr>
		<th class="col-head"><?php echo $this->BcForm->label('PopularBlogPostConfig.id', 'NO') ?></th>
		<td class="col-input">
			<?php echo $this->BcForm->value('PopularBlogPostConfig.id') ?>
		</td>
	</tr>
	<?php endif ?>

	<?php if($this->request->params['action'] == 'admin_add'): ?>
		<?php if ($hasAddableBlog): ?>
	<tr>
		<th class="col-head"><?php echo $this->BcForm->label('PopularBlogPostConfig.blog_content_id', 'ブログ') ?></th>
		<td class="col-input">
			<?php echo $this->BcForm->input('PopularBlogPostConfig.blog_content_id', array('type' => 'select', 'options' => $blogContentDatas)) ?>
			<?php echo $this->BcForm->error('PopularBlogPostConfig.blog_content_id') ?>
		</td>
	</tr>
		<?php else: ?>
	<tr>
		<th class="col-head"><?php echo $this->BcForm->label('PopularBlogPostConfig.blog_content_id', 'ブログ') ?></th>
		<td class="col-input">
			追加設定可能なブログがありません。
		</td>
	</tr>
		<?php endif ?>
	<?php endif ?>
	
	<?php if ($hasAddableBlog): ?>
	<tr>
		<th class="col-head">
			<?php echo $this->BcForm->label('PopularBlogPostConfig.status', '人気記事ランキング表示の利用') ?>
			<?php echo $this->BcBaser->img('admin/icn_help.png', array('id' => 'helpPopularBlogPostConfigStatus', 'class' => 'btn help', 'alt' => 'ヘルプ')) ?>
			<div id="helptextPopularBlogPostConfigStatus" class="helptext">
				<ul>
					<li>ブログ記事での人気記事ランキング表示の利用の有無を指定します。</li>
				</ul>
			</div>
		</th>
		<td class="col-input">
			<?php echo $this->BcForm->input('PopularBlogPostConfig.status', array('type' => 'radio', 'options' => $this->BcText->booleanDoList('利用'))) ?>
			<?php echo $this->BcForm->error('PopularBlogPostConfig.status') ?>
		</td>
	</tr>
	<tr>
		<th class="col-head">
			<?php echo $this->BcForm->label('PopularBlogPostConfig.exclude_admin', 'ログイン中カウント除外の利用') ?>
			<?php echo $this->BcBaser->img('admin/icn_help.png', array('id' => 'helpPopularBlogPostConfigExcludeAdmin', 'class' => 'btn help', 'alt' => 'ヘルプ')) ?>
			<div id="helptextPopularBlogPostConfigExcludeAdmin" class="helptext">
				<ul>
					<li>管理システムにログイン中は、ブログ記事詳細へのアクセス数をカウントしない機能の利用の有無を指定します。</li>
				</ul>
			</div>
		</th>
		<td class="col-input">
			<?php echo $this->BcForm->input('PopularBlogPostConfig.exclude_admin', array('type' => 'radio', 'options' => $this->BcText->booleanDoList('利用'))) ?>
			<?php echo $this->BcForm->error('PopularBlogPostConfig.exclude_admin') ?>
		</td>
	</tr>
	<?php endif ?>
</table>
</div>

<?php if ($hasAddableBlog): ?>
<div class="submit">
	<?php echo $this->BcForm->submit('保　存', array('div' => false, 'class' => 'btn-red button')) ?>
</div>
<?php endif ?>
<?php echo $this->BcForm->end() ?>
