<?php
get_header();
$dp_options = get_desing_plus_option();
?>

<div id="main_col" class="clearfix">
  <div class="archive_header">
    <div class="inner">
      <h2 class="headline rich_font">閲覧履歴</h2>
    </div>
  </div>

<ol id="post_list2" s>
<?php
global $rireki;
//履歴が現在の記事を除いて、一つでもある場合
if (!empty($rireki)){

$paged = get_query_var('paged') ?: 1;
$args = array(
	'post__in' => $rireki,
	'orderby' => 'post__in',
	'post_type' => 'space',
	'paged' => $paged
);
$the_query = new WP_Query($args);

if ( $the_query->have_posts() ) :
$is = 1;
while ( $the_query->have_posts() ) : $the_query->the_post();

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
					<dt>Googleのレビュー</dt>
					<dd>
						<?php if( get_field('PlaceID') ) { ?>
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
						<?php } ?>
					</dd>
					<?php
					if( get_field('price-ttl') ) { ?>
					<dt>月額料金</dt>
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

	// Googleレビュー	
    for (var i = 1; i < <?php echo $is ?>; i++) {
      const service = new google.maps.places.PlacesService(document.createElement('div'));
      const $review_wrap_top = $('#review_wrap_top' + i);
      const $review_over4_top = $('#js_review_over4_top' + i);
      const $review_over4_rate_top = $('#js_review_over4_rate_top' + i);
      
      service.getDetails({
        placeId: $review_wrap_top.data('place-id'),
        fields: ['review','rating']
        }, function(place, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK && place['rating'] >= 3.5) {
          $review_over4_rate_top.append('<span itemprop="ratingValue">' + place['rating'] + '</span>');
        
          $review_over4_top.rateYo({
            rating:  place['rating'],
            starWidth: "25px",
            normalFill: "#cccccc",
            ratedFill: "#f8b707",
            numStars: 5
          });
        }else {
          $review_over4_top.append('<span>口コミはありません</span>');
        }
      });
    }

})(jQuery);
</script>

 </ol><!-- END #post_list2 -->

<div class="pagenation">
	<?php
		if ($the_query->max_num_pages > 1) {
				echo paginate_links(array(
						'base' => get_pagenum_link(1) . '%_%',
						'type' => 'list',
						'format' => 'page/%#%/',
						'prev_text' => '<i class="fas fa-chevron-left"></i>',
						'next_text' => '<i class="fas fa-chevron-right"></i>',
						'current' => max(1, $paged),
						'total' => $the_query->max_num_pages
				));
		}
		wp_reset_postdata();
	?>
</div>

<?php
endif;
wp_reset_postdata();
}else{ ?>
<p style="font-size: 1rem;">現在、閲覧履歴はありません。</p>
<?php } ?>

<button id="rireki-del" style="margin-top: 30px; float: right;">履歴を全て削除する</button>
<script>
jQuery(function ($) {
  $('#rireki-del').click(function () {
    $.removeCookie('rireki', {
      path: '/'
    });
    location.reload();
  });
});
</script>

</div>

<?php get_footer(); ?>