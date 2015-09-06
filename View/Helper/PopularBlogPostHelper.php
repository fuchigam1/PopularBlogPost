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

	/**
	 * 記事ランキングデータを取得する
	 * 
	 * @param int $blogContentId
	 * @param array $options
	 * @return array
	 */
	public function getPopularData($blogContentId = '', $options = array()) {
		if (ClassRegistry::isKeySet('PopularBlogPost.PopularBlogPost')) {
			$PopularBlogPost = ClassRegistry::getObject('PopularBlogPost.PopularBlogPost');
		} else {
			$PopularBlogPost = ClassRegistry::init('PopularBlogPost.PopularBlogPost');
		}

		$_options = array(
			'limit' => 5,
			'order' => 'DESC',
		);
		$options = Hash::merge($_options, $options);

		$conditions = array(
			'limit' => $options['limit'],
			'order' => 'PopularBlogPost.view_count '. $options['order'],
		);

		if ($blogContentId) {
			$conditions = Hash::merge($conditions, array(
				'conditions' => array(
					'PopularBlogPost.blog_content_id' => $blogContentId,
				),
			));
		}

		$datas = $PopularBlogPost->find('all', $conditions);
		return $datas;
	}

	/**
	 * 文字列をチェックして数値型に変換する
	 * 
	 * @param string $num
	 * @return int
	 */
	public function convertNumeric($num) {
		$num = mb_convert_kana($num, 'a');
		if (!is_numeric($num)) {
			return '';
		}
		return $num;
	}

	public function transformMarkDown($text) {
		App::import('Vendor', 'PopularBlogPost.Parsedown');
		$Parsedown = new Parsedown();
		$result = $Parsedown->text($text);
		return $result;
	}

}
