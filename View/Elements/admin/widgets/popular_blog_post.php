<?php
/**
 * [ADMIN] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
$title = '人気記事ランキング';
$description = '閲覧数の多い記事を表示します。';
?>
<?php echo $this->BcForm->input($key . '.display_view_count', array('type' => 'checkbox', 'label' => 'カウント数を表示する')) ?>
<br />
<?php echo $this->BcForm->label($key . '.count', '表示数') ?>&nbsp;
<?php echo $this->BcForm->input($key . '.count', array('type' => 'text', 'size' => 6, 'default' => 5)) ?>&nbsp;件
<br />
<?php echo $this->BcForm->label($key . '.order', '並び順') ?>&nbsp;
<?php echo $this->BcForm->input($key . '.order', array(
	'type' => 'select',
	'options' => array('DESC' => 'アクセス数の多い順', 'ASC' => 'アクセス数の少ない順'),
)) ?>
<br />
<?php echo $this->BcForm->label($key . '.blog_content_id', 'ブログ') ?>&nbsp;
<?php echo $this->BcForm->input($key . '.blog_content_id', array(
	'type' => 'select',
	'options' => $this->BcForm->getControlSource('Blog.BlogContent.id'),
	'empty' => '指定しない',
)) ?>
