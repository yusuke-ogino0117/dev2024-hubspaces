<?php
    get_header();
    $dp_options = get_desing_plus_option();
?>

<?php get_template_part('breadcrumb'); ?>

<div id="main_col" class="clearfix">

 <div id="left_col">

<?php if ( have_posts() ) : ?>
  <div id="recent_news">
   <h1 class="headline rich_font"><?php echo esc_html($dp_options['news_label']); ?></h1>
   <ol<?php if ($dp_options['show_date_news']) echo ' class="show_date"'; ?>>
<?php while ( have_posts() ) : the_post(); ?>
    <li class="clearfix">
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
          <?php if ($dp_options['show_date_news']){ ?>
          <time class="entry-date updated" datetime="<?php the_modified_time('c'); ?>"><i class="fas fa-table"></i> <?php the_time('Y.m.d'); ?></time>
          <?php } ?>
          <h3 class="title"><?php the_title(); ?></h3>
          <p><?php if(mb_strlen(get_the_content(), 'UTF-8') > 100) { 
            $news_content = mb_substr(strip_tags(get_the_content()), 0, 99, 'UTF-8'); mb_substr(get_the_content(), 0, 99) ;
            echo $news_content . '…' ; } else {
            echo strip_tags(get_the_content()) ; } ?></p>
        </div>
      </a>
    </li>
<?php endwhile; ?>
   </ol>
  </div><!-- END #recent_news -->
<?php else: ?>
  <p class="no_post"><?php _e('There is no registered post.', 'tcd-w'); ?></p>
<?php endif; ?>

<?php get_template_part('navigation'); ?>

 </div><!-- END #left_col -->

<?php get_sidebar(); ?>

</div><!-- END #main_col -->

<?php get_footer(); ?>
