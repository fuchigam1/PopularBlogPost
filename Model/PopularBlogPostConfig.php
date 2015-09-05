<?php
/**
 * [Model] PopularBlogPostConfig
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
class PopularBlogPostConfig extends BcPluginAppModel
{
	/**
	 * ModelName
	 * 
	 * @var string
	 */
	public $name = 'PopularBlogPostConfig';

	/**
	 * PluginName
	 * 
	 * @var string
	 */
	public $plugin = 'PopularBlogPost';

	/**
	 * Behavior
	 * 
	 * @var array
	 */
	public $actsAs = array(
		'BcCache',
	);

	/**
	 * belongsTo
	 * 
	 * @var array
	 */
	public $belongsTo = array(
		'BlogContent' => array(
			'className'	=> 'Blog.BlogContent',
			'foreignKey' => 'blog_content_id'
		)
	);

	/**
	 * Validation
	 *
	 * @var array
	 */
	public $validate = array(
		'blog_content_id' => array(
			'notEmpty' => array(
				'rule'		=> array('notEmpty'),
				'message'	=> '必須入力です。'
			)
		)
	);

	/**
	 * 初期値を取得する
	 *
	 * @return array
	 */
	public function getDefaultValue()
	{
		$data = array(
			$this->name => array(
				'status' => true,
				'exclude_admin' => true,
			)
		);
		return $data;
	}

}
