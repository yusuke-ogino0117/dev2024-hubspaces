<?php
    $dp_options = get_desing_plus_option();

    global $header_slider;
    $header_slider = array();

    // 画像スライダー
    if ($dp_options['header_content_type'] == 'type1') {
      for ($i = 1; $i <= 20; $i++) {
        if (!is_mobile()) {
          $image = wp_get_attachment_image_src($dp_options['slider_image'.$i], 'full');
        } else {
          $image = wp_get_attachment_image_src($dp_options['slider_image_mobile'.$i], 'full');
        }
        if (!empty($image[0])) {
          $header_slider['header_content_type'] = 'type1';
          $header_slider['slider'][$i]['image'] = $image;
        }
      }

    // 動画
    } elseif ($dp_options['header_content_type'] == 'type2') {
        if ($dp_options['slider_video']) {
          $header_slider['header_content_type'] = 'type2';
          $header_slider['slider_video'] = wp_get_attachment_url($dp_options['slider_video']);
          $image = wp_get_attachment_image_src($dp_options['slider_video_image'], 'full');
          if (!empty($image[0])) {
            $header_slider['slider_video_image'] = $image;
          }
        }

    // youtube
    } elseif ($dp_options['header_content_type'] == 'type3') {
      if ($dp_options['slider_youtube_url']) {
        $header_slider['header_content_type'] = 'type3';
        $header_slider['slider_youtube_url'] = $dp_options['slider_youtube_url'];
        $image = wp_get_attachment_image_src($dp_options['slider_youtube_image'], 'full');
        if (!empty($image[0])) {
          $header_slider['slider_youtube_image'] = $image;
        }
      }
    }

    get_header();
?>
<div class="index_main_visual">
<?php
    // 画像スライダー
    if (!empty($header_slider['slider'])) :
?>
<div id="header_slider">
<?php
      $is_first_slide = true;
      foreach ($header_slider['slider'] as $i => $slider) :
        if ($dp_options['slider_url'.$i] && ($dp_options['use_slider_caption'.$i] == 0 || ($dp_options['use_slider_caption'.$i] == 1 && $dp_options['show_slider_button'.$i] == 0))) {
          $wrap_anchor = true;
        } else {
          $wrap_anchor = false;
        }
?>
 <div class="item item<?php echo esc_attr($i); ?>">
<?php   if ($wrap_anchor) { ?>
  <a href="<?php echo esc_attr($dp_options['slider_url'.$i]); ?>"<?php if ($dp_options['slider_target'.$i]) { echo ' target="_blank"'; } ?>>
<?php   } ?>
<?php   if ($dp_options['use_slider_caption'.$i] == 1) { ?>
   <div class="caption">
<?php
          if ($dp_options['slider_headline'.$i]) {
            echo '<p class="headline rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_headline'.$i])).'</p>';
          }
          if ($dp_options['slider_caption'.$i]) {
            echo '<p class="catchphrase rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_caption'.$i])).'</p>';
          }
          if ($dp_options['show_slider_button'.$i] == 1 && $dp_options['slider_button'.$i] && $dp_options['slider_url'.$i]) {
            echo '<a class="button" href="'.esc_attr($dp_options['slider_url'.$i]).'"'.($dp_options['slider_target'.$i] ? ' target="_blank"' : '').'>'.esc_html($dp_options['slider_button'.$i]).'</a>';
          } elseif ($dp_options['show_slider_button'.$i] == 1 && $dp_options['slider_button'.$i]) {
            echo '<div class="button">'.esc_html($dp_options['slider_button'.$i]).'</div>';
          }
?>
   </div><!-- END .caption -->
<?php   } ?>
<?php   if ($is_first_slide) { $is_first_slide = false; ?>
   <img src="<?php echo esc_attr($slider['image'][0]); ?>" alt="" />
<?php   } else { ?>
   <img data-lazy="<?php echo esc_attr($slider['image'][0]); ?>" alt="" />
<?php   } ?>
<?php   if ($wrap_anchor) { ?>
  </a>
<?php   } ?>
 </div><!-- END .item -->
<?php
      endforeach;
?>
</div><!-- END #header_slider -->


<!-- END #header_slider thumbnail -->



<?php
    // 動画
    elseif (!empty($header_slider['slider_video'])) :
      if (!wp_is_mobile()) : // if is pc
