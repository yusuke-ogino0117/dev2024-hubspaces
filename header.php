<?php
global $dp_options;
if (! $dp_options) $dp_options = get_desing_plus_option();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php if($dp_options['use_ogp']) { ?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<?php } else { ?>
<head>
<?php } ?>
<?php get_template_part('rireki'); ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NS3TH63');</script>
<!-- End Google Tag Manager -->
<meta charset="<?php bloginfo('charset'); ?>">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php wp_title('|', true, 'right'); ?></title>
<?php if ($dp_options['use_ogp']) { ogp(); }; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php if ($favicon = wp_get_attachment_image_src($dp_options['favicon'], 'full')) : ?>
<link rel="shortcut icon" href="<?php echo esc_attr($favicon[0]); ?>">
<?php endif; ?>
<?php wp_enqueue_style('style', get_stylesheet_uri(), false, version_num(), 'all'); wp_enqueue_script( 'jquery' ); if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>

<body id="body" <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NS3TH63"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --><?php if ($dp_options['use_load_icon']) { ?>

<div id="site_loader_overlay">
 <div id="site_loader_animation">
<?php   if ($dp_options['load_icon'] == 'type3') { ?>
  <i></i><i></i><i></i><i></i>
<?php   } ?>
 </div>
</div>
<?php } ?>

 <div id="header">
  <div id="header_top">
   <div class="inner clearfix">
 <?php if (is_front_page()) { ?>
    <h1 class="logo">コワーキングスペース・レンタルオフィスを探すならHub Spaces（ハブスペ）</h1>
 <?php } ?>
    <div id="header_logo">
     <?php header_logo(); ?>
    </div>
    <div id="header_logo_fix">
     <?php header_logo_fix(); ?>
    </div>
    <div class="show-sp sp-icon">
      <div class="sp-icon-contents">
        <a href="/favorite/">
          <i class="fas fa-star"></i>
          <span>お気に入り</span>
        </a>
      </div>
      <div class="sp-icon-contents">
        <a href="/rireki/">
          <i class="fas fa-clock"></i>
          <span>閲覧履歴</span>
        </a>
      </div>
    </div>
<?php if (!is_post_type_archive('ranking') && !is_tax('area_ranking') && ($dp_options['show_search_bar_subpage'] && !is_front_page() && is_show_custom_search_form())) { ?>
    <a href="#" class="search_button"><span><?php _e('Search', 'tcd-w'); ?></span></a>
<?php } ?>
<?php if (has_nav_menu('global-menu')) { ?>
    <a href="#" class="menu_button"><span><?php _e('menu', 'tcd-w'); ?></span></a>
    <div id="global_menu">
     <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'theme_location' => 'global-menu' , 'container' => '' ) ); ?>
    </div>
<?php } ?>
   </div>
  </div>
 </div><!-- END #header -->

 <div id="main_contents" class="clearfix">

