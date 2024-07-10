<?php
	// カスタム検索用グローバル変数
	global $wp_query, $custom_search_vars;

	get_header();
	$dp_options = get_desing_plus_option();

	// タグフィルター用ターム配列
	$tags = false;
	if ($custom_search_vars) {
		if ($dp_options['show_search_results_tag_filter'] && $dp_options['show_search_results_tag_filter'] != 'hide') {
			if ($dp_options['searcn_post_type'] == 'post') {
				$tags = get_terms('post_tag', array());
			} elseif ($dp_options['searcn_post_type'] == 'introduce') {
				$tags = get_terms($dp_options['introduce_tag_slug'], array());
			}
			if (!$tags || is_wp_error($tags)) $tags = false;
		}
	}

	// sort
	if (!empty($_REQUEST['sort']) && in_array($_REQUEST['sort'], array('date_asc', 'date_desc', 'views'))) {
		$sort = $_REQUEST['sort'];
	} else {
		$sort = 'date_desc';
	}
	$sort_base_url = remove_query_arg('sort');
	$sort_base_url = preg_replace('#/page/\d+#', '', $sort_base_url);
?>

<div class="search_head">

	<div class="archive_header">
		<div class="inner">
			<h2 class="headline rich_font">
			<?php
				function term_area($term) { 
					$term_id = $term;
					$taxonomy = 'area';
					$term = get_term($term_id, $taxonomy);
					echo $term->name.'のオフィス ';
				}
				function term_line($term) { 
					$term_id = $term;
					$taxonomy = 'line';
					$term = get_term($term_id, $taxonomy);
					echo $term->name.'のオフィス ';
				}
				if($_GET['search_element_0'][0] && !$_GET['search_element_0'][1] && $_GET['fe_form_no'] === '0'){
					echo term_area($_GET['search_element_0'][0]).$wp_query->found_posts.'選';
				}elseif($_GET['search_element_0'][1] && $_GET['fe_form_no'] === '0'){
					echo term_area($_GET['search_element_0'][1]).$wp_query->found_posts.'選';
				}elseif($_GET['search_element_0'][0] && !$_GET['search_element_0'][1] && $_GET['fe_form_no'] === '1'){
					echo term_line($_GET['search_element_0'][0]).$wp_query->found_posts.'選';
				}elseif($_GET['search_element_0'][1] && $_GET['fe_form_no'] === '1'){
					echo term_line($_GET['search_element_0'][1]).$wp_query->found_posts.'選';
				}elseif(!$_GET['search_element_0'][0] && $_GET['s_keyword_2']){
					echo $_GET['s_keyword_2'].'のオフィス '.$wp_query->found_posts.'選';
				}else{
					echo '検索結果';
				}
			?>
			</h2>
		</div>
	</div>

	<?php get_template_part('navigation2'); ?>

	<?php if ( have_posts() ) : ?>
	<dl class="archive_sort clearfix">
		<dt><?php _e('Sort condition', 'tcd-w'); ?></dt>
		<dd><a href="<?php echo esc_attr(add_query_arg('sort', 'date_desc', $sort_base_url)); ?>"<?php if ($sort == 'date_desc') echo ' class="active"'; ?>><?php _e('Newest first', 'tcd-w'); ?></a></dd>
		<dd><a href="<?php echo esc_attr(add_query_arg('sort', 'date_asc', $sort_base_url)); ?>"<?php if ($sort == 'date_asc') echo ' class="active"'; ?>><?php _e('Oldest first', 'tcd-w'); ?></a></dd>
		<dd><a href="<?php echo esc_attr(add_query_arg('sort', 'views', $sort_base_url)); ?>"<?php if ($sort == 'views') echo ' class="active"'; ?>><?php _e('Large number of views', 'tcd-w'); ?></a></dd>
	</dl>
	<?php endif; ?>

</div><!-- search head -->

