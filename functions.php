<?php
// // 暫定：すべてのエラーを非表示にする
error_reporting(0);

// 暫定：警告（Warning）エラーのみ非表示にする
// error_reporting(E_ERROR | E_PARSE | E_NOTICE);


function custom_login_logo() { ?>
  <style>
    body{
      background: #fff !important;
    }
    .login #login h1 a {
      width: 250px;
      height: 87px;
      background: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png) no-repeat 50% 50%;
    }
  </style>
<?php } 
add_action( 'login_enqueue_scripts', 'custom_login_logo' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom-style.css', array('parent-style'), date('YmdGis'));
}

/**
 * CSSの読み込み
 */
function load_styles(){
  wp_enqueue_style(
    'fontawesome',
    'https://use.fontawesome.com/releases/v5.7.2/css/all.css',
    array(),
    '1.0'
  );
  wp_enqueue_style(
    'slick-theme',
    'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css',
    array(),
    '1.0'
  );
  wp_enqueue_style(
    'jquery.rateyo.css',
    get_stylesheet_directory_uri() . '/jquery.rateyo.min.css',
    array(),
    '1.0'
  );
}
add_action( 'wp_enqueue_scripts', 'load_styles' );

/**
 * JSの読み込み
 */
function load_scripts(){
  wp_enqueue_script(
    'jquery.cookie.js',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js',
    array( 'jquery' ),
    '1.0',
    false
  );
  wp_enqueue_script(
    'googlemap.js',
    get_stylesheet_directory_uri() . '/googlemap.js',
    array( 'jquery' ),
    '1.0',
    false
  );
  wp_enqueue_script(
    'jquery.rateyo.js',
    get_stylesheet_directory_uri() . '/jquery.rateyo.min.js',
    array( 'jquery' ),
    '1.0',
    false
  );
  // if (is_post_type_archive('space') || is_singular('space') || is_search() || is_object_in_term($post->ID, 'category','rentaloffice')){
  //   wp_enqueue_script(
  //     'maps.googleapis.js',
  //     'https://maps.googleapis.com/maps/api/js?key=AIzaSyC0RJqmtltpLPnpJk-k9EWXdQQsZOG7DmY&libraries=places',
  //     array( 'jquery' ),
  //     '1.0',
  //     false
  //   );
  // }
}
add_action( 'wp_enqueue_scripts', 'load_scripts' );


// function my_acf_google_map_api( $api ){
//   $api['key'] = 'AIzaSyC0RJqmtltpLPnpJk-k9EWXdQQsZOG7DmY';
//   return $api;
// }
// add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

function my_php_Include($params = array()) {
  extract(shortcode_atts(array('file' => 'default'), $params));
  ob_start();
  include(STYLESHEETPATH . "/$file.php");
  return ob_get_clean();
}
add_shortcode('myphp1', 'my_php_Include');

add_action( 'template_redirect', 'status404' );
function status404() {
  if ( is_page(array('rental-space-details','share-space-details','top')) ) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
  }
}

register_taxonomy(
  'area',
  'ranking',
  get_taxonomy('area')
);

function my_remove_post_support() {
  remove_post_type_support('space','editor');
}
add_action('init','my_remove_post_support');

function org_side_box(){
add_meta_box( 'org_side_box_in', '施設デフォルト並び順', 'org_side_box_in', 'ranking', 'side', 'low' );
}
function org_side_box_in(){
  echo '<ul>';
  for($i = 1; $i <= 30; $i++){
    if (get_field('space_'.$i)){
      echo '<li>オフィス番号 '.$i.'：'.get_field('space_'.$i).'</li>';
    };
  }
  echo '</ul>';
  echo '<p>Googleのレビュー表示に必要なPlaceIDを入力してください。<br>
  PlaceIDは下記から検索してください。<br>
  <a href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder" target="_brank" rel="noopener">https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder</a></p>';
}
add_action( 'admin_menu', 'org_side_box' );

function admin_css() {
  echo '<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/admin-custom.css">';
}
add_action('admin_head', 'admin_css');

function author_archive_redirect() {
  if( is_author() ) {
    wp_redirect( home_url());
    exit;
  }
}
add_action( 'template_redirect', 'author_archive_redirect' );

add_action('init', function() { 
  remove_post_type_support( 'space', 'editor' ); 
}, 9999);

