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
<script type="text/javascript">
$(function(){
	$("#PopularBlogPostUpdateDateBeginDate").change(function(){
		if ($("#PopularBlogPostUpdateDateBeginDate").val()) {
			// 開始日を入力したら、終了日欄に指定月の末尾を設定する
			var date = new Date($("#PopularBlogPostUpdateDateBeginDate").val());
			var year = date.getFullYear();
			var month = add0(date.getMonth() + 1);
			var day = add0(date.getDate());

			var updateBeginTime = '00:00:00';
			$("#PopularBlogPostUpdateDateBeginTime").val(updateBeginTime);

			// var targetDate = year + '/' + month + '/' + day;
			var monthEndDay = getMonthEndDay(year, month);
			var monthEndDate = year + '/' + month + '/' + monthEndDay;
			$("#PopularBlogPostUpdateDateEndDate").val(monthEndDate);
			var updateEndTime = '23:59:59';
			$("#PopularBlogPostUpdateDateEndTime").val(updateEndTime);
		}
	});

	/**
	 * 0埋めで2桁にする
	 * 
	 * @param str string
	 * @returns string
	 */
	function add0(str){
		return ("0" + str).substr(-2);
	}
	/**
	 * 年月を指定して月末日を求める関数
	 * 
	 * @param {string} year 年
	 * @param {string} month 月
	 */
	function getMonthEndDay(year, month) {
		// 通常、new Date()にはmonth - 1を渡すところ、monthをそのまま渡す。
		// するとそのままでは次月の指定になるが、日に0を指定すると前月の末日の指定になる。
		// これによって任意年月の末日を得る。
		var dt = new Date(year, month, 0);
		return dt.getDate();
	}
});
</script>

<?php echo $this->BcForm->create('PopularBlogPost', array('url' => array('action' => 'index'))) ?>
<p>
	<span>
		<?php echo $this->BcForm->label('PopularBlogPost.blog_content_id', 'ブログ') ?>
		&nbsp;<?php echo $this->BcForm->input('PopularBlogPost.blog_content_id', array('type' => 'select', 'options' => $blogContentDatas)) ?>
	</span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<span><?php echo $this->BcForm->label('PopularBlogPost.update_date_begin', '期間') ?></span>
		<?php echo $this->BcForm->dateTimePicker('PopularBlogPost.update_date_begin', array('size' => 12), true) ?> 〜 
		<?php echo $this->BcForm->dateTimePicker('PopularBlogPost.update_date_end', array('size' => 12), true) ?>
</p>
<div class="button">
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/btn_search.png', array('alt' => '検索', 'class' => 'btn')), "javascript:void(0)", array('id' => 'BtnSearchSubmit')) ?> 
	<?php $this->BcBaser->link($this->BcBaser->getImg('admin/btn_clear.png', array('alt' => 'クリア', 'class' => 'btn')), "javascript:void(0)", array('id' => 'BtnSearchClear')) ?> 
</div>
<?php echo $this->BcForm->end() ?>