<div id="index_search">
	<div class="index_search_wrapper">
	<div class="index_search_ttl">
		<h3>オフィスを探す</h3>
	</div>
	<div class="tab_container">
		<input id="tab1" type="radio" name="tab_item" <?php if($_GET['fe_form_no'] === '0'){ echo "checked"; }?>>
		<label class="tab_item tab__1" for="tab1">エリアから探す</label>
		<input id="tab2" type="radio" name="tab_item" <?php if($_GET['fe_form_no'] === '1'){ echo "checked"; }?>>
		<label class="tab_item tab__2" for="tab2">路線から探す</label>
		<div class="tab_content" id="tab1_content">
			<div class="tab_content_description">
				<div class="c-txtsp">
					<?php
					if ( function_exists( 'feas_search_form' ) ) {
						feas_search_form();
					}
					?>
				</div>
			</div>
		</div>
		<div class="tab_content" id="tab2_content">
			<div class="tab_content_description">
				<div class="c-txtsp">
					<?php
					if ( function_exists( 'feas_search_form' ) ) {
						feas_search_form(1);
					}
					?>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
<script>
(function ($) {
	$('label.tab__1').click( function() {
    $("#tab2_content form select.ajax_0_0 option[id='feas_1_0_0_none']").prop('selected', true);
		$('#tab2_content form select.ajax_0_1').remove();;
	});
	$('label.tab__2').click( function() {
    $("#tab1_content form select.ajax_0_0 option[id='feas_0_0_0_none']").prop('selected', true);
		$('#tab1_content form select.ajax_0_1').remove();;
	});
})(jQuery);
</script>

<div id="main_col" class="clearfix">

 <div id="left_col" class="custom_search_results">

<?php if ( have_posts() ) : ?>

 <ol id="post_list2">

<?php
$is = 1;
while ( have_posts() ) : the_post(); 

// 画像スライダー
$introduce_slider = array();
if ($dp_options['show_thumbnail_introduce']) {
  for ($i = 1; $i <= 20; $i++) {
    $slider_image = get_post_meta($post->ID, 'slider_image'.$i, true);
    if ($slider_image) {
      $image = wp_get_attachment_image_src($slider_image, 'post-thumbnail');
      if (!empty($image[0])) {
        $introduce_slider['slider'][$i] = $image[0];
      }
    }
  }
  if (!empty($introduce_slider['slider'])) {
    $introduce_slider['slider_time'] = get_post_meta($post->ID, 'slider_time', true);
  }
}


?>

  <li class="article">
    <div class="image-container">
			<?php if ($introduce_slider && $page == '1') { ?>
				<div id="introduce_slider" class="slick-slider<?php echo $is; ?>">
			<?php
							$is_first_slide = true;
							foreach ($introduce_slider['slider'] as $i => $slider) :
								if ($is_first_slide) {
									$is_first_slide = false;
									$img_src = 'src';
								} else {
									$img_src = 'data-lazy';
								}
								$slider_caption = get_post_meta($post->ID, 'slider_caption'.$i, true);

								echo '   <div class="item item'.$i.'">'."\n";
								echo '    <img '.$img_src.'="'.esc_attr($slider).'" alt="" />'."\n";
								echo '   </div>'."\n";
							endforeach;
			?>
				</div><!-- END #introduce_slider -->
			<?php } else if ($dp_options['show_thumbnail_introduce'] && has_post_thumbnail() && $page == '1') { ?>
				<div id="post_image">
					<?php the_post_thumbnail('post-thumbnail'); ?>
				</div>
			<?php } ?>
		</div>
		<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="clearfix search_link">
			<div class="info">
				<dl>
					<dt>オフィス名</dt>
					<dd><?php trim_title(38); ?></dd>
					<dt>営業時間</dt>
					<dd><?php the_field('businesshours'); ?></dd>
					<!-- <dt>Googleのレビュー</dt>
					<dd> -->
						<?php /* if( get_field('PlaceID') ) { ?>
						<!-- Googleローカルガイド -->
						<div id="review_wrap_top<?php echo $is; ?>" class="review_wrap_top" data-place-id="<?php the_field('PlaceID'); ?>">
							<div id="js_review_over4_rate_top<?php echo $is; ?>" class="js_review_over4_rate_top" itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
								<meta itemprop="worstRating" content="0"> 
								<meta itemprop="bestRating" content="5"> 
							</div>
							<div id="js_review_over4_top<?php echo $is; ?>" class="js_review_over4_top"></div>
						</div>
						<?php }else{ ?>
							<span>口コミはありません</span>
						<?php } */?>
					<!-- </dd> -->
					<?php
					if( get_field('price-ttl') ) { ?>
					<dt>1人あたりの月額料金</dt>
					<dd>
						<?php if( mb_strlen(get_field('price-ttl')) > 75 ) { 
							$stationtxt = mb_substr(get_field('price-ttl'),0,74) ; 
							echo $stationtxt . '…' ;
							} else { the_field('price-ttl'); }
						?>
					</dd>
					<?php } ?>
					<?php if( get_field('accesstext') ) { ?>
					<dt>アクセス</dt>
					<dd>
					<?php if( mb_strlen(get_field('accesstext')) > 75 ) { 
						$stationtxt = mb_substr(get_field('accesstext'),0,74) ; 
						echo $stationtxt . '…' ;
						} else { the_field('accesstext'); }
					?>
					</dd>
					<?php } ?>
				</dl>
			</div>
    </a>
		<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="detail-btn">詳細はこちら <i class="fas fa-chevron-right"></i></a>
  </li>