global $current_user;
if(is_admin()){
  if(current_user_can('place_admin')) {
    function remove_bar_menus( $wp_admin_bar ) {
      $wp_admin_bar->remove_menu( 'wp-logo' );
      $wp_admin_bar->remove_menu( 'archive' );
      $wp_admin_bar->remove_menu( 'site-name' );
      $wp_admin_bar->remove_menu( 'view-site' );
      $wp_admin_bar->remove_menu( 'dashboard' );
      $wp_admin_bar->remove_menu( 'themes' ); 
      $wp_admin_bar->remove_menu( 'customize' );
      $wp_admin_bar->remove_menu( 'comments' ); 
      $wp_admin_bar->remove_menu( 'updates' );
      $wp_admin_bar->remove_menu( 'view' );
      $wp_admin_bar->remove_menu( 'new-content' );
      $wp_admin_bar->remove_menu( 'new-post' );
      $wp_admin_bar->remove_menu( 'new-media' );
      $wp_admin_bar->remove_menu( 'new-link' );
      $wp_admin_bar->remove_menu( 'new-page' );
      $wp_admin_bar->remove_menu( 'new-user' );
    }
    add_action('admin_bar_menu', 'remove_bar_menus', 201);

    function update_nag_hide() {
      remove_action('admin_notices', 'update_nag', 3 );
    }
    add_action('admin_init', 'update_nag_hide');

    function place_admin_css() {
      echo '<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/place-admin-custom.css">';
    }
    add_action('admin_head', 'place_admin_css');

    function show_only_authorimage( $where ){
      if( isset( $_POST['action'] ) && ( $_POST['action'] == 'query-attachments' ) ){
        $where .= ' AND post_author='.$current_user->data->ID;
      }
      return $where;
    }
    add_filter('posts_where', 'show_only_authorimage' );

    function remove_menus() {
      remove_menu_page( 'index.php' ); // ダッシュボード.
      remove_menu_page( 'edit.php' ); // 投稿.
      remove_menu_page( 'upload.php' ); // メディア.
      remove_menu_page( 'edit.php?post_type=ranking' ); // ランキング.
      remove_menu_page( 'edit.php?post_type=writer' ); // 執筆者.
      remove_menu_page( 'edit.php?post_type=news' ); // お知らせ.
      remove_menu_page( 'edit.php?post_type=page' ); // 固定.
      remove_submenu_page( 'edit.php?post_type=space', 'post-new.php?post_type=space' ); // 施設新規追加.
      remove_menu_page( 'edit-comments.php' ); // コメント.
      remove_menu_page( 'themes.php' ); // 外観.
      remove_menu_page( 'plugins.php' ); // プラグイン.
      remove_menu_page( 'profile.php' ); // プロフィール.
      remove_menu_page( 'users.php' ); // ユーザー.
      remove_menu_page( 'tools.php' ); // ツール.
      remove_menu_page( 'options-general.php' ); // 設定.
    }
    add_action('admin_menu', 'remove_menus', 999 );

    add_filter( 'get_sample_permalink_html', '__return_false' );
    add_filter( 'post_row_actions', 'hide_quickedit' );
    add_filter( 'page_row_actions', 'hide_quickedit' );
    function hide_quickedit( $actions ) {
      unset($actions['inline hide-if-no-js']);
      return $actions;
    }

    function redirect_dashiboard() {
      if ( 
        '/wp-admin/index.php'           == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/upload.php'          == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/post-new.php'        == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/edit-comments.php'   == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/themes.php'          == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/plugins.php'         == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/users.php'           == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/tools.php'           == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/options-general.php' == $_SERVER['SCRIPT_NAME']  ||
        '/wp-admin/profile.php'         == $_SERVER['SCRIPT_NAME']  ||
        'post_type=ranking'             == $_SERVER['QUERY_STRING'] ||
        'post_type=writer'              == $_SERVER['QUERY_STRING'] ||
        'post_type=news'                == $_SERVER['QUERY_STRING'] ||
        'post_type=page'                == $_SERVER['QUERY_STRING']
      ) {
        wp_redirect( admin_url( 'edit.php?post_type=space' ) );
      }
    }
    add_action('admin_init', 'redirect_dashiboard' );

    if ( 
      'post_type=ranking'             == $_SERVER['QUERY_STRING'] ||
      'post_type=writer'              == $_SERVER['QUERY_STRING'] ||
      'post_type=news'                == $_SERVER['QUERY_STRING'] ||
      'post_type=page'                == $_SERVER['QUERY_STRING'] ||
      strpos( $_SERVER['QUERY_STRING'] , 'author' )               !== false ||
      strpos( $_SERVER['QUERY_STRING'] , 'all_posts=1' )          !== false ||
      strpos( $_SERVER['QUERY_STRING'] , 'post_status=publish' )  !== false ||
      strpos( $_SERVER['QUERY_STRING'] , 'post_status=draft' )    !== false ||
      strpos( $_SERVER['QUERY_STRING'] , 'post_status=trash' )    !== false
    ) {
      header('Location: '.home_url().'/wp-admin/edit.php?post_type=space');
      exit;
    }

  }elseif(current_user_can('administrator')){
    add_action('admin_menu', 'myplugin_add_custom_box');
    function myplugin_add_custom_box() {
      if( function_exists( 'add_meta_box' )) {
        add_meta_box( 'myplugin_sectionid', __( '作成者', 'myplugin_textdomain' ), 'post_author_meta_box', 'space', 'side' );
      }
    }
  }
}

