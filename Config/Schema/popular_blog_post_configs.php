<?php 
class PopularBlogPostConfigsSchema extends CakeSchema {

	public $file = 'popular_blog_post_configs.php';

	public $connection = 'plugin';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $popular_blog_post_configs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 8, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'blog_content_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 1, 'unsigned' => false, 'comment' => 'ブログコンテンツID'),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '利用状態'),
		'exclude_admin' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'ログイン中カウント除外'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
