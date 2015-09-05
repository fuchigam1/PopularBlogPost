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
<?php echo $this->BcForm->create('PopularBlogPostConfig', array('url' => array('action' => 'index'))) ?>
<p>
	<span>
		<?php echo $this->BcForm->label('PopularBlogPostConfig.blog_content_id', 'ブログ') ?>
		&nbsp;<?php echo $this->BcForm->input('PopularBlogPostConfig.blog_content_id', array('type' => 'select', 'options' => $blogContentDatas)) ?>
	</span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<span>
		<?php echo $this->BcForm->label('PopularBlogPostConfig.status', '利用状態') ?>
		&nbsp;<?php echo $this->BcForm->input('PopularBlogPostConfig.status', array('type' => 'select', 'options' => $this->BcText->booleanMarkList(), 'empty' => '指定なし')) ?>
	</span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<span>
		<?php echo $this->BcForm->label('PopularBlogPostConfig.exclude_admin', 'ログイン中カウント除外') ?>
		&nbsp;<?php echo $this->BcForm->input('PopularBlogPostConfig.exclude_admin', array('type' => 'select', 'options' => $this->BcText->booleanMarkList(), 'empty' => '指定なし')) ?>
	</span>
</p>
<div class="button">
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/btn_search.png', array('alt' => '検索', 'class' => 'btn')), "javascript:void(0)", array('id' => 'BtnSearchSubmit')) ?> 
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/btn_clear.png', array('alt' => 'クリア', 'class' => 'btn')), "javascript:void(0)", array('id' => 'BtnSearchClear')) ?> 
</div>
<?php echo $this->BcForm->end() ?>
