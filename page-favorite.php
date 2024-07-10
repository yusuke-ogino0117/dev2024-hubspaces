<?php
get_header();
$dp_options = get_desing_plus_option();
?>

<?php
while ( have_posts() ) : the_post(); 

?>

<div id="main_col" class="clearfix">

  <div class="archive_header">
    <div class="inner">
      <h2 class="headline rich_font">お気に入り</h2>
    </div>
  </div>

<script type="text/javascript">
jQuery(function(){
  jQuery('.reverseBtn').click(function(){
    jQuery('#post_list2 .favorites-list').html(jQuery('#post_list2 .favorites-list .article').get().reverse());
    event.preventDefault();
    jQuery(this).toggleClass('reverse');
  })
});
</script>
<style>
.reverseBtn {
  display: inline-block;
  padding: 15px 0;
  font-weight: bold;
  text-align: center;
  font-size: 1rem;
}
a.reverseBtn:hover {
  opacity: 0.8;
}
.reverseBtn > span:last-of-type,
.reverseBtn.reverse > span:first-of-type {
  display: none;
}
.reverseBtn.reverse > span:last-of-type {
  display: inline;
}
</style>
	<div class='btnWrapper clearfix'>
			<a class="reverseBtn" href="#">
					<span><i class="fas fa-arrow-up"></i> 登録が新しい順に表示</span>
					<span><i class="fas fa-arrow-down"></i> 登録が古い順に表示</span>
			</a>
	</div>

	<ol id="post_list2">
		<?php the_content(); ?>
	</ol>

</div>

<?php
endwhile;
?>

<style>
.review_wrap_top {
	display: flex;
	align-items: center;
	flex-wrap: wrap;
	line-height: 1.8;
}
.review_wrap_top > span {
	padding-right: 5px;
}
.js_review_over4_rate_top {
	color: #E7711B;
	font-size: 17px;
	padding-top: 4px;
	color: #E7711B;
  font-size: 17px;
  padding-top: 4px;
}
.js_review_over4_top{
	pointer-events: none;
}
#introduce_slider.slick-slider .slick-list{
	height: 320px !important;
}
#introduce_slider.slick-slider .slick-list img{
	height: 300px !important;
}
@media screen and ( max-width:1024px ){
	#introduce_slider{
		margin-bottom: 0 !important;
	}
	#introduce_slider.slick-slider .slick-list{
		height: 230px !important;
	}
	#introduce_slider.slick-slider .slick-list .slick-track{
		height: 100% !important;
	}
	#introduce_slider.slick-slider .slick-list img{
		height: 100% !important;
	}
}
</style>


<?php get_footer(); ?>