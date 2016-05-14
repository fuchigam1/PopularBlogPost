<?php

/**
 * [Model] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
class PopularBlogPost extends BcPluginAppModel
{

	/**
	 * ModelName
	 * 
	 * @var string
	 */
	public $name = 'PopularBlogPost';

	/**
	 * PluginName
	 * 
	 * @var string
	 */
	public $plugin = 'PopularBlogPost';

	/**
	 * belongsTo
	 * 
	 * @var array
	 */
	public $belongsTo = array(
		'BlogPost' => array(
			'className'	 => 'Blog.BlogPost',
			'foreignKey' => 'blog_post_id'
		)
	);

	/**
	 * Validation
	 *
	 * @var array
	 */
	public $validate = array(
		'blog_post_id' => array(
			'notEmpty' => array(
				'rule'		 => array('notEmpty'),
				'message'	 => '必須入力です。'
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
				'view_count' => 0,
			)
		);
		return $data;
	}

	/**
	 * beforeSave
	 * 
	 * @param array $options
	 * @return boolean
	 */
	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->name])) {
			$data = $this->data[$this->name];
		} else {
			$data = $this->data;
		}

		$data['update_date']	 = date('Y-m-d H:i:s');
		$this->data[$this->name] = $data;
		return true;
	}

}