?>
<div id="header_slider" class="slider_video">
 <div class="slider_video_wrapper">
  <div id="slider_video" class="slider_video_container slider_video"></div>
 </div>
<?php   if ($dp_options['use_slider_video_caption'] == 1) { ?>
 <div class="caption">
<?php
          if ($dp_options['slider_video_headline']) {
            echo '<p class="headline rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_video_headline'])).'</p>';
          }
          if ($dp_options['slider_video_caption']) {
            echo '<p class="catchphrase rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_video_caption'])).'</p>';
          }
          if ($dp_options['show_slider_video_button'] == 1 && $dp_options['slider_video_button'] && $dp_options['slider_video_button_url']) {
            echo '<a class="button" href="'.esc_attr($dp_options['slider_video_button_url']).'"'.($dp_options['slider_video_button_target'] ? ' target="_blank"' : '').'>'.esc_html($dp_options['slider_video_button']).'</a>';
          } elseif ($dp_options['show_slider_video_button'] == 1 && $dp_options['slider_video_button']) {
            echo '<div class="button">'.esc_html($dp_options['slider_video_button']).'</div>';
          }
?>
 </div><!-- END .caption -->
<?php   } ?>
</div><!-- END #header_slider -->
<?php elseif (!empty($header_slider['slider_video_image'][0])) : // if is mobile device ?>
<div id="header_slider" class="slider_video_mobile">
 <div class="item">
  <img src="<?php echo esc_attr($header_slider['slider_video_image'][0]); ?>" alt="" title="" />
<?php   if ($dp_options['use_slider_video_caption'] == 1) { ?>
  <div class="caption">
<?php
          if ($dp_options['slider_video_headline']) {
            echo '<p class="headline rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_video_headline'])).'</p>';
          }
          if ($dp_options['slider_video_caption']) {
            echo '<p class="catchphrase rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_video_caption'])).'</p>';
          }
          if ($dp_options['show_slider_video_button'] == 1 && $dp_options['slider_video_button'] && $dp_options['slider_video_button_url']) {
            echo '<a class="button" href="'.esc_attr($dp_options['slider_video_button_url']).'"'.($dp_options['slider_video_button_target'] ? ' target="_blank"' : '').'>'.esc_html($dp_options['slider_video_button']).'</a>';
          } elseif ($dp_options['show_slider_video_button'] == 1 && $dp_options['slider_video_button']) {
            echo '<div class="button">'.esc_html($dp_options['slider_video_button']).'</div>';
          }
?>
  </div><!-- END .caption -->
<?php   } ?>
 </div><!-- END .item -->
</div><!-- END #header_slider -->
<?php
      endif;

    // youtube
    elseif (!empty($header_slider['slider_youtube_url'])) :
      if (!wp_is_mobile()) : // if is pc
?>
<div id="header_slider" class="slider_video">
 <div class="slider_video_wrapper">
  <div id="slider_video" class="slider_video_container slider_youtube"></div>
  <div id="slider_youtube" class="player youtube_video_player" data-property="{videoURL:'<?php echo esc_attr($header_slider['slider_youtube_url']); ?>',containment:'#slider_video',showControls:false,startAt:0,mute:true,autoPlay:true,loop:true,opacity:1,ratio:'16/9'}"></div>
 </div>
<?php   if ($dp_options['use_slider_youtube_caption'] == 1) { ?>
 <div class="caption">
<?php
          if ($dp_options['slider_youtube_headline']) {
            echo '<p class="headline rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_youtube_headline'])).'</p>';
          }
          if ($dp_options['slider_youtube_caption']) {
            echo '<p class="catchphrase rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_youtube_caption'])).'</p>';
          }
          if ($dp_options['show_slider_youtube_button'] == 1 && $dp_options['slider_youtube_button'] && $dp_options['slider_youtube_button_url']) {
            echo '<a class="button" href="'.esc_attr($dp_options['slider_youtube_button_url']).'"'.($dp_options['slider_youtube_button_target'] ? ' target="_blank"' : '').'>'.esc_html($dp_options['slider_youtube_button']).'</a>';
          } elseif ($dp_options['show_slider_youtube_button'] == 1 && $dp_options['slider_youtube_button']) {
            echo '<div class="button">'.esc_html($dp_options['slider_youtube_button']).'</div>';
          }
?>
 </div><!-- END .caption -->
