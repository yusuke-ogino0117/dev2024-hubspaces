<?php
/*
Template Name: 申請フォームテンプレート
*/
    get_header();

    $display_title = get_post_meta($post->ID, 'display_title', true);
    if (!$display_title) $display_title = 'show';
    $display_side_content = get_post_meta($post->ID, 'display_side_content', true);
    if (!$display_side_content) $display_side_content = 'show';

    $image_id = get_post_meta($post->ID, 'page_image', true);
    if ($image_id) {
      $image = wp_get_attachment_image_src( $image_id, 'full' );
    }
    if (!empty($image[0])) {
      $headline = get_post_meta($post->ID, 'page_headline', true);
      $caption_style = 'font-size:'.get_post_meta($post->ID, 'page_headline_font_size', true).'px;';
      $caption_style .= 'color:'.get_post_meta($post->ID, 'page_headline_color', true).';';
      $shadow1 = get_post_meta($post->ID, 'page_headline_shadow1', true);
      $shadow2 = get_post_meta($post->ID, 'page_headline_shadow2', true);
      $shadow3 = get_post_meta($post->ID, 'page_headline_shadow3', true);
      $shadow4 = get_post_meta($post->ID, 'page_headline_shadow4', true);
      if (empty($shadow1)) $shadow1 = 0;
      if (empty($shadow2)) $shadow2 = 0;
      if (empty($shadow3)) $shadow3 = 0;
      if (empty($shadow4)) $shadow4 = '#333333';
      if ($shadow1 || $shadow2 || $shadow3) {
        $caption_style .= 'text-shadow:'.$shadow1.'px '.$shadow2.'px '.$shadow3.'px '.$shadow4.';';
      }
    }
?>

<?php get_template_part('breadcrumb'); ?>

<?php if (!empty($image[0])) { ?>
  <div id="header_image">
   <img src="<?php echo esc_attr($image[0]); ?>" alt="" />
   <?php if ($headline){ ?>
   <div class="caption rich_font" style="<?php echo esc_attr($caption_style); ?>">
    <?php echo str_replace(array("\r\n", "\r", "\n"), '<br />', esc_html($headline)); ?>
   </div>
   <?php } ?>
  </div>
<?php } ?>

<div id="main_col" class="clearfix">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

 <div id="article">
  <div class="pr-image" style="text-align: center;">
  <?php if( get_field('pr-image') ) { ?>
    <img src="<?php the_field('pr-image'); ?>" alt="申請フォームPR">
  <?php } else if(the_field('pr-image-element',1604)) { ?>
    <img src="<?php the_field('pr-image-element',1604); ?>" alt="申請フォームPR">
  <?php } ?>
  </div>

  <div class="post_content clearfix request-form">

  <h2>内見申し込み・問い合わせ</h2>
  <form action="https://form.k3r.jp/hubworks/previewform" id="requestform" method="POST">
    <table>
      <tr>
        <th><span>必須</span> オフィス形態</th>
        <td>
          <input type="radio" name="f_item_customer_def18[]" value="レンタルオフィス（個室）" class="validate[required]"/>レンタルオフィス（個室）
          <input type="radio" name="f_item_customer_def18[]" value="シェアオフィス（共有空間）" class="validate[required]"/>シェアオフィス（共有空間）
          <input type="radio" name="f_item_customer_def18[]" value="その他（バーチャルオフィスやお問い合わせ等）" class="validate[required]"/>その他（バーチャルオフィスやお問い合わせ等）
        </td>
      </tr>
      <tr>
        <th><span>必須</span> 問い合わせ/内覧対象のオフィス名</th>
        <td>
          <input type="text" name="f_item_customer_def15" value="<?php if(isset($_GET['spacename'])){ echo $_GET['spacename'] ; } ?>" placeholder="例）WeWork新橋" class="validate[required]" style="<?php if(isset($_GET['spacename'])){ echo 'pointer-events: none; color: #888; backgroud-color: #dbdcdd; border-width: 0px; box-shadow: none;' ; } ?>"/>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> 内覧人数・入居予定人数</th>
        <td>
          <select name="f_item_customer_def10[]" class="validate[required]">
            <option value="">未選択</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11~20">11~20</option>
            <option value="21~30">21~30</option>
            <option value="30~50">30~50</option>
            <option value="50~">50~</option>
          </select>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> 入居・移転予定月</th>
        <td>
          <select name="f_item_customer_def2[]" class="validate[required]">
            <option value="">未選択</option>
            <option value="1月">1月</option>
            <option value="2月">2月</option>
            <option value="3月">3月</option>
            <option value="4月">4月</option>
            <option value="5月">5月</option>
            <option value="6月">6月</option>
            <option value="7月">7月</option>
            <option value="8月">8月</option>
            <option value="9月">9月</option>
            <option value="10月">10月</option>
            <option value="11月">11月</option>
            <option value="12月">12月</option>
          </select>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> ご希望の月額賃料</th>
        <td>
          <select name="f_item_customer_def9[]" class="validate[required]">
            <option value="">未選択</option>
            <option value="~5万">~5万</option>
            <option value="5万~10万未満">5万~10万未満</option>
            <option value="10万~20万未満">10万~20万未満</option>
            <option value="20万~30万未満">20万~30万未満</option>
            <option value="30万~50万未満">30万~50万未満</option>
            <option value="50万~70万未満">50万~70万未満</option>
            <option value="70万~100万未満">70万~100万未満</option>
            <option value="100万～150万未満">100万～150万未満</option>
            <option value="150万～200万未満">150万～200万未満</option>
            <option value="200万～">200万～</option>
          </select>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> 内覧希望時間帯・お問い合わせ内容など</th>
        <td>
          <textarea name="f_item_customer_def19" rows="12" placeholder="内覧希望時間帯・お問い合わせ内容など" class="validate[required]"></textarea>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> 会社・組織名(個人であれば個人と記載)</th>
        <td>
          <input type="text" name="f_item_customer_def17" value="" class="validate[required]"/>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> お名前</th>
        <td>
          <input type="text" name="f_item_name_last" value="" placeholder="姓" class="validate[required]"/>
          <input type="text" name="f_item_name_first" value="" placeholder="名" class="validate[required]"/>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> お電話番号<br>（緊急連絡先）</th>
        <td>
          <input type="text" name="f_item_tel" value="" class="validate[required,custom[phone],minSize[10],maxSize[13]]"/>
        </td>
      </tr>
      <tr>
        <th><span>必須</span> メールアドレス</th>
        <td>
          <input type="text" name="f_item_mail" value="" class="validate[required,custom[email]]"/>
        </td>
      </tr>
    </table>
    <!-- ↓↓↓必須↓↓↓ -->
    <input type="hidden" name="api_key" value="6c79e4648ff26809e708ea4feabef6ba2ccd5694" />
    <input type="hidden" name="opt" value="1" /><!-- メール配信 承諾=1 未承諾=0 -->
    <input type="hidden" name="red" value="https://hubspaces.jp/document-end/" />

    <!-- ↓↓↓オプション↓↓↓ -->
    <input type="hidden" name="tag" value="内見問い合わせ" />
    <input type="hidden" name="red_error" value="https://hubspaces.jp/formerror/" />

    <p><input type="submit" value="送信" /></p>
  </form>


   <?php custom_wp_link_pages(); ?>
  </div>

 </div><!-- END #article -->

<?php endwhile; endif; ?>

</div><!-- END #main_col -->

<?php get_footer(); ?>