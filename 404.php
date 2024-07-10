<?php
    get_header();
    $dp_options = get_desing_plus_option();

    $url = esc_url($_SERVER['REQUEST_URI']);

    function areacount($area) { 
      if(!empty(get_term_by('slug', $area , 'area_ranking' )->count)){
        echo get_term_by('slug', $area , 'area_ranking' )->count;
      }else{
        echo 0;
      };
    }
?>

<?php
    $image = null;
    if (!empty($dp_options['header_image_404'])) {
      $image = wp_get_attachment_image_src($dp_options['header_image_404'], 'full');
    }
    if (!empty($image[0])) {
      $title = $dp_options['header_txt_404'];
      $sub_title = $dp_options['header_sub_txt_404'];
      if (!is_mobile()) {
        $title_font_size = ( ! empty( $dp_options['header_txt_size_404'] ) ) ? $dp_options['header_txt_size_404'] : 38;
        $sub_title_font_size = ( ! empty( $dp_options['header_sub_txt_size_404'] ) ) ? $dp_options['header_sub_txt_size_404'] : 16;
      } else {
        $title_font_size = ( ! empty( $dp_options['header_txt_size_404_mobile'] ) ) ? $dp_options['header_txt_size_404_mobile'] : 28;
        $sub_title_font_size = ( ! empty( $dp_options['header_sub_txt_size_404_mobile'] ) ) ? $dp_options['header_sub_txt_size_404_mobile'] : 14;
      }
      $font_color = ( ! empty( $dp_options['header_txt_color_404'] ) ) ? $dp_options['header_txt_color_404'] : '#ffffff';
      $shadow1 = ( ! empty( $dp_options['dropshadow_404_h'] ) ) ? $dp_options['dropshadow_404_h'] : 2;
      $shadow2 = ( ! empty( $dp_options['dropshadow_404_v']) ) ? $dp_options['dropshadow_404_v'] : 2;
      $shadow3 = ( ! empty( $dp_options['dropshadow_404_b'] ) ) ? $dp_options['dropshadow_404_b'] : 2;
      $shadow4 = ( ! empty( $dp_options['dropshadow_404_c'] ) ) ? $dp_options['dropshadow_404_c'] : '888888';
?>
<div id="header_image">
<?php   if ($title || $sub_title) { ?>
 <div class="caption" style="text-shadow:<?php echo $shadow1; ?>px <?php echo $shadow2; ?>px <?php echo $shadow3; ?>px <?php echo $shadow4; ?>; color:<?php echo $font_color; ?>; ">
<?php if ($title) { ?>
  <p class="headline rich_font" style="font-size:<?php echo $title_font_size; ?>px;"><?php echo str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($title)); ?></p>
<?php } ?>
<?php if ($sub_title) { ?>
  <p class="" style="font-size:<?php echo $sub_title_font_size; ?>px;"><?php echo str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($sub_title)); ?></p>
<?php } ?>
 </div>
<?php   } ?>
 <img src="<?php echo $image[0]; ?>" title="" alt="" />
</div>
<?php } ?>

<div id="main_col">
<?php if (strpos($url, 'area_ranking') ) : ?>
  <h3>404 Not Found</h3>
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
<?php endif; ?>

  <div class="post_content clearfix">
   <p style="margin:50px 0;"><?php _e("Sorry, but you are looking for something that isn't here.","tcd-w"); ?></p>
  </div>

</div><!-- END #main_col -->

<?php get_template_part('breadcrumb'); ?>

<?php get_footer(); ?>
