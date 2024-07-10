<?php
    get_header();
    $dp_options = get_desing_plus_option();

    function areacount($area) { 
      if(!empty(get_term_by('slug', $area , 'area_ranking' )->count)){
        echo get_term_by('slug', $area , 'area_ranking' )->count;
      }else{
        echo 0;
      };
    }

    $post_terms = get_queried_object();
    $post_terms_name = $post_terms->name;
    $post_terms_slug = $post_terms->slug;
    $tokyo_terms = get_term_by('slug', 'tokyo', 'area_ranking' );
    $tokyo_terms_id = $tokyo_terms->term_id;

    $post_terms_parent = $post_terms->parent;
    if ( $post_terms_parent ) {
      $term_parent_object = get_term_by( 'id', $post_terms_parent, 'area_ranking' );
      $post_terms_slug_parent = $term_parent_object->slug;
    }
?>

<div id="main_col">

<div class="japan_map_container">
  <div class="japan_map">
    <div class="main_catch">
    <h2 class="ranking_ttl search_ttl"><i class="fas fa-search"></i> エリアから<br class="show-sp">ランキングを探す</h3>
    全国 <span><?php echo wp_count_posts( 'ranking' )->publish; ?></span>箇所のランキング掲載！
    </div>
    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/japan_map.png" alt="日本地図">
    <span class="area_btn area1" data-area="1">北海道・東北</span>
    <span class="area_btn area2" data-area="2">関東</span>
    <span class="area_btn area3" data-area="3">中部</span>
    <span class="area_btn area4" data-area="4">近畿</span>
    <span class="area_btn area5" data-area="5">中国・四国</span>
    <span class="area_btn area6" data-area="6">九州・沖縄</span>
    
    <div class="area_overlay"></div>
    <div class="pref_area">
      <div class="pref_list" data-list="1">
        
        <div data-id="hokkaido">北海道（<?php echo areacount('hokkaido'); ?>）</div>
        <div data-id="aomori">青森県（<?php echo areacount('aomori'); ?>）</div>
        <div data-id="iwate">岩手県（<?php echo areacount('iwate'); ?>）</div>
        <div data-id="miyagi">宮城県（<?php echo areacount('miyagi'); ?>）</div>
        <div data-id="akita">秋田県（<?php echo areacount('akita'); ?>）</div>
        <div data-id="yamagata">山形県（<?php echo areacount('yamagata'); ?>）</div>
        <div data-id="fukushima">福島県（<?php echo areacount('fukushima'); ?>）</div>
        <div></div>
      </div>
      
      <div class="pref_list" data-list="2">
        <div data-id="ibaragi">茨城県（<?php echo areacount('ibaragi'); ?>）</div>
        <div data-id="tochigi">栃木県（<?php echo areacount('tochigi'); ?>）</div>
        <div data-id="gunma">群馬県（<?php echo areacount('gunma'); ?>）</div>
        <div data-id="saitama">埼玉県（<?php echo areacount('saitama'); ?>）</div>
        <div data-id="chiba">千葉県（<?php echo areacount('chiba'); ?>）</div>
        <div data-id="tokyo">東京都（<?php echo areacount('tokyo'); ?>）</div>
        <div data-id="kanagawa">神奈川県（<?php echo areacount('kanagawa'); ?>）</div>
        <div></div>
      </div>
      
      <div class="pref_list" data-list="3">
        <div data-id="niigata">新潟県‎（<?php echo areacount('niigata'); ?>）</div>
        <div data-id="toyama">富山県（<?php echo areacount('toyama'); ?>）‎</div>
        <div data-id="ishikawa">石川県‎（<?php echo areacount('ishikawa'); ?>）</div>
        <div data-id="fukui">福井県（<?php echo areacount('hokkaido'); ?>）‎</div>
        <div data-id="yamanashi">山梨県（<?php echo areacount('fukui'); ?>）‎</div>
        <div data-id="nagano">長野県（<?php echo areacount('nagano'); ?>）‎</div>
        <div data-id="gifu">岐阜県（<?php echo areacount('gifu'); ?>）</div>
        <div data-id="shizuoka">静岡県（<?php echo areacount('shizuoka'); ?>）</div>
        <div data-id="aichi">愛知県‎（<?php echo areacount('aichi'); ?>）</div>
        <div></div>
      </div>
      
      <div class="pref_list" data-list="4">
        <div data-id="mie">三重県（<?php echo areacount('mie'); ?>）</div>
        <div data-id="shiga">滋賀県（<?php echo areacount('shiga'); ?>）</div>
        <div data-id="kyoto">京都府（<?php echo areacount('kyoto'); ?>）</div>
        <div data-id="osaka">大阪府（<?php echo areacount('osaka'); ?>）</div>
        <div data-id="hyogo">兵庫県（<?php echo areacount('hyogo'); ?>）</div>
        <div data-id="nara">奈良県（<?php echo areacount('nara'); ?>）</div>
        <div data-id="wakayama">和歌山県（<?php echo areacount('wakayama'); ?>）</div>
        <div></div>
      </div>
      
      <div class="pref_list" data-list="5">
        <div data-id="tottori">鳥取県（<?php echo areacount('tottori'); ?>）</div>
        <div data-id="shimane">島根県（<?php echo areacount('shimane'); ?>）</div>
        <div data-id="okayama">岡山県（<?php echo areacount('okayama'); ?>）</div>
        <div data-id="hiroshima">広島県（<?php echo areacount('hiroshima'); ?>）</div>
        <div data-id="yamaguchi">山口県（<?php echo areacount('yamaguchi'); ?>）</div>
        <div data-id="tokushima">徳島県（<?php echo areacount('tokushima'); ?>）</div>
        <div data-id="kagawa">香川県（<?php echo areacount('kagawa'); ?>）</div>
        <div data-id="ehime">愛媛県（<?php echo areacount('ehime'); ?>）</div>
        <div data-id="kochi">高知県（<?php echo areacount('kochi'); ?>）</div>
        <div></div>
      </div>
      
      <div class="pref_list" data-list="6">
        <div data-id="fukuoka">福岡県（<?php echo areacount('fukuoka'); ?>）</div>
        <div data-id="saga">佐賀県（<?php echo areacount('saga'); ?>）</div>
        <div data-id="nagasaki">長崎県（<?php echo areacount('nagasaki'); ?>）</div>
        <div data-id="kumamoto">熊本県（<?php echo areacount('kumamoto'); ?>）</div>
        <div data-id="oita">大分県（<?php echo areacount('oita'); ?>）</div>
        <div data-id="miyazaki">宮崎県（<?php echo areacount('miyazaki'); ?>）</div>
        <div data-id="kagoshima">鹿児島県（<?php echo areacount('kagoshima'); ?>）</div>
        <div data-id="okinawa">沖縄県（<?php echo areacount('okinawa'); ?>）</div>
      </div>
    </div>
  </div>
