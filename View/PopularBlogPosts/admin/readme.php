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
<style type="text/css">
	#ReadMe {
//		height: 340px;
		overflow: scroll;
	}
</style>

<?php if(!empty($text)): ?>
<div id="ReadMe">
	<?php echo $this->{$this->plugin}->transformMarkDown($text) ?>
</div>
<?php endif ?>
