<?php
global $dp_options, $wp_query, $header_slider, $custom_search_vars;
if ( ! $dp_options ) $dp_options = get_desing_plus_option();

$footer_navs = array();
$dp_options['use_category'] = 1; // カテゴリーは常時利用でテーマオプションには存在しないが判別のためここで設定
if ($dp_options['footer_nav_type1'] != 'none' && $dp_options['use_'.$dp_options['footer_nav_category1']]) {
	$footer_navs[] = 1;
}
// if ($dp_options['footer_nav_type2'] != 'none' && $dp_options['use_'.$dp_options['footer_nav_category2']]) {
// 	$footer_navs[] = 2;
// }
?>

<?php if ($footer_navs) { ?>
  <div id="footer_nav">
   <div class="inner">
<?php   if (count($footer_navs) > 1) { ?>
    <div class="footer_nav_cols clearfix">
<?php   } ?>
<?php
        foreach($footer_navs as $footer_nav_id) {
          if ($dp_options['footer_nav_type'.$footer_nav_id] != 'none') {
            $tax_label = $dp_options[$dp_options['footer_nav_category'.$footer_nav_id].'_label'];
            $tax_color = $dp_options[$dp_options['footer_nav_category'.$footer_nav_id].'_color'];
            if ($dp_options['footer_nav_category'.$footer_nav_id] == 'category') {
              $tax_slug = 'category';
            } else {
              $tax_slug = $dp_options[$dp_options['footer_nav_category'.$footer_nav_id].'_slug'];
            }
?>
     <div class="footer_nav_col footer_nav_<?php echo esc_attr($footer_nav_id); ?> footer_nav_<?php echo esc_attr($tax_slug); ?> footer_nav_<?php echo esc_attr($dp_options['footer_nav_type'.$footer_nav_id]); ?>">
      <!-- <div class="footer_category"><?php echo esc_html($tax_label); ?></div> -->
      <ul<?php if ($dp_options['footer_nav_type'.$footer_nav_id] == 'type1') echo ' class="clearfix"'; ?>>
<?php
            $terms = get_terms($tax_slug, array('hide_empty' => false, 'parent' => 0));
            if ($terms && !is_wp_error($terms)) {
              foreach($terms as $term) {
                echo '       <li>';
                echo '<a href="'.get_term_link($term).'">'.esc_html($term->name).'</a>';
                if ($dp_options['footer_nav_type'.$footer_nav_id] == 'type2') {
                  $terms2 = get_terms($tax_slug, array('hide_empty' => false, 'parent' => $term->term_id));
                  if ($terms2) {
                    echo '<ul>';
                    foreach($terms2 as $term2) {
                      echo '<li><a href="'.get_term_link($term2).'">'.esc_html($term2->name).'</a></li>';
                    }
                    echo '</ul>';
                  }
                }
                echo "</li>\n";
              }
            }
?>
      </ul>
     </div>
<?php
          }
        }
?>
<?php   if (count($footer_navs) > 1) { ?>
    </div>
<?php   } ?>
   </div>
  </div>
<?php } ?>