<ul>
<?php
$terms = get_terms('spaces');
foreach ( $terms as $term ){
echo '<li><a href="'.get_term_link($term->slug,'タクソノミースラッグ').'">'.$term->name.'('. $term->count .')'.'</a></li>';
}
?>
</ul>