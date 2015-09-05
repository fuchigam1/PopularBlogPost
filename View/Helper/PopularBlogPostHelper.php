<?php
/**
 * [Helper] PopularBlogPost
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			PopularBlogPost
 * @license			MIT
 */
class PopularBlogPostHelper extends AppHelper
{
	/**
	 * ヘルパー
	 *
	 * @var array
	 */
	public $helpers = array('BcBaser', 'Blog');

	/**
	 * 公開状態を取得する
	 * 
	 * @param array $data
	 * @return boolean 公開状態
	 */
	public function allowPublish($data)
	{
		if (isset($data['PopularBlogPost'])){
			$data = $data['PopularBlogPost'];
		} elseif (isset($data['PopularBlogPostConfig'])) {
			$data = $data['PopularBlogPostConfig'];
		}
		$allowPublish = (int)$data['status'];
		return $allowPublish;
	}

}