<?php
$is++;
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

<script>
(function ($) {

	$('label.tab__1').click( function() {
    $("#tab2_content form select.ajax_0_0 option[id='feas_1_0_0_none']").prop('selected', true);
		$('#tab2_content form select.ajax_0_1').remove();;
	});
	$('label.tab__2').click( function() {
    $("#tab1_content form select.ajax_0_0 option[id='feas_0_0_0_none']").prop('selected', true);
		$('#tab1_content form select.ajax_0_1').remove();;
	});

	$("#toggle_search i").click(function(){
		$(this).toggleClass('fa-toggle-on');
  	$(".search_tag").slideToggle();
	});

	// スライダー
	for (var i = 1; i < <?php echo $is ?>; i++) {
		$('.slick-slider' + i).on('init', function(event, slick) {
			$(this).append('<div class="slick-counter"><span class="current"></span> / <span class="total"></span></div>');
			$('.slick-slider' + i +' .current').text(slick.currentSlide + 1);
			$('.slick-slider' + i +' .total').text(slick.slideCount);
		})
		.slick({
			infinite: true,
			dots: false,
			arrows: true,
			prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
			nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
			slidesToShow: 1,
			slidesToScroll: 1,
			adaptiveHeight: true,
			lazyLoad: 'progressive'
		})
		.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
				$(this).find('.current').text(nextSlide + 1);
		});
	}

	// // Googleレビュー	
	// for (var i = 1; i < <?php echo $is ?>; i++) {
	// 	const service = new google.maps.places.PlacesService(document.createElement('div'));
	// 	const $review_wrap_top = $('#review_wrap_top' + i);
	// 	const $review_over4_top = $('#js_review_over4_top' + i);
	// 	const $review_over4_rate_top = $('#js_review_over4_rate_top' + i);
		
	// 	service.getDetails({
	// 		placeId: $review_wrap_top.data('place-id'),
	// 		fields: ['review','rating']
	// 		}, function(place, status) {
	// 		if (status == google.maps.places.PlacesServiceStatus.OK && place['rating'] >= 3.5) {
	// 			$review_over4_rate_top.append('<span itemprop="ratingValue">' + place['rating'] + '</span>');
			
	// 			$review_over4_top.rateYo({
	// 				rating:  place['rating'],
	// 				starWidth: "25px",
	// 				normalFill: "#cccccc",
	// 				ratedFill: "#f8b707",
	// 				numStars: 5
	// 			});
	// 		}else {
	// 			$review_over4_top.append('<span>口コミはありません</span>');
	// 		}
	// 	});
	// }

})(jQuery);
</script>

 </ol><!-- END #post_list2 -->

<?php get_template_part('navigation2'); ?>

<?php else: ?>
 <p class="no_post"><?php _e('There is no registered post.', 'tcd-w'); ?></p>
<?php endif; ?>

</div><!-- END #left_col -->

<?php get_sidebar(); ?>

</div><!-- END #main_col -->

<?php get_template_part('breadcrumb'); ?>

<?php get_footer(); ?>