<?php   } ?>
</div><!-- END #header_slider -->
<?php elseif (!empty($header_slider['slider_youtube_image'][0])) : // if is mobile device ?>
<div id="header_slider" class="slider_video_mobile">
 <div class="item">
  <img src="<?php echo esc_attr($header_slider['slider_youtube_image'][0]); ?>" alt="" title="" />
<?php   if ($dp_options['use_slider_youtube_caption'] == 1) { ?>
  <div class="caption">
<?php
          if ($dp_options['slider_youtube_headline']) {
            echo '<p class="headline rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_youtube_headline'])).'</p>';
          }
          if ($dp_options['slider_youtube_caption']) {
            echo '<p class="catchphrase rich_font">'.str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($dp_options['slider_youtube_caption'])).'</p>';
          }
          if ($dp_options['show_slider_youtube_button'] == 1 && $dp_options['slider_youtube_button'] && $dp_options['slider_youtube_button_url']) {
            echo '<a class="button" href="'.esc_attr($dp_options['slider_youtube_button_url']).'"'.($dp_options['slider_youtube_button_target'] ? ' target="_blank"' : '').'>'.esc_html($dp_options['slider_youtube_button']).'</a>';
          } elseif ($dp_options['show_slider_youtube_button'] == 1 && $dp_options['slider_youtube_button']) {
            echo '<div class="button">'.esc_html($dp_options['slider_youtube_button']).'</div>';
          }
?>
  </div><!-- END .caption -->
<?php   } ?>
 </div><!-- END .item -->
</div><!-- END #header_slider -->
<?php
      endif;
    endif;
?>

<?php
    if (is_show_custom_search_form(true)) :
?>
<div id="index_search">
  <div class="index_search_wrapper">
  <div class="index_search_ttl">
    <h3>オフィスを探すgensen_tcd050_child_202310</h3>
    <p>
    全
    <span>
    <?php
      $count_post = wp_count_posts('space');
      echo $count_post->publish;
    ?>
    </span>
    拠点</p>
  </div>
  <div class="tab_container">
    <input id="tab1" type="radio" name="tab_item" checked>
    <label class="tab_item tab__1" for="tab1">エリアから探す</label>
    <input id="tab2" type="radio" name="tab_item">
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
<?php
    endif;
?>
</div>

<div id="main_col">

<?php if( !get_field('no_display_top_1',10800) ) { ?>
<div class="ad_container">
  <h2>ハブスペおすすめオフィス</h2>
  <div class="inner">
    <div class="ad_block">
      <?php if( !get_field('no_display_top_1',10800) ) { ?>
        <a href="<?php the_field('bnr_top_url_1',10800); ?>">
          <?php if( get_field('bnr_top_image_1',10800) ) { ?>
            <img src="<?php the_field('bnr_top_image_1',10800); ?>" alt="topバナー1">
          <?php }else{ ?>
            <p><?php the_field('bnr_top_1',10800); ?></p>
          <?php } ?>
        </a>
      <?php } ?>
    </div>
    <div class="ad_block">
      <?php if( !get_field('no_display_top_2',10800) ) { ?>
        <a href="<?php the_field('bnr_top_url_2',10800); ?>">
          <?php if( get_field('bnr_top_image_2',10800) ) { ?>
            <img src="<?php the_field('bnr_top_image_2',10800); ?>" alt="topバナー2">
          <?php }else{ ?>
            <p><?php the_field('bnr_top_2',10800); ?></p>
          <?php } ?>
        </a>
      <?php } ?>
    </div>
    <div class="ad_block">
      <?php if( !get_field('no_display_top_3',10800) ) { ?>
        <a href="<?php the_field('bnr_top_url_3',10800); ?>">
          <?php if( get_field('bnr_top_image_3',10800) ) { ?>
            <img src="<?php the_field('bnr_top_image_3',10800); ?>" alt="topバナー3">
          <?php }else{ ?>
            <p><?php the_field('bnr_top_3',10800); ?></p>
          <?php } ?>
        </a>
      <?php } ?>
    </div>
    <div class="ad_block">
      <?php if( !get_field('no_display_top_4',10800) ) { ?>
        <a href="<?php the_field('bnr_top_url_4',10800); ?>">
          <?php if( get_field('bnr_top_image_4',10800) ) { ?>
            <img src="<?php the_field('bnr_top_image_4',10800); ?>" alt="topバナー4">
          <?php }else{ ?>
            <p><?php the_field('bnr_top_4',10800); ?></p>
          <?php } ?>
        </a>
      <?php } ?>
    </div>
    <div class="ad_block">
      <?php if( !get_field('no_display_top_5',10800) ) { ?>
        <a href="<?php the_field('bnr_top_url_5',10800); ?>">
          <?php if( get_field('bnr_top_image_5',10800) ) { ?>
            <img src="<?php the_field('bnr_top_image_5',10800); ?>" alt="topバナー5">
          <?php }else{ ?>
            <p><?php the_field('bnr_top_5',10800); ?></p>
          <?php } ?>
        </a>
      <?php } ?>
    </div>
  </div>
</div>
<?php } ?>

