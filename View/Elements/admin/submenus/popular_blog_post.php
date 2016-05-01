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
<?php if ($this->request->params['controller'] == 'popular_blog_post_configs' && $this->request->params['action'] == 'admin_edit'): ?>
<tr>
	<th>ブログコンテンツ管理メニュー</th>
	<td>
		<ul>
			<li><?php $this->BcBaser->link($blogContentDatas[$this->request->data['PopularBlogPostConfig']['blog_content_id']] . ' ブログ設定編集', array('admin' => true, 'plugin' => 'blog', 'controller' => 'blog_contents', 'action' => 'edit', $this->request->data['PopularBlogPostConfig']['blog_content_id'])) ?></li>
			<li><?php $this->BcBaser->link('記事一覧', array('admin' => true, 'plugin' => 'blog', 'controller' => 'blog_posts', 'action' => 'index', $this->request->data['PopularBlogPostConfig']['blog_content_id'])) ?></li>
		</ul>
	</td>
</tr>
<?php endif; ?>
<?php if ($this->request->params['controller'] == 'popular_blog_posts' && $this->request->params['action'] == 'admin_index'): ?>
<tr>
	<th>データメンテナンス</th>
	<td>
<script type="text/javascript">
$(function(){
	/**
	 * 検索時の正規表現利用チェック時の操作
	 */
	checkDeleteAllDataHandler();
	$('#CheckDeleteAllData, label[for=CheckDeleteAllData]').on('click', function(){
		checkDeleteAllDataHandler();
	});

	function checkDeleteAllDataHandler() {
		if ($('#CheckDeleteAllData').prop('checked')) {
			$('.delete-all-data-link').animate({opacity: 'show'}, 'slow');
		} else {
			$('.delete-all-data-link').animate({opacity: 'hide'}, 'fast');
		}
	}
});
</script>
		<ul>
			<li>
				<label for="CheckDeleteAllData" style="cursor: pointer;">
					<input type="checkbox" label="データをリセットするにはチェックを入れてください" id="CheckDeleteAllData">データをリセットするにはチェックを入れてください
				</label>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="delete-all-data-link" style="display: none;">
				<?php $this->BcBaser->link('全てのアクセスデータを削除する',
					array('admin' => true, 'plugin' => 'popular_blog_post', 'controller' => 'popular_blog_posts', 'action' => 'delete_all'),
					array('title' => '全てのアクセスデータを削除する', 'style' => 'color: #C00;'), "全てのアクセスデータを削除します。\n本当によろしいですか？", false); ?>
				</span>
			</li>
		</ul>
	</td>
</tr>
<?php endif ?>
