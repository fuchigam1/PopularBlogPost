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
<?php if(!empty($text)): ?>
<div id="ReadMe">
	<?php if (!$this->passedArgs): ?>
		<?php echo $this->{$this->plugin}->transformMarkDown($text) ?>
	<?php else: ?>
		<?php echo nl2br($text) ?>
	<?php endif ?>
</div>
<?php endif ?>