<!-- サービスオフィス最大手リージャス特集 -->
<?php if (get_field('top_ttl_1' ,10800)) : ?>
<div class="workstyle inner">
  <h2>サービスオフィス特集</h2>
  <div class="workstyle_inner">
  <?php
  for($regus_id = 1; $regus_id <= 9; $regus_id++){
    if ( get_field('top_ttl_'.$regus_id ,10800) ){
      $regus_count =  $regus_id;
    };
  }
  for($regus_i = 1; $regus_i <= $regus_count; $regus_i++):
  ?>
    <a href="<?php the_field('top_regus_url_'.$regus_i ,10800); ?>">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="<?php the_field('top_img_'.$regus_i ,10800); ?>" alt="<?php the_field('top_ttl_'.$regus_i ,10800) ; ?>">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3><?php the_field('top_ttl_'.$regus_i ,10800) ; ?></h3>
            <p><?php the_field('top_desc_'.$regus_i ,10800) ; ?></p>
          </div>
        </div>
      </div>
    </a>
  <?php
  endfor;
  ?>
  </div>
</div>
<?php endif; ?>

<div class="pr-container">
  <h2>掲載企業</h2>
  <img src="<?php echo home_url(); ?>/wp-content/uploads/2020/08/logo_list_new.jpg" alt="掲載施設Logo" style="width:80%">
</div>

<!-- 口コミランキングから選ぶ -->
<div class="workstyle inner">
  <!-- <h2>理想を叶えるオフィスは</br>Hub Spacesで！</br></br>気になったオフィスは</br><u>お気に入り登録や閲覧履歴から振り返れます</u></h2>
  <p class="intro">エリアや値段だけでなく、職種・用途・設備などあなたのこだわりに合わせたスペースが検索できます。</p> -->
  <p class="icon"><i class="fas fa-suitcase"></i></p>
  <h2>口コミランキングから選ぶ</h2>
  <div class="workstyle_inner">
  <?php
  for($post_rank_id = 1; $post_rank_id <= 9; $post_rank_id++){
    if ( get_field('post_id_'.$post_rank_id,10800) ){
      $post_count =  $post_rank_id;
    };
  }
  for($post_rank = 1; $post_rank <= $post_count; $post_rank++):
  ?>
    <a href="<?php echo get_permalink( get_field('post_id_'.$post_rank ,10800) ); ?>">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id( get_field('post_id_'.$post_rank ,10800) )); ?>" alt="<?php echo get_post( get_field('post_id_'.$post_rank ,10800) )->post_title; ?>">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3><?php echo get_post( get_field('post_id_'.$post_rank ,10800) )->post_title; ?></h3>
          </div>
        </div>
      </div>
    </a>
  <?php
  endfor;
  ?>
  </div>
  <div class="archive_link">
    <a href="<?php echo esc_url(home_url('/')); ?>ranking/">他エリアのランキングを見る</a>
  </div>
</div>