</div>

<?php if ( $post_terms_slug == 'tokyo' || $post_terms_slug_parent == 'tokyo' ) : ?>

<h3 class="ranking_ttl"><i class="fas fa-search"></i> 都内エリアから絞り込む</h3>

  <?php 
    $categories = get_terms( 'area_ranking', 'hide_empty=0&parent='.$tokyo_terms_id );
    if($categories): ?>
    <ul class="ranking_list">
  <?php foreach($categories as $value): ?>
      <li><a href="<?php echo get_term_link($value); ?>#ranking_article"><?php echo $value->name . "(" . $value->count . ")"; ?></a></li>
  <?php endforeach;
    endif; ?>
    </ul>

<?php endif; ?>

<?php if ( have_posts() ) : ?>
<h3 class="ranking_ttl area_ttl <?php if ( $post_terms_slug == 'tokyo' || $post_terms_slug_parent == 'tokyo' ){ echo 'tokyo_ttl' ;} ?>" id="ranking_article"><?php echo $post_terms_name; ?>のランキング記事一覧</h3>
 <ol id="post_list" class="clearfix">

<?php while ( have_posts() ) : the_post(); ?>
  <li class="article">
   <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
    <div class="image">
     <?php if (has_post_thumbnail()) { the_post_thumbnail('size2'); } else { ?><img src="<?php echo get_template_directory_uri(); ?>/img/common/no_image2.gif" title="" alt="" /><?php } ?>
    </div>
    <h3 class="title js-ellipsis"><?php the_title(); ?></h3>
    <?php
        $metas = array();
        if ($post->post_type == 'post') {
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

        } elseif ($post->post_type == $dp_options['introduce_slug']) {
          if ($dp_options['show_introduce_categories']) {
            foreach(explode('-', $dp_options['show_introduce_categories']) as $cat) {
              if (!empty($dp_options['use_introduce_category'.$cat])) {
                $terms = get_the_terms($post->ID, $dp_options['introduce_category'.$cat.'_slug']);
                if ($terms && !is_wp_error($terms)) {
                  $term = array_shift($terms);
                  $metas[] = '<li class="cat"><span class="cat-'.esc_attr($dp_options['introduce_category'.$cat.'_slug']).'" data-href="'.get_term_link($term).'" title="'.esc_attr($term->name).'">'.esc_html($term->name).'</span></li>';
                }
              }
            }
          }
          if ($dp_options['show_date_introduce']) {
            $metas[] = '<li class="date"><time class="entry-date updated" datetime="'.get_the_modified_time('c').'">'.get_the_time('Y.m.d').'</time></li>';
          }

        } elseif ($post->post_type == $dp_options['news_slug'] && $dp_options['show_date_news']) {
          $metas[] = '<li class="date"><time class="entry-date updated" datetime="'.get_the_modified_time('c').'">'.get_the_time('Y.m.d').'</time></li>';
        }

        if ($metas) {
          echo '<ul class="meta clearfix">'.implode('', $metas).'</ul>';
        }
    ?>
   </a>
  </li>
<?php endwhile; ?>

 </ol><!-- END #post_list -->
<?php else: ?>
 <p class="no_post"><?php _e('There is no registered post.', 'tcd-w'); ?></p>
<?php endif; ?>

<?php get_template_part('navigation'); get_template_part('navigation2'); ?>

</div><!-- END #main_col -->

<?php get_template_part('breadcrumb'); ?>

<?php get_footer(); ?>