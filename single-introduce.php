<?php

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

get_header();
$dp_options = get_desing_plus_option();
?>

<?php get_template_part('breadcrumb'); ?>
<?php
if ( have_posts() ) : 
  while ( have_posts() ) : the_post(); ?>

<div class="space_container">
  <div class="space_section__intro">
    <div class="intro__title">
      <div class="title__icon">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/review_no1.webp" alt="エリア口コミNo1">
      </div>
      <div class="title__text">
        <h1><?php the_title(); ?></h1>
      </div>
    </div>
    <p class="date">最終更新日</p>
    <div class="intro__review">
      <p>Googleレビュー ★★★★★（<?php 
      if (empty(get_field('google-review'))) {
            echo 'ー';
        } else {
            echo get_field('google-review');
        }
      ?>）</p>
    </div>
    <div class="intro__access">
      <?php if( get_field('address') ) { ?>
        <p>住所 / 〒<?php echo substr(get_field('postal-code'),0,3) ;?>-<?php echo substr(get_field('postal-code'),3);?> <?php the_field('address-pref'); ?><?php the_field('address-city'); ?><?php the_field('address'); ?></p>
      <?php } ?>
      <?php if( get_field('accesstext') ) { ?>
        <p>アクセス / <?php the_field('accesstext'); ?></p>
      <?php } ?>
    </div>
  </div>
  
  <div class="space_section__main">
    <div class="main__slider">
      <div class="slider_content">
        <ul class="slider">
        <?php if ($introduce_slider && $page == '1') { ?>
            <div id="introduce_slider">
          <?php
                  $is_first_slide = true;
                  foreach ($introduce_slider['slider'] as $i => $slider) :
                    if ($is_first_slide) {
                      $is_first_slide = false;
                      $img_src = 'src';
                    } else {
                      $img_src = 'data-lazy';
                    }

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
        </ul>
        <!-- 
          （説明）TCDテーマの影響でサムネイル画像がスライダーの画像と連動しない。調査が必要なため、サムネイル部分をコメントアウトします。2024/01/11
         <div class="thumbnail_content">
          <ul class="thumbnail">
          <?php
                  /*
                  $is_first_slide = true;
                  foreach ($introduce_slider['slider'] as $i => $slider) :
                    if ($is_first_slide) {
                      $is_first_slide = false;
                      $img_src = 'src';
                    } else {
                      $img_src = 'data-lazy';
                    }

                    echo '   <div class="item item'.$i.'">'."\n";
                    echo '    <li><img '.$img_src.'="'.esc_attr($slider).'" alt="" /></li>'."\n";
                    echo '   </div>'."\n";
                  endforeach;
                  */
          ?>
          </ul>
        </div>
        -->
      </div>
    </div>
    <div class="main__recommend">
      <div class="recommend__content">
        <h2>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/ttl_recommend.webp" alt="こんな方におすすめ">
        </h2>
        <ul>
          <?php if( get_field('recommend-1') ) { ?>
          <li><span><?php the_field('recommend-1'); ?></span></li>
          <?php } ?>
          <?php if( get_field('recommend-2') ) { ?>
          <li><span><?php the_field('recommend-2'); ?></span></li>
          <?php } ?>
          <?php if( get_field('recommend-3') ) { ?>
          <li><span><?php the_field('recommend-3'); ?></span></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="main__tab">
      <div class="tab__container">
          <label>
            <input type="radio" name="tab-002" checked>
            <h2><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/tab_01.webp" alt="施設特徴・詳細"> 施設特徴・詳細</h2>
          </label>
          <div class="tab__detail">
            <div class="detail__description">
              <?php if( get_field('facility-detail-image') ) { ?>
                <img class="aligncenter size-full wp-image-56937" src="<?php the_field('facility-detail-image'); ?>" alt="" width="900" height="487" />
                    <?php } else { ?>
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" >
              <?php } ?>  
              <?php if( get_field('outline') ) { ?>
                <p class="text_overflow"><?php the_field('outline'); ?></p>
              <?php } ?>
            </div>
            <div class="detail__feature">
              <h3>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_facility.webp" alt="施設特徴">
                <span>施設特徴</span>
              </h3>
              <?php if( get_field('special') ) { ?>
                <p class="text_overflow"><?php the_field('special'); ?></p>
              <?php } ?>
            </div>
            <div class="detail__map">
              <h3>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_map.webp" alt="地図">
                <span>地図</span>
              </h3>
              <?php if( get_field('map-description') ) { ?>
                <p class="text_overflow"><?php the_field('map-description'); ?></p>
              <?php } ?>
              <?php if( get_field('googlemap-iframe') ) { ?>
                <?php the_field('googlemap-iframe'); ?>
                <p><a href="<?php the_field('googlemap_url'); ?>"  target="_blank" rel="noopener">拡大地図を表示</a></p>
              <?php } ?>
            </div>
            <div class="detail__basicinfo">
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_basicinfo.webp" alt="基本情報">
              <span>基本情報</span>
            </h3>
            <dl>
            <?php if( get_field('building-code') ) { ?>
                <dt>ビルコード</dt>
                <dd>
                  <?php the_field('building-code'); ?>
                </dd>
              <?php } ?>
              <dt>物件名</dt>
              <dd>
              <?php the_title(); ?>
              <?php if(get_field('web-site')): ?>
                <a href="<?php the_field('web-site'); ?>" target="_blank">
                  この施設の詳細はこちら
                </a>
              <?php endif; ?>
              </dd>
              <?php if( get_field('address') ) { ?>
                <dt>所在地</dt>
                <dd>
                  〒<?php echo substr(get_field('postal-code'),0,3) ;?>-<?php echo substr(get_field('postal-code'),3);?> <?php the_field('address-pref'); ?><?php the_field('address-city'); ?><?php the_field('address'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('businesshours') ) { ?>
                <dt>営業時間</dt>
                <dd>
                  <?php the_field('businesshours'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('closedday') ) { ?>
                <dt>定休日</dt>
                <dd>
                  <?php the_field('closedday'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('building-structure') ) { ?>
                <dt>構造</dt>
                <dd>
                  <?php the_field('building-structure'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('building-size') ) { ?>
                <dt>規模</dt>
                <dd>
                  <?php the_field('building-size'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('date-of-building') ) { ?>
                <dt>築年月</dt>
                <dd>
                  <?php the_field('date-of-building'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('renewal-date') ) { ?>
                <dt>リニューアル年月</dt>
                <dd>
                  <?php the_field('renewal-date'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('earthquake-resistance') ) { ?>
                <dt>耐震性</dt>
                <dd>
                  <?php the_field('earthquake-resistance'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('accesstext') ) { ?>
                <dt>沿線・最寄駅</dt>
                <dd>
                  <?php the_field('accesstext'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('facility-details') ) { ?>
                <dt>設備詳細</dt>
                <dd>
                  <?php the_field('facility-details'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('option') ) { ?>
                <dt>オプション</dt>
                <dd>
                  <?php the_field('option'); ?>
                </dd>
              <?php } ?>
              <?php if( get_field('remarks') ) { ?>
                <dt>備考</dt>
                <dd>
                  <?php the_field('remarks'); ?>
                </dd>
              <?php } ?>
            </dl>
            </div>
          </div>

          <label>
            <input type="radio" name="tab-002">
            <h2><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/tab_02.webp" alt="設備"> 設備</h2>
          </label>
          <div class="tab__facility">
            <!-- <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_floormap.webp" alt="フロアマップ">
              <span>フロアマップ</span>
            </h3>
            <div class="facility_floormap">
              <div class="tab">
                <div class="tab-contents-wrap">
                  <div class="tab-contents is-contents-active">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" >
                  </div>
                  <div class="tab-contents">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_floormap.webp" alt="フロアマップ">
                  </div>
                </div>
                <div class="tab-list">
                  <button class="tab-list-item is-btn-active">15階</button>
                  <button class="tab-list-item">16階</button>
                </div>
              </div>
            </div> -->
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_floorfacility.webp" alt="設備">
              <span>設備</span>
            </h3>
            <div class="facility_floorfacility facility_description">
              <div class="facility_image">
                  <img src="https://hubspaces.jp/wp-content/uploads/2024/04/space_facility-scaled.jpg" >
              </div>
              <div class="facility__text">
                <ul>
                  <?php if( get_field('usage-time') ) { ?>
                    <li>
                      <dl>
                        <dt>利用時間</dt>
                        <dd>
                          <?php the_field('usage-time'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('common-wi-fi') ) { ?>
                    <li>
                      <dl>
                        <dt>共用 Wi-Fi</dt>
                        <dd>
                          <?php the_field('common-wi-fi'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('each-seat-outlet') ) { ?>
                    <li>
                      <dl>
                        <dt>各席コンセント</dt>
                        <dd>
                          <?php the_field('each-seat-outlet'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('dedicated-number') ) { ?>
                    <li>
                      <dl>
                        <dt>専用電話番号</dt>
                        <dd>
                          <?php the_field('dedicated-number'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_sharespace.webp" alt="共有スペース">
              <span>共有スペース</span>
            </h3>
            <div class="facility_sharespace facility_description">
              <div class="facility_image">
                <?php if( get_field('facility-detail-image') ) { ?>
                  <img class="aligncenter size-full wp-image-56937" src="<?php the_field('facility-detail-image'); ?>" alt="" width="900" height="487" />
                      <?php } else { ?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" >
                <?php } ?>  
              </div>
              <div class="facility__text">
                <ul>
                  <?php if( get_field('copy-device') ) { ?>
                    <li>
                      <dl>
                        <dt>コピー・複合機</dt>
                        <dd>
                          <?php the_field('copy-device'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('shredder') ) { ?>
                    <li>
                      <dl>
                        <dt>シュレッダー</dt>
                        <dd>
                          <?php the_field('shredder'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('telephone-box') ) { ?>
                    <li>
                      <dl>
                        <dt>電話専用ボックス</dt>
                        <dd>
                          <?php the_field('telephone-box'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('conference-room') ) { ?>
                    <li>
                      <dl>
                        <dt>会議室</dt>
                        <dd>
                          <?php the_field('conference-room'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <div class="facility_sharespace_2 facility_description">
              <div class="facility__text">
                <ul>
                <?php if( get_field('shared-and-private') ) { ?>
                    <li>
                      <dl>
                        <dt>共有空間と個室併設</dt>
                        <dd>
                          <?php the_field('shared-and-private'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('locker') ) { ?>
                    <li>
                      <dl>
                        <dt>ロッカー</dt>
                        <dd>
                          <?php the_field('locker'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('water-room') ) { ?>
                    <li>
                      <dl>
                        <dt>給湯室・電子レンジ</dt>
                        <dd>
                          <?php the_field('water-room'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('drink-service') ) { ?>
                    <li>
                      <dl>
                        <dt>ドリンクサービス</dt>
                        <dd>
                          <?php the_field('drink-service'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('shower') ) { ?>
                    <li>
                      <dl>
                        <dt>シャワー</dt>
                        <dd>
                          <?php the_field('shower'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('cleaning') ) { ?>
                    <li>
                      <dl>
                        <dt>清掃・ゴミ収集</dt>
                        <dd>
                          <?php the_field('cleaning'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('parking') ) { ?>
                    <li>
                      <dl>
                        <dt>駐車場</dt>
                        <dd>
                          <?php the_field('parking'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('bicycle-parking') ) { ?>
                    <li>
                      <dl>
                        <dt>駐輪場</dt>
                        <dd>
                          <?php the_field('bicycle-parking'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_contractservice.webp" alt="契約サービス">
              <span>契約サービス</span>
            </h3>
            <div class="facility_contractservice facility_description">
              <div class="facility_image">
                <img src="https://hubspaces.jp/wp-content/uploads/2024/04/space_contract-scaled.jpg" >
              </div>
              <div class="facility__text">
                <ul>
                <?php if( get_field('address-registration') ) { ?>
                    <li>
                      <dl>
                        <dt>住所登記</dt>
                        <dd>
                          <?php the_field('address-registration'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('virtual-office') ) { ?>
                    <li>
                      <dl>
                        <dt>バーチャルオフィス</dt>
                        <dd>
                          <?php the_field('virtual-office'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('postal-service') ) { ?>
                    <li>
                      <dl>
                        <dt>郵便・宅配物転送サービス</dt>
                        <dd>
                          <?php the_field('postal-service'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_security.webp" alt="セキュリティ">
              <span>セキュリティ</span>
            </h3>
            <div class="facility_security facility_description">
              <div class="facility_image">
                <img src="https://hubspaces.jp/wp-content/uploads/2024/04/space_security-scaled.jpg" >
              </div>
              <div class="facility__text">
                <ul>
                <?php if( get_field('auto-lock') ) { ?>
                    <li>
                      <dl>
                        <dt>オートロック</dt>
                        <dd>
                          <?php the_field('auto-lock'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('security-card') ) { ?>
                    <li>
                      <dl>
                        <dt>セキュリティカード</dt>
                        <dd>
                          <?php the_field('security-card'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('manned-receptionist') ) { ?>
                    <li>
                      <dl>
                        <dt>有人受付</dt>
                        <dd>
                          <?php the_field('manned-receptionist'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                  <?php if( get_field('room-key') ) { ?>
                    <li>
                      <dl>
                        <dt>ルームキー</dt>
                        <dd>
                          <?php the_field('room-key'); ?>
                        </dd>
                      </dl>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_otherservice.webp" alt="その他サービス">
              <span>その他サービス</span>
            </h3>
            <div class="facility_otherservice facility_description">
              <div class="facility_image">
                <img src="https://hubspaces.jp/wp-content/uploads/2024/04/space_other-services-scaled.jpg" >
              </div>
              <div class="facility__text">
                <?php if( get_field('other-services') ) { ?>
                  <p>
                    <?php the_field('other-services'); ?>
                  </p>
                <?php } ?>
              </div>
            </div>
          </div>

          <label>
            <input type="radio" name="tab-002">
            <h2><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/tab_03.webp" alt="区画・料金"> 区画・料金</h2>
          </label>
          <div class="tab__price">
          <?php if( get_field('officetype-1') ) { ?>
            <h2>
              <?php the_field('officetype-1'); ?>
            </h2>
            <div class="price_description">
              <div class="facility_image">
                <?php if( get_field('vacancy-1') == "あり" ) { ?>  
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/vacancy.webp" alt="空室あり">
                <?php } ?>
                <ul class="facility_slider_1">
                  <li>
                    <?php if( get_field('images-1') ) { ?>
                      <?php the_field('images-1'); ?>
                    <?php } else { ?>
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" >
                    <?php } ?>
                  </li>
                <!-- <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_1.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_2.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_3.webp" alt="個室オフィス">
                  </li> -->
                </ul>
                <!-- <ul class="facility_thumbnail_1">
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_1.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_2.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_3.webp" alt="個室オフィス">
                  </li>
                </ul> -->
              </div>
              <div class="facility_intro">
                <p><?php the_field('features-section-1'); ?></p>
              </div>
              <div class="facility__text">
                <ul>
                  <li>
                    <dl>
                      <dt>料金</dt>
                      <dd><?php
                        if (empty(get_field('monthlyfee-1'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('monthlyfee-1');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>初期費用</dt>
                      <dd><?php
                        if (empty(get_field('initialcost-1'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('initialcost-1');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>利用可能人数</dt>
                      <dd><?php
                        if (empty(get_field('available-1'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('available-1');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>広さ</dt>
                      <dd><?php
                        if (empty(get_field('size-1'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('size-1');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>収納の目安</dt>
                      <dd><?php
                        if (empty(get_field('storage-1'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('storage-1');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>入居可能時間</dt>
                      <dd><?php
                        if (empty(get_field('availableperiod-1'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('availableperiod-1');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>最低契約期間</dt>
                      <dd><?php
                        if (empty(get_field('mincontract-1'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('mincontract-1');
                        }
                        ?></dd>
                    </dl>
                  </li>
                </ul>
              </div>
            </div>
            <?php } ?>  
            <?php if( get_field('officetype-2') ) { ?>
            <h2>
              <?php the_field('officetype-2'); ?>
            </h2>
            <div class="price_description">
              <div class="facility_image">
                <?php if( get_field('vacancy-2') == "あり" ) { ?>  
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/vacancy.webp" alt="空室あり">
                <?php } ?>
                <ul class="facility_slider_2">
                  <li>
                    <?php if( get_field('images-2') ) { ?>
                      <?php the_field('images-2'); ?>
                    <?php } else { ?>
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" >
                    <?php } ?>
                  </li>
                </ul>
                <!-- <ul class="facility_thumbnail_2">
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_1.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_2.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_3.webp" alt="個室オフィス">
                  </li>
                </ul> -->
              </div>
              <div class="facility_intro">
                <p><?php the_field('features-section-2'); ?></p>
              </div>
              <div class="facility__text">
              <ul>
                  <li>
                    <dl>
                      <dt>料金</dt>
                      <dd><?php
                        if (empty(get_field('monthlyfee-2'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('monthlyfee-2');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>初期費用</dt>
                      <dd><?php
                        if (empty(get_field('initialcost-2'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('initialcost-2');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>利用可能人数</dt>
                      <dd><?php
                        if (empty(get_field('available-2'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('available-2');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>広さ</dt>
                      <dd><?php
                        if (empty(get_field('size-2'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('size-2');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>収納の目安</dt>
                      <dd><?php
                        if (empty(get_field('storage-2'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('storage-2');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>入居可能時間</dt>
                      <dd><?php
                        if (empty(get_field('availableperiod-2'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('availableperiod-2');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>最低契約期間</dt>
                      <dd><?php
                        if (empty(get_field('mincontract-2'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('mincontract-2');
                        }
                        ?></dd>
                    </dl>
                  </li>
                </ul>
              </div>
            </div>
            <?php } ?>  
            <?php if( get_field('officetype-3') ) { ?>
            <h2>
              <?php the_field('officetype-3'); ?>
            </h2>
            <div class="price_description">
              <div class="facility_image">
                <?php if( get_field('vacancy-3') == "あり" ) { ?>  
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/vacancy.webp" alt="空室あり">
                <?php } ?>
                <ul class="facility_slider_3">
                  <li>
                    <?php if( get_field('images-3') ) { ?>
                      <?php the_field('images-3'); ?>
                    <?php } else { ?>
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" >
                    <?php } ?>
                  </li>
                </ul>
                <!-- <ul class="facility_thumbnail_3">
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_1.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_2.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_3.webp" alt="個室オフィス">
                  </li>
                </ul> -->
              </div>
              <div class="facility_intro">
                <p><?php the_field('features-section-3'); ?></p>
              </div>
              <div class="facility__text">
              <ul>
                  <li>
                    <dl>
                      <dt>料金</dt>
                      <dd><?php
                        if (empty(get_field('monthlyfee-3'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('monthlyfee-3');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>初期費用</dt>
                      <dd><?php
                        if (empty(get_field('initialcost-3'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('initialcost-3');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>利用可能人数</dt>
                      <dd><?php
                        if (empty(get_field('available-3'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('available-3');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>広さ</dt>
                      <dd><?php
                        if (empty(get_field('size-3'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('size-3');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>収納の目安</dt>
                      <dd><?php
                        if (empty(get_field('storage-3'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('storage-3');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>入居可能時間</dt>
                      <dd><?php
                        if (empty(get_field('availableperiod-3'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('availableperiod-3');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>最低契約期間</dt>
                      <dd><?php
                        if (empty(get_field('mincontract-3'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('mincontract-3');
                        }
                        ?></dd>
                    </dl>
                  </li>
                </ul>
              </div>
            </div>
            <?php } ?>  
            <?php if( get_field('officetype-4') ) { ?>
            <h2>
              <?php the_field('officetype-4'); ?>
            </h2>
            <div class="price_description">
              <div class="facility_image">
                <?php if( get_field('vacancy-4') == "あり" ) { ?>  
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/vacancy.webp" alt="空室あり">
                <?php } ?>
                <ul class="facility_slider_4">
                  <li>
                    <?php if( get_field('images-4') ) { ?>
                      <?php the_field('images-4'); ?>
                    <?php } else { ?>
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" >
                    <?php } ?>
                  </li>
                </ul>
                <!-- <ul class="facility_thumbnail_4">
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_1.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_2.webp" alt="個室オフィス">
                  </li>
                  <li>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_office_3.webp" alt="個室オフィス">
                  </li>
                </ul> -->
              </div>
              <div class="facility_intro">
                <p><?php the_field('features-section-4'); ?></p>
              </div>
              <div class="facility__text">
              <ul>
                  <li>
                    <dl>
                      <dt>料金</dt>
                      <dd><?php
                        if (empty(get_field('monthlyfee-4'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('monthlyfee-4');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>初期費用</dt>
                      <dd><?php
                        if (empty(get_field('initialcost-4'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('initialcost-4');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>利用可能人数</dt>
                      <dd><?php
                        if (empty(get_field('available-4'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('available-4');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>広さ</dt>
                      <dd><?php
                        if (empty(get_field('size-4'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('size-4');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>収納の目安</dt>
                      <dd><?php
                        if (empty(get_field('storage-4'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('storage-4');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>入居可能時間</dt>
                      <dd><?php
                        if (empty(get_field('availableperiod-4'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('availableperiod-4');
                        }
                        ?></dd>
                    </dl>
                  </li>
                  <li>
                    <dl>
                      <dt>最低契約期間</dt>
                      <dd><?php
                        if (empty(get_field('mincontract-4'))) {
                            echo '要問い合わせ';
                        } else {
                            echo get_field('mincontract-4');
                        }
                        ?></dd>
                    </dl>
                  </li>
                </ul>
              </div>
            </div>
            <?php } ?>  
          </div>

          <label>
            <input type="radio" name="tab-002">
            <h2><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/tab_04.webp" alt="口コミ"> 口コミ</h2>
          </label>
          <div class="tab__review">
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_review.webp" alt="担当者のコメント">
              <span>担当者のコメント</span>
            </h3>
            <div class="review__comment">
              <div class="comment__image">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_comment.webp" alt="担当者のコメント">
              </div>
              <div class="comment__text">
                <?php if( get_field('special') ) { ?>
                <p class="text_overflow"><?php the_field('special'); ?></p>
                <?php } ?>
              </div>
            </div>
            <h3>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sec_review.webp" alt="ご利用された方の口コミ">
              <span>ご利用された方の口コミ</span>
            </h3>
            <?php 
              $display_reveiew_flg = false;

              for($i = 0; $i < 20; $i ++) { 
                if($i == 0) {
                  $reviewer_name = "reviewer-name";
                  $used_date = "used-date";
                  $used_area = "used-area";
                  $reason = "reason";
                  $main_points = "main-points";
                  $impressions = "impressions";
                } else {
                  $reviewer_name = "reviewer-name_" . $i;
                  $used_date = "used-date_" . $i;
                  $used_area = "used-area_" . $i;
                  $reason = "reason_" . $i;
                  $main_points = "main-points_" . $i;
                  $impressions = "impressions_" . $i;
                }

                // 1件でも表示すべき口コミがあるか判定
                if( get_field($reviewer_name) && get_field($used_date) && get_field($used_area) && get_field($reason) && get_field($main_points) && get_field($impressions) ) {
                  $display_reveiew_flg = true;
                  break;
                }
              }

              if( $display_reveiew_flg ) {
            ?>
              <div class="customer-voice-table">
                <?php for($i = 0; $i < 20; $i ++) { 
                  if($i == 0) {
                    $reviewer_name = "reviewer-name";
                    $used_date = "used-date";
                    $used_area = "used-area";
                    $reason = "reason";
                    $main_points = "main-points";
                    $impressions = "impressions";
                  } else {
                    $reviewer_name = "reviewer-name_" . $i;
                    $used_date = "used-date_" . $i;
                    $used_area = "used-area_" . $i;
                    $reason = "reason_" . $i;
                    $main_points = "main-points_" . $i;
                    $impressions = "impressions_" . $i;
                  }

                  // データがなければスキップ
                  if( !(get_field($reviewer_name) && get_field($used_date) && get_field($used_area) && get_field($reason) && get_field($main_points) && get_field($impressions)) ) {
                    continue;
                  }
                ?>
                  <h4 class="customer-voice-table__subttl"><?php echo get_field($reviewer_name) . "様"; ?></h4>
                  <div class="customer-voice-table__content">
                    <div class="customer-voice-table__tr">
                      <div class="customer-voice-table__th">
                        <p>ご利用日</p>
                      </div>
                      <div class="customer-voice-table__td">
                        <p><?php echo explode("/", get_field($used_date))[2] . "年" . explode("/", get_field($used_date))[1] . "月" . explode("/", get_field($used_date))[0] . "日"; ?></p>
                      </div>
                    </div>
                    <div class="customer-voice-table__tr">
                      <div class="customer-voice-table__th">
                        <p>ご利用した区画</p>
                      </div>
                      <div class="customer-voice-table__td">
                        <p><?php echo get_field($used_area); ?></p>
                      </div>
                    </div>
                    <div class="customer-voice-table__tr">
                      <div class="customer-voice-table__th">
                        <p>ご利用のきっかけや背景</p>
                      </div>
                      <div class="customer-voice-table__td">
                        <p><?php echo get_field($reason); ?></p>
                      </div>
                    </div>
                    <div class="customer-voice-table__tr">
                      <div class="customer-voice-table__th">
                        <p>重視したポイント</p>
                      </div>
                      <div class="customer-voice-table__td">
                        <p><?php echo get_field($main_points); ?></p>
                      </div>
                    </div>
                    <div class="customer-voice-table__tr">
                      <div class="customer-voice-table__th">
                        <p>感想</p>
                      </div>
                      <div class="customer-voice-table__td">
                        <p><?php echo get_field($impressions); ?></p>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            <?php } else { ?>
              <center>現在、口コミはありません。</center>
            <?php } ?>
          </div>
      </div>
    </div>
  </div>
  
  <div class="space_section__aside">
    <div class="aside__call">
      <div class="call__campaign">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/sample_campaign.webp" alt="サンプルキャンペーン">
      </div>

      <div class="call__reserve">
        <a href="https://hubspaces.jp/hub_requestform/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/icon_reserve.webp" alt="無料内見予約" class="show-sp"> 無料内見予約<?php esc_html(get_field('office_contract'))?></a>
      </div>
      <!-- 施設ページの電話番号の表示について。
        オフィス企業と契約があり、オフィスへ直接電話をする許可をもらっている場合は弊社で発行したオフィス直通の電話番号を表示します。
        オフィス企業と契約があり、オフィスへ直接電話をする許可をもらっていない場合はハブスペ窓口の電話番号を表示します。
        オフィス企業と契約がない場合は、PC：電話番号は非表示。SP：電話番号を表示。
        という仕様になっています。
      -->
      <?php if( get_field('office_contract') == "true" )  { ?>
        <?php if( get_field('permission_direct_tel') == "true" )  { ?>
            <div class="call__reserve">
              <a href="tel:<?php the_field('allow_tel_number'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/icon_reserve.webp" alt="電話で問い合わせる" class="show-sp">電話で問い合わせる<br>TEL：<?php the_field('allow_tel_number'); ?></a>
            </div>
        <?php } else { ?>
            <div class="call__reserve">
              <a href="tel:050-1721-4573"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/icon_reserve.webp" alt="電話で問い合わせる" class="show-sp">電話で問い合わせる<br>TEL：050-1721-4573</a>
            </div>
        <?php } ?>
      <?php } ?>

      <div class="call_other">
        <div class="call__bookmark">
          <div class="bookmark__btn">
            <?php echo get_favorites_button(get_the_ID()); ?>
          </div>
        </div>
        <div class="call__sns">
          <?php if ($dp_options['show_sns_btm_introduce']) { ?>
            <?php get_template_part('sns-btn-btm'); ?>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="aside__vicinity asise_spacelist">
      <div class="aside_ttl">
        <h2>付近の人気オフィス</h2>
      </div>
    </div>
    <div class="aside__area-search asise_spacelist">
      <div class="aside_ttl">
        <h2>エリアで探す</h2>
      </div>
      <?php get_template_part('asidesearch', 'area'); ?>
    </div>
    <div class="aside__budget-search asise_spacelist">
      <div class="aside_ttl">
        <h2>予算で探す</h2>
      </div>
      <?php get_template_part('asidesearch', 'budget'); ?>
    </div>
    <!-- <div class="aside__type-search asise_spacelist">
      <div class="aside_ttl">
        <h2>区画タイプで探す</h2>
      </div>
    </div> -->
  </div>
</div>

<?php
  endwhile; 
endif;
?>

<?php
	// コンテンツビルダー
	if ( ! empty( $dp_options['contents_builder'] ) ) :
		foreach ( $dp_options['contents_builder'] as $key => $content ) :
			$cb_index = 'cb_' . $key;
			if ( empty( $content['cb_content_select'] ) ) continue;
			if ( isset( $content['cb_display'] ) && ! $content['cb_display'] ) continue;

			//カルーセルスライダー
			if ( $content['cb_content_select'] == 'carousel' ) :
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
       <h3 class="title"><?php trim_title( 34 ); ?></h3>
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
			endif;

		endforeach;
	endif;
?>

<script>
jQuery(document).ready(function($){
  var fix    = $(".aside__call"); 
  var fixTop = fix.offset().top;
  $(window).scroll(function () { 
    if($(window).scrollTop() >= fixTop) {
      fix.addClass("aside__call_fix");
    } else {
      fix.removeClass("aside__call_fix"); 
    }
  });

  $('.slider').slick({
    asNavFor:'.thumbnail',
    arrows: true,
    autoplay: true,
    slidesToShow:1,
    prevArrow:'<div class="arrow prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></div>',
    nextArrow:'<div class="arrow next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>',
  });
  $('.thumbnail').slick({
    asNavFor:'.slider',
    focusOnSelect: true,
    arrows: true,
    autoplay: false,
    slidesToShow: 6,
    prevArrow:'<div class="arrow prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></div>',
    nextArrow:'<div class="arrow next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>',
  });


  $('.facility_slider_1').slick({
    asNavFor:'.facility_thumbnail_1',
    arrows: false,
    slidesToShow:1,
  });
  $('.facility_thumbnail_1').slick({
    asNavFor:'.facility_slider_1',
    focusOnSelect: true,
    arrows: false,
    slidesToShow: 3,
  });
  $('input[name="tab-002"]').click(function () { 
      $('.facility_slider_1').slick('setPosition');
      $('.facility_thumbnail_1').slick('setPosition');
  });

  $('.facility_slider_2').slick({
    asNavFor:'.facility_thumbnail_2',
    arrows: false,
    slidesToShow:1,
  });
  $('.facility_thumbnail_2').slick({
    asNavFor:'.facility_slider_2',
    focusOnSelect: true,
    arrows: false,
    slidesToShow: 3,
  });
  $('input[name="tab-002"]').click(function () { 
      $('.facility_slider_2').slick('setPosition');
      $('.facility_thumbnail_2').slick('setPosition');
  });

  $('.facility_slider_3').slick({
    asNavFor:'.facility_thumbnail_3',
    arrows: false,
    slidesToShow:1,
  });
  $('.facility_thumbnail_3').slick({
    asNavFor:'.facility_slider_3',
    focusOnSelect: true,
    arrows: false,
    slidesToShow: 3,
  });
  $('input[name="tab-002"]').click(function () { 
      $('.facility_slider_3').slick('setPosition');
      $('.facility_thumbnail_3').slick('setPosition');
  });

  $('.facility_slider_4').slick({
    asNavFor:'.facility_thumbnail_4',
    arrows: false,
    slidesToShow:1,
  });
  $('.facility_thumbnail_4').slick({
    asNavFor:'.facility_slider_4',
    focusOnSelect: true,
    arrows: false,
    slidesToShow: 3,
  });
  $('input[name="tab-002"]').click(function () { 
      $('.facility_slider_4').slick('setPosition');
      $('.facility_thumbnail_4').slick('setPosition');
  });

  $('.carousel').slick({
    infinite: true,
    dots: false,
    arrows: true,
    prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
    nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
    slidesToShow: 3,
    slidesToScroll: 3,
    adaptiveHeight: false,
    autoplay: true,
    speed: 1000,
    autoplaySpeed: 10000,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 481,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $(function () {
    var ua = navigator.userAgent;
    if (ua.indexOf('iPhone') > 0 || ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0)  {
      return;
    }else{
      var $win = $(window),
          $price = $('#price'),
          $review = $('#review'),
          pricePos = $price.offset().top,
          reviewdPos = $review.offset().top,
          fixedClass = 'is-fixed';

      $win.on('load scroll', function() {
        var value = $(this).scrollTop();
        if ( value > pricePos && value < reviewdPos) {
          $('aside').addClass(fixedClass);
          $('#body').removeClass('header_fix');
        } else{
          $('aside').removeClass(fixedClass);
        }
      });
    }
  });

  var count = 120;
  $('.text_overflow').each(function() {
    var thisText = $(this).html();
    var textLength = thisText.length;
    if (textLength > count) {
      var showText = thisText.substring(0, count);
      var hideText = thisText.substring(count, textLength);
      var insertText = showText;
      insertText += '<span class="hide">' + hideText + '</span>';
      insertText += '<span class="omit">…</span>';
      insertText += '<a href="" class="more"><i class="fa fa-angle-double-down"></i>もっと読む</a>';
      $(this).html(insertText);
    };
  });
  $('.text_overflow .hide').hide();
  $('.text_overflow .more').click(function() {
    $(this).find('i').toggleClass('fa-angle-double-down');
    $(this).find('i').toggleClass('fa-angle-double-up');
    if ($(this).text() === '閉じる') {
      $(this).html('<i class="fa fa-angle-double-down"></i>もっと読む');
    } else {
      $(this).html('<i class="fa fa-angle-double-up"></i>閉じる');
    }
    $(this).prev('.omit').toggle()
    .prev('.hide').toggle();
    return false;
  });

  $(function(){
    $('.tab-list-item').on('click', function(){
      let index = $('.tab-list-item').index(this);

      $('.tab-list-item').removeClass('is-btn-active');
      $(this).addClass('is-btn-active');
      $('.tab-contents').removeClass('is-contents-active');
      $('.tab-contents').eq(index).addClass('is-contents-active');
    });
  }); 
});
</script>

<?php get_footer(); ?>