<!-- 職種別のコワーキングスペース -->
<div class="workstyle inner">
  <p class="icon"><i class="fas fa-suitcase"></i></p>
  <h2>職種別のコワーキングスペース</h2>
  <div class="workstyle_inner">
    <a href="https://hubspaces.jp/space/?search_cat1=7&filter=1&filter_tag%5B%5D=97">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="/wp-content/uploads/2019/10/主婦向け.jpg" alt="主婦向け">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3>女性・主婦向け</h3>
            保育施設や忙しい女性のためのサービスも充実。オシャレなスペースでお仕事をするのはいかがですか？
          </div>
        </div>
      </div>
    </a>
    <a href="https://hubspaces.jp/space/?search_cat1=7&filter=1&filter_tag%5B%5D=98">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="/wp-content/uploads/2019/10/リモートワーカー.jpg" alt="リモートワーカー向け">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3>リモートワーカー向け</h3>
            フリーランス、出張先や営業後の作業など、リモートワーカー向け、拠点数の多いオフィスを集めました。
          </div>
        </div>
      </div>
    </a>
    <a href="https://hubspaces.jp/space/?search_cat1=7&filter=1&filter_tag%5B%5D=99">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="/wp-content/uploads/2019/10/起業.jpg" alt="起業">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3>起業家向け</h3>
            法人登記や電話代行など起業初期の会社にとっては嬉しいサービスも充実。きれいなオフィスで打ち合わせも！
          </div>
        </div>
      </div>
    </a>
    <a href="https://hubspaces.jp/space/?search_cat1=7&filter=1&filter_tag%5B%5D=100">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="/wp-content/uploads/2019/10/制作.jpg" alt="デザイナー">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3>デザイナー向け</h3>
            複合機やPC貸出サービスなども充実。オシャレな空間でクリエイティブな仕事をしたい方は必見です。
          </div>
        </div>
      </div>
    </a>
    <a href="https://hubspaces.jp/space/?search_cat1=7&filter=1&filter_tag%5B%5D=101">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="/wp-content/uploads/2019/10/学生.jpg" alt="学生">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3>学生向け</h3>
            カフェとしてご利用の場合や就活生の人脈作りにも最適。自己投資の勉強場所としての拠点を得たい方におすすめです。
          </div>
        </div>
      </div>
    </a>
    <a href="https://hubspaces.jp/space/?search_cat1=7&filter=1&filter_tag%5B%5D=102">
      <div class="workstyle_item">
        <div class="left_item">
          <img src="/wp-content/uploads/2019/10/開発.jpg" alt="エンジニア向け">
        </div>
        <div class="right_item">
          <div class="right_item_inner">
            <h3>エンジニア向け</h3>
            モニターの貸し出し、ウェブ会議のしやすいオフィス。エンジニアが多くいるので、コミュニティ形成もできます。
          </div>
        </div>
      </div>
    </a>
  </div>
</div>

<?php
    if ($dp_options['show_index_news']) :
      $args = array('post_type' => $dp_options['news_slug'], 'ignore_sticky_posts' => 1, 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => $dp_options['index_news_num']);
      $post_list = get_posts($args);
      if ($post_list) :
?>
<div>
 <div class="inner">
  <div id="news_wrapper">
  <p class="icon"><i class="fas fa-info"></i></p>
  <h2>お知らせ</h2>
   <ol class="news_list">
<?php     foreach ($post_list as $post) : setup_postdata($post); ?>
    <li class="news_list_item">
      <a class="recent_news_link" href="<?php echo get_permalink(); ?>" >
        <div class="news_list_item_image">
          <div class="news_image_inner">
            <img src="<?php if( get_the_post_thumbnail_url() ){ 
                echo get_the_post_thumbnail_url(); }
              else{
                echo get_stylesheet_directory_uri().'/images/noimage.png' ;
              } ?>" alt="<?php the_title(); ?>">
          </div>
        </div>
        <div class="news_list_item_inner">
      <?php if ($dp_options['show_index_news_date']) : ?>
          <time class="entry-date updated" datetime="<?php the_modified_time('c'); ?>"><i class="fas fa-table"></i> <?php the_time('Y.m.d'); ?></time>
      <?php endif; ?>
          <h3><?php trim_title(50); ?></h3>
          <p><?php if(mb_strlen(get_the_content(), 'UTF-8') > 100) { 
            $news_content = mb_substr(strip_tags(get_the_content()), 0, 99, 'UTF-8'); mb_substr(get_the_content(), 0, 99) ;
            echo $news_content . '…' ; } else {
            echo strip_tags(get_the_content()) ; } ?></p>
        </div>
      </a>
    </li>
<?php   endforeach; wp_reset_postdata(); ?>
   </ol>
<?php   if ($dp_options['show_index_news_archive_link'] && $dp_options['index_news_archive_link_text']) : ?>
   <div class="archive_link">
    <a href="<?php echo get_post_type_archive_link($dp_options['news_slug']); ?>"><?php echo esc_html($dp_options['index_news_archive_link_text']); ?></a>
   </div>
<?php   endif; ?>
  </div>
 </div>
</div>
<?php
      endif;
    endif;
?>