// All In One SEO の検索結果ページのみ変更する
function change_about_page_title($title) {
	global $wp_query;
  if (is_search()) {
    if($_GET['search_element_0'][0] && !$_GET['search_element_0'][1] && $_GET['fe_form_no'] === '0'){
      $term_id = $_GET['search_element_0'][0];
      $taxonomy = 'area';
      $term = get_term($term_id, $taxonomy);
      $term_name = $term->name;
      $title = $term_name.'の賃貸オフィス・レンタルオフィス・事務所 '.$wp_query->found_posts.'選';
    }elseif($_GET['search_element_0'][1] && $_GET['fe_form_no'] === '0'){
      $term_id = $_GET['search_element_0'][1];
      $taxonomy = 'area';
      $term = get_term($term_id, $taxonomy);
      $term_name = $term->name;
      $title = $term_name.'の賃貸オフィス・レンタルオフィス・事務所 '.$wp_query->found_posts.'選';
    }elseif($_GET['search_element_0'][0] && !$_GET['search_element_0'][1] && $_GET['fe_form_no'] === '1'){
      $term_id = $_GET['search_element_0'][0];
      $taxonomy = 'line';
      $term = get_term($term_id, $taxonomy);
      $term_name = $term->name;
      $title = $term_name.'の賃貸オフィス・レンタルオフィス・事務所 '.$wp_query->found_posts.'選';
    }elseif($_GET['search_element_0'][1] && $_GET['fe_form_no'] === '1'){
      $term_id = $_GET['search_element_0'][1];
      $taxonomy = 'line';
      $term = get_term($term_id, $taxonomy);
      $term_name = $term->name;
      $title = $term_name.'の賃貸オフィス・レンタルオフィス・事務所 '.$wp_query->found_posts.'選';
    }
    elseif(!$_GET['search_element_0'][0] && $_GET['s_keyword_2']){
      $title = $_GET['s_keyword_2'].'の口コミ/評判/料金をチェック';
    }else{
      $title = '全エリアの賃貸オフィス・レンタルオフィス・事務所 ';
    }
    return $title;
  }elseif(is_tax("area")){
    $queried_object = get_queried_object();
    $title = $queried_object->name.'の賃貸オフィス・レンタルオフィス・事務所 '.$search_found_posts_ttl.'選';
  }
  return $title;
}
add_filter('aioseo_title', 'change_about_page_title', 100);


// CTAの作成を行う
function my_cta_button_shortcode($atts) {
  $atts = shortcode_atts(
      array(
          'text' => '無料で相談',  // デフォルトのボタンテキスト
          'url' => 'https://hubspaces.jp/hub_otoiawase/',  // デフォルトのリンク先
      ),
      $atts,
      'cta_button'
  );

  // CTAボタンのHTMLを生成
  $output = '<div class="cta-button-container">';
  $output .= '<a href="' . esc_url($atts['url']) . '" class="cta-button" target="_blank" rel="noopener noreferrer">';
  $output .= '<span class="cta-text">' . esc_html($atts['text']) . '</span>';
  $output .= '<span class="cta-icon">➔</span>';
  $output .= '</a>';
  $output .= '</div>';

  return $output;
}
add_shortcode('cta_button', 'my_cta_button_shortcode');


