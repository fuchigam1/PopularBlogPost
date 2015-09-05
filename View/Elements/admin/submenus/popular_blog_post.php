<?php
/**
 * [ADMIN] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
$menuList = Configure::read('BcApp.adminNavi.'. Inflector::underscore($this->plugin));
?>
<tr>
	<th><?php echo $menuList['name'] ?>メニュー</th>
	<td>
		<ul>
<?php foreach ($menuList['contents'] as $menu): ?>
			<?php if(is_array($menu['url'])): ?>
			<li><?php $this->BcBaser->link($menu['name'],
					array(
						'admin' => $menu['url']['admin'],
						'plugin' => $menu['url']['plugin'],
						'controller' => $menu['url']['controller'],
						'action' => $menu['url']['action']
				)) ?>
			</li>
			<?php else: ?>
			<li><?php $this->BcBaser->link($menu['name'], $menu['url']) ?></li>
			<?php endif ?>
<?php endforeach ?>
		</ul>
	</td>
</tr>