<?php
	// コンテンツビルダー
	if ( ! empty( $dp_options['contents_builder'] ) ) :
		foreach ( $dp_options['contents_builder'] as $key => $content ) :
			$cb_index = 'cb_' . $key;
			if ( empty( $content['cb_content_select'] ) ) continue;
			if ( isset( $content['cb_display'] ) && ! $content['cb_display'] ) continue;

			// 紹介コンテンツ
			if ( $content['cb_content_select'] == 'introduce' ) :
				$args = array('post_type' => $dp_options['introduce_slug'], 'posts_per_page' => '-1', 'ignore_sticky_posts' => 1, 'orderby' => 'date', 'order' => 'DESC', 'meta_key' => 'show_front_page', 'meta_value' => '1');
				if ( $content['cb_order'] == 'random' ) :
					$args['orderby'] = 'rand';
				endif;

				$cb_posts = new WP_Query($args);
				if ($cb_posts->have_posts()) :
?>

 <div id="cb_<?php echo esc_attr($key); ?>" class="cb_content cb_content-<?php echo esc_attr($content['cb_content_select']); ?> inview-fadein">
  <div class="inner">
<?php
					if ( $content['cb_headline'] ) :
						echo '   <p class="icon"><i class="fas fa-building"></i></p><h3 class="cb_headline rich_font">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_headline'] ) ) . "</h2>\n";
					endif;
					if ( $content['cb_desc'] ) :
						echo '   <p class="cb_desc">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_desc'] ) ) . "</p>\n";
					endif;
?>
   <div id="introduce_list">
    <div class="introduce_list_row inview-fadein clearfix">
<?php
					$i = 0;
					$row = 0;
					while ($cb_posts->have_posts()) :
						$cb_posts->the_post();

						if ($i > 0 && $i % 2 == 0) :
							$row++;
?>
    </div>
    <div class="introduce_list_row inview-fadein clearfix">
<?php
						endif;

						// $col_class = '';
						// if ($row % 2 == 0) :
						// 	if ($i % 3 == 0) :
						// 		$col_class = ' show_info';
						// 	endif;
						// else :
						// 	if ($i % 4 == 0) :
						// 		$col_class = ' show_info';
						// 	endif;
						// endif;
?>
     <div class="article introduce_list_col show_info">
      <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="clearfix">
       <div class="image">
        <?php if (has_post_thumbnail()) { the_post_thumbnail('size3'); } else { ?><img src="<?php echo get_template_directory_uri(); ?>/img/common/no_image3.gif" title="" alt="" /><?php } ?>
       </div>
       <div class="info">
        <?php
          if ($dp_options['show_introduce_categories']) {
            $metas = array();
            foreach(explode('-', $dp_options['show_introduce_categories']) as $cat) {
              if (!empty($dp_options['use_introduce_category'.$cat])) {
                $terms = get_the_terms($post->ID, $dp_options['introduce_category'.$cat.'_slug']);
                if ($terms && !is_wp_error($terms)) {
                  $term = array_shift($terms);
                  $metas[] = '<li class="cat"><span class="cat-'.esc_attr($dp_options['introduce_category'.$cat.'_slug']).'" data-href="'.get_term_link($term).'" title="'.esc_attr($term->name).'">'.esc_html($term->name).'</span></li>';
                }
              }
            }
            if ($metas) {
              echo '<ul class="meta clearfix">'.implode('', $metas).'</ul>';
            }
          }
        ?>
        <h3 class="title"><?php if ( is_mobile() ) { echo wp_trim_words( get_the_title(), 25, '...' ); } else { trim_title(32); } ?></h2>
        <p class="excerpt"><?php new_excerpt(148); ?></p>
        <p class="more"><?php _e('Read more', 'tcd-w'); ?></p>
       </div>
      </a>
     </div>
<?php
						$i++;
					endwhile;
					wp_reset_postdata();
?>
    </div>
   </div>
  </div>
 </div>

<?php
				endif;

			//カルーセルスライダー
			elseif ( $content['cb_content_select'] == 'carousel' ) :
				$args = array('post_type' => 'post', 'posts_per_page' => $content['cb_post_num'], 'ignore_sticky_posts' => 1, 'orderby' => 'date', 'order' => 'DESC');

				if ($content['cb_post_type'] == 'introduce') :
					$args['post_type'] = $dp_options['introduce_slug'];
					// タクソノミーターム
					if ($content['cb_introduce_term']) :
						$term = get_term($content['cb_introduce_term']);
						if ($term && !is_wp_error($term)) :
							$args['tax_query'][] = array('taxonomy' => $term->taxonomy, 'field' => 'term_id', 'terms' => array($term->term_id), 'operator' => 'IN');
						endif;
					endif;
				else :
					if ($content['cb_list_type'] == 'recommend_post' || $content['cb_list_type'] == 'recommend_post2') :
						$args['orderby'] = 'rand';
						$args['meta_key'] = $content['cb_list_type'];
						$args['meta_value'] = 'on';
					endif;
				endif;

				$cb_posts = new WP_Query($args);
				if ($cb_posts->have_posts()) :
?>

 <div id="cb_<?php echo esc_attr($key); ?>" class="cb_content cb_content-<?php echo esc_attr($content['cb_content_select']); ?> inview-fadein" style="background-color:<?php echo esc_attr($content['cb_background_color']); ?>">
  <div class="inner">
<?php
					if ( $content['cb_headline'] ) :
						echo '   <h2 class="cb_headline rich_font">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_headline'] ) ) . "</h2>\n";
					endif;
					if ( $content['cb_desc'] ) :
						echo '   <p class="cb_desc">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_desc'] ) ) . "</p>\n";
					endif;
?>
   <div class="carousel">
<?php

					while ($cb_posts->have_posts()) :
						$cb_posts->the_post();
?>
    <div class="article item">
     <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
      <div class="image">
       <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'size2' ); } else { ?><img src="<?php echo get_template_directory_uri(); ?>/img/common/no_image2.gif" title="" alt="" /><?php } ?>
       <h3 class="title"><?php trim_title( 34 ); ?></h2>
      </div>
      <p class="excerpt"><?php new_excerpt( 90 ); ?></p>
     </a>
    </div>
<?php
					endwhile;
					wp_reset_postdata();
?>
   </div>
  </div>
 </div>

<?php
				endif;

			// カテゴリーリスト
			elseif ( $content['cb_content_select'] == 'category_list' ) :
				if ( $content['cb_categories'] && is_array( $content['cb_categories'] ) ) :
					$terms = array();
					foreach($content['cb_categories'] as $term_id) :
						$term = get_term($term_id);
						if ($term && !is_wp_error($term)) :
							$terms[] = $term;
						endif;
					endforeach;
					if ( $terms ) :
?>

 <div id="cb_<?php echo esc_attr($key); ?>" class="cb_content cb_content-<?php echo esc_attr($content['cb_content_select']); ?> inview-fadein">
  <div class="inner">
<?php
						if ( $content['cb_headline'] ) :
							echo '   <h2 class="cb_headline rich_font">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_headline'] ) ) . "</h2>\n";
						endif;
						if ( $content['cb_desc'] ) :
							echo '   <p class="cb_desc">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_desc'] ) ) . "</p>\n";
						endif;

						echo '   <ul class="clearfix">';
						foreach( $terms as $term ) {
							// カテゴリー画像
							$image = null;
							$term_meta = get_option( 'taxonomy_' . $term->term_id );
							if ( !empty( $term_meta['image'] ) ) :
								$image = wp_get_attachment_image_src( $term_meta['image'], 'size3' );
							endif;

							if ( !empty( $image[0] ) ) :
								echo '    <li class="has_image">';
								echo '<a href="' . get_term_link($term) . '">';
								echo '<div class="image"><img src="' . esc_attr( $image[0] ) . '" alt=""></div>';
							else :
								echo '    <li>';
								echo '<a href="' . get_term_link($term) . '">';
							endif;

							echo '<div class="info"><h2>' . esc_html( $term->name ) . '</h2>';
							if ( $term->description ) :
								echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $term->description ) );
							endif;
							echo "</div></a></li>\n";
						}
						echo "</ul>\n";
?>
  </div>
 </div>

<?php
					endif;
				endif;

			// 最新ブログ記事一覧
			elseif ( $content['cb_content_select'] == 'blog_list' ) :
				$args = array( 'post_type' => 'post', 'posts_per_page' => $content['cb_post_num'], 'ignore_sticky_posts' => 1, 'orderby' => 'date', 'order' => 'DESC' );
				if ( isset( $content['cb_list_type'] ) ) :
					if ( $content['cb_list_type'] == 'recommend_post' || $content['cb_list_type'] == 'recommend_post2' ) :
						$args['meta_key'] = $content['cb_list_type'];
						$args['meta_value'] = 'on';
					elseif ( $content['cb_post_term'] ) :
						$term = get_term( $content['cb_post_term'] );
						if ( $term && !is_wp_error( $term ) ) :
							$args['tax_query'][] = array( 'taxonomy' => $term->taxonomy, 'field' => 'term_id', 'terms' => array($term->term_id), 'operator' => 'IN' );
						endif;
					endif;
					if ( $content['cb_order'] == 'random' ) :
						$args['orderby'] = 'rand';
					elseif ( $content['cb_order'] == 'date2' ) :
						$args['order'] = 'ASC';
					endif;
				endif;

				$cb_posts = new WP_Query($args);
				if ($cb_posts->have_posts()) :
?>

 <div id="cb_<?php echo esc_attr($key); ?>" class="cb_content cb_content-<?php echo esc_attr($content['cb_content_select']); ?> inview-fadein">
  <div class="inner">
<?php
					if ( $content['cb_headline'] ) :
						echo '   <h2 class="cb_headline rich_font">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_headline'] ) ) . "</h2>\n";
					endif;
					if ( $content['cb_desc'] ) :
						echo '   <p class="cb_desc">' . str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $content['cb_desc'] ) ) . "</p>\n";
					endif;
?>
   <ol id="post_list" class="inview-fadein clearfix">
<?php
					while ($cb_posts->have_posts()) :
						$cb_posts->the_post();
?>
    <li class="article">
     <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
      <div class="image">
       <?php if ( has_post_thumbnail()) { the_post_thumbnail( 'size2' ); } else { ?><img src="<?php echo get_template_directory_uri(); ?>/img/common/no_image2.gif" title="" alt="" /><?php } ?>
      </div>
      <h3 class="title js-ellipsis"><?php the_title(); ?></h2>
      <?php
        $metas = array();
        if ($dp_options['show_categories']) {
          foreach(explode('-', $dp_options['show_categories']) as $cat) {
            if ($cat == 1) {
              $terms = get_the_terms($post->ID, 'category');
              if ($terms && !is_wp_error($terms)) {
                $term = array_shift($terms);
                $metas[] = '<li class="cat"><span class="cat-category" data-href="'.get_term_link($term).'" title="'.esc_attr($term->name).'">'.esc_html($term->name).'</span></li>';
              }
            } elseif (!empty($dp_options['use_category'.$cat])) {
              $terms = get_the_terms($post->ID, $dp_options['category'.$cat.'_slug']);
              if ($terms && !is_wp_error($terms)) {
                $term = array_shift($terms);
                $metas[] = '<li class="cat"><span class="cat-'.esc_attr($dp_options['category'.$cat.'_slug']).'" data-href="'.get_term_link($term).'" title="'.esc_attr($term->name).'">'.esc_html($term->name).'</span></li>';
              }
            }
          }
        }
        if ($dp_options['show_date']) {
          $metas[] = '<li class="date"><time class="entry-date updated" datetime="'.get_the_modified_time('c').'">'.get_the_time('Y.m.d').'</time></li>';
        }

        if ($metas) {
          echo '<ul class="meta clearfix">'.implode('', $metas).'</ul>';
        }
?>
     </a>
    </li>
<?php
					endwhile;
					wp_reset_postdata();
?>
   </ol>
<?php
					if ( $content['cb_show_archive_link'] && $content['cb_archive_link_text'] && get_post_type_archive_link('post') != get_bloginfo( 'url' ) ) :
?>
   <div class="archive_link">
    <a href="<?php echo get_post_type_archive_link('post'); ?>"><?php echo esc_html($content['cb_archive_link_text']); ?></a>
   </div>
<?php
					endif;
?>
  </div>
 </div>

<?php
				endif;

			//フリースペース
			elseif ( $content['cb_content_select'] == 'wysiwyg' ) :
				$cb_wysiwyg_editor = apply_filters( 'the_content', $content['cb_wysiwyg_editor'] );
				if ( $cb_wysiwyg_editor ) :
?>

 <div id="cb_<?php echo esc_attr($key); ?>" class="cb_content cb_content-<?php echo esc_attr($content['cb_content_select']); ?>">
  <div class="inner">
   <div class="post_content clearfix">
    <?php echo $cb_wysiwyg_editor; ?>
   </div>
  </div>
 </div>

<?php
				endif;
			endif;

		endforeach;
	endif;
?>

</div><!-- END #main_col -->

<?php get_footer(); ?>
