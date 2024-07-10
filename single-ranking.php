<?php

get_header();
$dp_options = get_desing_plus_option();

for($i = 1; $i <= 30; $i++){
  if (get_field('space_'.$i)){
    $count =  $i;
  };
}
for($i = 1; $i <= $count; $i++){
  if (get_field('review_auto_sort') == 'on'){
    $ranking_order = $i;
  }else{
    if (get_field('ranking_order_'.$i)){
      $ranking_order = get_field('ranking_order_'.$i);
    }else{
      $ranking_order = $i;
    }
  }
  $array[] = array(
    'ranking_order' => $ranking_order,
    'default_order' => $i,
    'place_id' => get_field('place_id_'.$i)
  );
}

$sort = array();

if (get_field('review_auto_sort') == 'on'){
  $APIkey = 'AIzaSyC0RJqmtltpLPnpJk-k9EWXdQQsZOG7DmY';
  foreach((array) $array as $item){
    $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id='.$item['place_id'].'&fields=rating&key='.$APIkey;
    $data[] = json_decode(@file_get_contents($url), true);
  }
  unset($data['version']);
  foreach((array) $data as $key => $info){
    $rating[] = array(
      'rating' => $info['result']['rating']
    );
  }
  for($i = 0; $i < $count ; $i++){
    $array[$i]['rating'] = $rating[$i]['rating'];
  }
  foreach ((array) $array as $key => $value) {
    $sort[$key] = $value['rating'];
  }
  array_multisort($sort, SORT_DESC, $array);
}

$ratestr = <<<EOM
  starWidth: "18px",
  normalFill: "#cccccc",
  ratedFill: "#000000",
  numStars: 5
EOM;
$ratestr2 = <<<EOM
  starWidth: "18px",
  normalFill: "#cccccc",
  ratedFill: "#ffffff",
  numStars: 5
EOM;
?>

<?php
get_template_part('breadcrumb');
?>


<style>
  .sp-only {
    display: none;
  }
  .text-left {
    text-align: left;
  }
  #main_col #left_col #article .space_address p {
    font-size: 13px;
    margin-top: 20px;
  }
  #main_col #left_col #article.ranking .space-container .space_special {
    padding: 0;
    margin: 20px 0 0;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
  }
  .space_campaign {
    display: flex;
    align-items: center;
    background-color: #b69e84;
    padding: 8px 16px;
    border-radius: 4px;
    margin: 16px 0 0;
    transition-property: background-color, color, opacity;
    transition-duration: 0.2s;
    transition-timing-function: ease;
  }
  .space_campaign:hover {
    opacity: 0.8;
  }
  .space_campaign ._ttl {
    font-size: 16px;
    font-weight: bold;
    background-color: #fff;
    color: #b69e84;
    border-radius: 3px;
    margin-right: 14px;
    min-width: 115px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .space_campaign ._content {
    line-height: 1.4;
    color: #fff;
    font-weight: bold;
  }
  .space_imgbox {
    display: flex;
    margin-top: 28px;
  }
  .space_imgbox .space_imgbox__left {
    width: 55%;
  }
  .space_imgbox .space_imgbox__left ._main-img {
    margin-bottom: 12px;
  }
  .space_imgbox .space_imgbox__left ._sub-img {
    display: flex;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 13.33px;
  }
  .space_imgbox .space_imgbox__left ._sub-img > li {
    width: calc(25% - 10px);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    cursor: pointer;
  }
  .space_imgbox .space_imgbox__left ._main-img img {
    display: block;
    width: 100%;
    height: auto;
    object-fit: cover;
    aspect-ratio: 4 / 3;
  }
  .space_imgbox .space_imgbox__left ._sub-img img {
    display: block;
    width: 100%;
    object-fit: cover;
    aspect-ratio: 4 / 3;
  }
  .space_imgbox .space_imgbox__detail-link {
  }
  .space_imgbox .space_imgbox__detail-link a {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-size: 13px;
    width: 100%;
    height: 100%;
    background-color: #f2f2f2;
    line-height: 1.4;
  }
  .space_imgbox .space_imgbox__right {
    width: calc(45% - 15px);
    padding-left: 15px;
  }
  .space_imgbox .space_imgbox__right ._floormap {
    position: relative;
    margin-bottom: 6px;
  }
  .space_imgbox .space_imgbox__right ._container {
    height: 187px;
    overflow: hidden;
  }
  .space_imgbox .space_imgbox__right ._container img {
    display: none;
    width: 100%;
    height: auto;
    max-height: 100%;
    object-fit: fill;
    aspect-ratio: 4 / 3;
  }
  .space_imgbox .space_imgbox__right ._container img.active-image {
    display: block;
  }
  .space_imgbox .space_imgbox__right ._tab-container {
  }
  .space_imgbox .space_imgbox__right ._tabs {
    text-align: center;
    display: flex;
    justify-content: center;
    flex-wrap: nowrap;
    padding: 5px 0;
  }
  .space_imgbox .space_imgbox__right ._tab {
    padding: 4px 10px;
    cursor: pointer;
    display: block;
    font-size: 12px;
    background-color: #eee;
    color: #3e3a39;
    border-radius: 14px;
  }
  .space_imgbox .space_imgbox__right ._tab + ._tab {
    margin-left: 4px;
  }
  .space_imgbox .space_imgbox__right ._tab.active {
    background-color: #e2d8ce;
  }
  .space_imgbox .space_imgbox__right ._googlemap {
  }
  .space_imgbox .space_imgbox__right ._googlemap__link {
    display: flex;
    justify-content: flex-end;
  }
  .space_imgbox .space_imgbox__right ._googlemap__link a {
    font-size: 12px;
    color: #b69e84;
  }
  .space_imgbox .space_imgbox__right ._googlemap iframe {
    max-width: 100%;
    height: 160px;
  }
  .space_spec {
    display: flex;
    text-align: center;
    align-items: center;
    margin-top: 8px;
  }
  .space_spec > li {
    flex: 1;
    background-color: rgba(252, 248, 226, 0.7);
    border-radius: 4px;
    height: 74px;
    padding: 0 8px;
    display: flex;
    justify-content: center;
    flex-direction: column;
  }
  .space_spec ._last {
    position: relative;
  }
  .space_spec ._last::after {
    position: absolute;
    top: 100%;
    width: 100%;
    display: block;
    font-size: 11px;
    content: "※シェアスペースを除く";
  }
  #main_col #left_col #article .space_spec p {
    color: #3e3a39;
    line-height: 1.2;
    font-size: 14px;
  }
  #main_col #left_col #article .space_spec p._ttl {
    color: #b69e84;
    font-weight: bold;
    margin-bottom: 6px;
    border-bottom: 1px solid #b69e84;
    padding-bottom: 4px;
  }
  .space_spec > li + li {
    margin-left: 10px;
  }
  .customer-voice-table {
    background-color: #f2f2f2;
    margin: 36px 0 5px;
    border-radius: 4px;
    padding: 20px 22px;
  }
  .customer-voice-table__ttl {
    font-size: 20px;
    display: inline-block;
    line-height: 1.3;
    color: #b69e84;
  }
  .flex-center {
    display: flex;
    align-items: center;
    height: 100px;
  }
  .customer-voice-table__subttl {
    margin: 6px 0 12px;
  }
  .customer-voice-table__content {
    margin-top: 6px;
    margin-bottom: 12px;
  }
  .customer-voice-table__tr {
  }
  .customer-voice-table__tr + .customer-voice-table__tr {
    margin-top: 20px;
  }
  .customer-voice-table__th {
    color: #fff;
    display: flex;
    flex: 0 0 auto;
    align-items: flex-start;
  }
  #main_col #left_col #article .customer-voice-table__th p {
    display: inline-block;
    font-size: 14px;
    border-radius: 18px;
    padding: 0 18px;
    margin: 0 0 5px;
    background-color: #fff;
    color: #b69e84;
    border: 2px solid #b69e84;
    font-weight: bold;
  }
  #main_col #left_col #article .customer-voice-table__td p {
    font-size: 14px;
  }
  .space_details {
    margin-top: 24px;
  }
  .sticky-sidebar {
    width: 280px;
    position: sticky;
    top: 120px;
  }
  .ranking_campaign_badge {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #b69e84;
    color: #fff;
    font-weight: bold;
    width: 56px;
    height: 56px;
    line-height: 1;
    text-align: center;
    border-radius: 50%;
    padding-top: 4px;
  }
  #main_col #left_col #article.ranking .text_overflow .more {
    line-height: 1;
  }
  .ranking-table .more {
    width: 230px;
  }
  .popular-office {
    display: none;
  }
  .popular-office__item {
    background-color: rgba(252, 248, 226, 0.7);
    padding: 24px 24px 14px;
    margin-top: 24px;
    border: 1px solid #b69e84;
    border-bottom: 1px solid #b69e84;
    border-radius: 4px;
  }
  .popular-office__ttl {
    width: 270px;
    margin-left: -55px;
    color: #92785f;
    padding: 0px 0;
    font-size: 1.1rem;
    background-color: #fff;
    box-shadow: 0px 0px 12px -5px #777777;
    border-radius: 0px 20px 20px 0px;
    padding-left: 55px;
    overflow: hidden;
  }
  .popular-office__img {
    width: 40%;
    object-fit: cover;
    aspect-ratio: 4 / 3;
  }
  .popular-office__img img {
    display: block;
  }
  .popular-office__access {
    flex: 1;
    padding-left: 18px;
  }
  #main_col #left_col #article.ranking .popular-office__access p {
    font-size: 13px;
  }
  #main_col #left_col #article .popular-office__title p {
    font-weight: bold;
    font-size: 22px;
    line-height: 1.3;
  }
  .popular-office__title__googlereview {
    font-weight: bold;
    color: #fabb05;
    font-size: 17px;
    line-height: 1.6;
  }
  .popular-office__middle-box {
    display: flex;
    margin-top: 6px;
  }
  .popular-office__bottom-box {
    background-color: #fff;
    padding: 12px 16px;
    margin-top: 8px;
    border-radius: 4px;
  }
  #main_col #left_col #article .popular-office__bottom-box p {
    font-size: 14px;
  }
  .popular-office__item .btn_more {
    margin-top: 12px;
  }
  .txt-limit {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    /* -webkit-line-clamp: はdata-limit-lineを通じてJavaScriptで設定 */
  }
  .ranking_intro_table__wrapper {
    overflow-x: scroll;
    margin-bottom: 16px;
  }
  .ranking_intro_table__wrapper::-webkit-scrollbar {
    display: none;
  }
  .hidden-row {
    display: none;
  }
  .more-ranking {
    display: block;
    margin: 8px auto 0;
    border: solid 2px #939898;
    color: #939898;
    padding: 3px;
    width: 240px;
    text-align: center;
    border-radius: 15px;
    line-height: 1;
  }
  .more-ranking a {
    color: #939898;
    font-size: 14px;
    font-weight: bold;
    display: block;
  }
  #footer #footer_nav {
    display: none;
  }
  #main_col #left_col #article.ranking .right-area-subttl {
    font-size: 14px;
    line-height: 1.6;
  }

  /* --------- */
  /* レスポンシブ */
  /* --------- */
  @media screen and (max-width: 1200px) {
    .space_container .space_section__main {
      max-width: 100%;
    }
    .space_container .space_section__aside {
      max-width: 100%;
    }
    .sticky-sidebar {
      width: 100%;
    }
    .space_imgbox .space_imgbox__right ._container {
      height: auto;
    }
    .popular-office {
      display: block;
    }
    .space_container .space_section__aside .aside_ttl {
      width: 270px;
      margin-left: -67px;
      color: #92785f;
      padding: 10px 0;
      font-size: 1.1rem;
      background-color: #fff;
      box-shadow: 0px 0px 12px -5px #777777;
      border-radius: 0px 20px 20px 0px;
      padding-left: 60px;
      overflow: hidden;
    }
    .space_container .space_section__aside .aside_ttl h2 {
      padding-left: 0;
    }
  }
  @media screen and (max-width: 840px) {
    .space_imgbox {
      flex-direction: column;
    }
    .space_imgbox .space_imgbox__left {
      width: 100%;
    }
    .space_imgbox .space_imgbox__right {
      width: 100%;
      padding-left: 0;
      margin-top: 20px;
      display: flex;
    }
    .space_imgbox .space_imgbox__right ._floormap {
      width: 50%;
      margin-right: 15px;
      margin-bottom: 0;
    }
    .space_imgbox .space_imgbox__right ._googlemap iframe {
      height: 100%;
    }
    .space_imgbox .space_imgbox__right ._googlemap {
      width: 50%;
    }
  }
  @media screen and (max-width: 600px) {
    .sp-only {
      display: block;
    }
    .space_imgbox .space_imgbox__right {
      flex-direction: column;
    }
    .space_imgbox .space_imgbox__right ._floormap {
      width: 100%;
    }
    .space_imgbox .space_imgbox__right ._googlemap {
      width: 100%;
      margin-top: 20px;
      text-align: left;
    }
    .space_imgbox .space_imgbox__right ._googlemap iframe {
      height: 220px;
      width: 100%;
    }
    .space_spec {
      flex-wrap: wrap;
      gap: 5px;
    }
    .space_spec > li {
      flex: 1 1 calc(50% - 5px);
      border-radius: 0;
    }
    .space_spec > li + li {
      margin-left: 0;
    }
    .customer-voice-table__tr {
      flex-direction: column;
    }
    #main_col #left_col #article .customer-voice-table__td {
      padding-left: 4px;
    }
    .customer-voice-table__th {
      margin-bottom: 2px;
    }
    .customer-voice-table__tr + .customer-voice-table__tr {
      margin-top: 12px;
    }
    .space_campaign {
      padding: 6px 10px;
    }
    .space_campaign ._ttl {
      font-size: 13px;
      margin-right: 10px;
      min-width: 90px;
    }
    .space_campaign ._content {
      font-size: 13px;
    }
    .space_imgbox {
      margin-top: 20px;
    }
    #main_col #left_col #article .popular-office__bottom-box p {
      font-size: 16px;
    }
    #main_col #left_col #article .popular-office__title p {
      font-size: 16px;
    }
    .popular-office__title__googlereview {
      font-size: 14px;
    }
    #main_col #left_col #article.ranking .popular-office__access p {
      font-size: 12px;
      line-height: 1.6;
    }
    #main_col #left_col #article .popular-office__bottom-box p {
      font-size: 12px;
    }
  }
</style>
<style>
  /* ランキング詳細追加 */
  #main_col.d-ptn02 {
    color: #3e3a39;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .nav-open02 .intxt,
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .btnc_more02 .intxt {
    color: #939898;
    min-width: auto;
    font-size: 17px;
    line-height: 1;
    padding: 5px 25px;
    margin: 0;
    border: none;
    box-shadow: 0px 0px 5px 0px #aaaaaa;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .nav-open02 .intxt {
      font-size: max(2.0238095238vw, 10px);
    }
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro .h2_title02 h1 {
      font-size: max(3.6904761905vw, 10px);
    }
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro .date__wrapper .date__inner {
      font-size: max(1.1904761905vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro .txt_content {
    color: #3e3a39;
    font-size: 16px;
    font-weight: 100;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro .txt_content {
      font-size: max(2.5vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro .nav-open02 {
    margin-top: 10px;
    margin-bottom: 25px;
  }
  @media screen and (max-width: 500px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro .nav-open02 {
      margin-top: 12px;
      margin-bottom: 0;
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table {
    background-color: #f2f2f2;
    padding: 20px;
    margin: 60px 0;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table {
      margin-top: max(7.1428571429vw, 30px);
      margin-bottom: max(7.1428571429vw, 30px);
      padding-left: max(2.380952381vw, 10px);
      padding-right: max(2.380952381vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table .ranking-h2-image {
    height: auto;
    margin: 0 auto 20px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table .ranking-h2-image {
      margin-bottom: max(2.380952381vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table .ranking-h2-image h2 {
    font-size: 28px;
    font-weight: bold;
    padding-bottom: 0;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table .ranking-h2-image h2 {
      font-size: max(3.3333333333vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table {
    background-color: #fff;
    padding: 0 20px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table {
      min-width: 800px;
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr {
    border-top: solid 1px #3e3a39;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr:first-child {
    border-top: none;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr th {
    background-color: #fff;
    color: #3e3a39;
    padding: 20px 0 10px;
    border: none;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr th:first-child {
    width: 65px;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr th:nth-child(2) {
    width: 230px;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr th:nth-child(3) {
    width: 145px;
  }
  @media screen and (max-width: 1024px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr th:nth-child(4) {
      width: auto;
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td {
    padding: 10px;
    border: none;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:first-child {
    padding-left: 0;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:nth-child(2) {
    font-weight: bold;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:nth-child(2) > a {
    color: #3e3a39;
    font-size: 17.7px;
    font-weight: bold;
    line-height: 1.4;
    text-decoration: none;
    display: inline-block;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:nth-child(2) p {
    text-align: center;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:nth-child(3) .jq-ry-container {
    padding: 0;
    margin: 0 auto;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:nth-child(3) p {
    text-align: center;
    color: #3e3a39;
    font-weight: bold;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:nth-child(4) {
    font-weight: 100;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr td:last-child {
    font-weight: 100;
    padding-right: 0;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .ranking-table .nav-open02 {
    margin-top: 0;
    margin-bottom: 0;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro_text p {
    line-height: 1.2;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro_text p span {
    font-size: 21px;
    font-weight: 100;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .intro_text p span {
      font-size: max(2.5vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .nav-open02 {
    margin-top: 10px;
    margin-bottom: 25px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container {
      padding: max(2.380952381vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro {
    margin-bottom: 0;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__title {
    margin: 0;
    justify-content: flex-start;
  }
  @media screen and (max-width: 1024px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__title {
      padding: 0;
    }
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__title .title__text {
      padding-left: max(2.380952381vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__title .title__text h2 {
    font-size: 28px;
    font-weight: bold;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__title .title__text h2 {
      font-size: max(3.3333333333vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .date {
    font-size: 10px;
    font-weight: 100;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .date {
      font-size: max(1.1904761905vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__review {
    padding: 5px 0;
    padding-right: 15px;
    margin-bottom: 0;
    width: fit-content;
    border-radius: 0 100px 100px 0;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__review {
      margin-left: min(-2.380952381vw, -10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__review p {
    margin-left: 20px;
    display: flex;
    align-items: center;
    font-size: 21px;
    font-weight: bold;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_section__intro .intro__review p {
      font-size: max(2.5vw, 10px);
    }
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_special {
      font-size: max(1.6666666667vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_campaign {
    background-color: #b69e84;
    display: flex;
    align-items: center;
    padding: 7px;
    line-height: 1;
    margin-bottom: 20px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_campaign {
      padding: max(0.8333333333vw, 3px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_campaign .txt_cam01 {
    background-color: #fff;
    color: #b69e84;
    font-size: 17px;
    font-weight: bold;
    padding: 3px 7px;
    margin-right: 7px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_campaign .txt_cam01 {
      font-size: max(2.0238095238vw, 10px);
      padding: 3px max(0.8333333333vw, 3px);
      margin-right: max(0.8333333333vw, 3px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_campaign .txt_cam02 {
    color: #fff;
    font-size: 21px;
    font-weight: bold;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_campaign .txt_cam02 {
      font-size: max(2.5vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .grid .space_images img {
    padding: 0;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .main__tab {
    border-top: solid 1px #bbb;
    padding: 25px 0 40px;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .main__tab .tab__container .tab__facility .facility_description .facility__text {
    height: auto;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .main__tab .tab__container .tab__facility .facility_description .facility__text ul {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    flex-wrap: nowrap;
    gap: 20px;
    height: fit-content;
  }
  @media screen and (max-width: 600px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .main__tab .tab__container .tab__facility .facility_description .facility__text ul {
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .main__tab .tab__container .tab__facility .facility_description .facility__text ul li {
    width: auto;
    height: 100%;
    padding: 0 6px;
    margin-bottom: 0;
  }
  #main_col.d-ptn02
    .space_container
    .space_section__main
    #left_col
    #article.ranking
    .space-container
    .main__tab
    .tab__container
    .tab__facility
    .facility_description
    .facility__text
    ul
    li
    dl
    dt {
    padding-bottom: 3px;
    border-bottom: 1px solid #3e3a39;
  }
  #main_col.d-ptn02
    .space_container
    .space_section__main
    #left_col
    #article.ranking
    .space-container
    .main__tab
    .tab__container
    .tab__facility
    .facility_description
    .facility__text
    ul
    li
    dl
    dd {
    padding-top: 5px;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews {
    margin-bottom: 20px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews {
      margin-bottom: max(2.380952381vw, 10px);
      padding: max(2.380952381vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .tit_reviews {
    display: flex;
    gap: 8px;
    font-size: 21px;
    font-weight: 100;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .tit_reviews {
      font-size: max(2.5vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .tit_reviews.fwb {
    font-size: 24px;
    font-weight: bold;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .tit_reviews.fwb {
      font-size: max(2.8571428571vw, 10px);
    }
  }
  @media screen and (max-width: 600px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .tit_reviews img {
      width: max(6.4285714286vw, 34px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .tit_bgbr {
    font-size: 21px;
    font-weight: 100;
    border-radius: 100px;
    line-height: 1;
    margin-top: 15px;
    margin-bottom: 10px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .tit_bgbr {
      font-size: max(2.5vw, 10px);
      margin-top: max(1.7857142857vw, 7px);
      margin-bottom: max(1.1904761905vw, 5px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .txt_reviews {
    font-size: 21px;
    line-height: 1.5;
    margin-bottom: 10px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .txt_reviews {
      font-size: max(2.5vw, 10px);
      margin-bottom: max(1.1904761905vw, 5px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .nav-open02 {
    margin-top: 0;
    margin-bottom: 0;
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .nav-open02 .intxt {
    font-size: 14px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .ranking_reviews .nav-open02 .intxt {
      font-size: max(1.6666666667vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_details .btn_more a {
    font-size: 14px;
  }
  @media screen and (max-width: 840px) {
    #main_col.d-ptn02 .space_container .space_section__main #left_col #article.ranking .space-container .space_details .btn_more a {
      font-size: max(1.6666666667vw, 10px);
    }
  }
  #main_col.d-ptn02 .space_container .space_section__aside .asise_spacelist #footer_nav .footer_nav_type2 > ul > li > a {
    background-color: #e2d8ce;
  }

  /* スライダー共通のスタイル */
  .ranking_facility_image * {
    box-sizing: border-box;
  }

  .ranking_facility_image img {
    width: 100%;
    max-width: 100%;
  }

  /* メインスライダーのスタイル */
  .slider-main {
    margin-bottom: 10px;
  }

  .slider-main .slick-slide {
    margin: 0 3px; /* スライドの間隔 */
  }

  /* サムネイルスライダーのスタイル */
  .slider-thumbnail {
    max-width: 100%;
    width: 80%;
  }

  .slider-thumbnail .slick-slide {
    margin: 0 3px; /* スライドの間隔 */
  }

  /* 現在表示中のサムネイルのデザイン */
  .slider-thumbnail .slick-current img {
    border: 2px solid #b69e84;
  }

  @media screen and (min-width: 541px) {
    .flex {
      display: flex;
      gap: 20px;
    }
    .flex .flex-l,
    .flex .flex-r {
      width: 50%;
    }
  }
  .ranking_facility_image {
    position: relative;
  }

  .slider-thumbnail {
    width: 80%;
  }

  .thumbnail-more {
    position: absolute;
    right: 0;
    bottom: 0;
    width: 20%;
  }

  /* add2 */
  /* 打消し */
  .d-ptn02 #left_col {
    width: auto;
  }

  .d-ptn02 .space_container .space_section__main .main__tab .tab__container > div {
    display: block;
    border-top: none;
    padding: 0;
  }

  .d-ptn02 .space_container .space_section__main .main__tab::before {
    display: none;
  }

  .d-ptn02#main_col #left_col #article.ranking .ranking-table #ranking_intro_table td img {
    height: auto;
  }

  .d-ptn02 .space_container .space_section__intro .intro__title .title__icon {
    width: 53px;
  }

  /* 追加 */
  .tac,
  .center {
    text-align: center;
  }

  .right {
    text-align: right !important;
  }

  .fwb {
    font-weight: bold;
  }

  .cmain {
    color: #b69e84;
  }

  @media screen and (min-width: 541px) {
    /* .grid {
    display: grid;
    display: -ms-grid;
  }
.grid.col2 {
gap: 20px;
grid-template-columns: repeat(2, 1fr);
} */
  }

  .d-ptn02#main_col #left_col #article.ranking .intro .h2_title02 h1 {
    /* border-bottom: none; */
    font-size: 2rem;
    font-weight: bold;
    line-height: 1.5;
    /* width: 90%;
padding: 0 10px; */
  }

  .d-ptn02#main_col #left_col #article.ranking .date__inner {
    color: #999;
    justify-content: normal;
  }

  .d-ptn02 .nav-open02 {
    text-align: center;
  }

  .d-ptn02 .nav-open02 .intxt {
    background: #fff;
    color: #939898;
    padding: 8px 12px;
    border-radius: 30px;
    min-width: 200px;
    display: inline-block;
    margin: -25px auto 15px;
    border: 2px solid rgba(0, 0, 0, 0.3);
    transition: all 0.3s;
    position: relative;
    text-align: center;
    cursor: pointer;
  }

  .d-ptn02 .btn_more {
    text-align: center;
  }

  .d-ptn02#main_col #left_col #article.ranking table tbody tr td .btn_more a,
  .btn_more a {
    display: inline-block;
    font-size: 0.85rem;
    line-height: 1.3;
    border-radius: 14.5px;
    padding: 4px 25px;
    margin: 0 0 5px;
    background-color: #b69e84;
    color: #fff;
    text-decoration: none;
  }

  .d-ptn02#main_col #left_col #article.ranking .ranking-table .ranking-h2-image {
    display: block;
    background: none;
  }

  .d-ptn02#main_col #left_col #article.ranking .space-container {
    padding: 20px;
    margin-bottom: 24px;
    border: 1px solid #e6e6e6;
  }

  .d-ptn02 .space_container .space_section__intro .intro__review {
    margin-left: -20px;
    border-radius: 0 20px 20px 0;
  }

  .d-ptn02 .space_images {
    max-width: 430px;
  }

  .d-ptn02 .ranking_reviews {
    padding: 20px;
    background: #f2f2f2;
  }

  .d-ptn02 .ranking_reviews .tit_bgbr {
    display: inline-block;
    font-size: 0.85rem;
    border-radius: 14.5px;
    padding: 2px 25px;
    margin: 0 0 5px;
    background-color: #fff;
    border: 1px solid #92785f;
    color: #92785f;
  }

  .d-ptn02 .vacancy img {
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    width: 75px;
    height: auto;
    z-index: 9;
    transform: rotate(90deg);
  }

  .d-ptn02 .nav-open02 {
    text-align: center;
  }

  .d-ptn02 .nav-open02 .intxt {
    background: #fff;
    color: #939898;
    padding: 8px 12px;
    border-radius: 30px;
    min-width: 200px;
    display: inline-block;
    margin: -25px auto 15px;
    border: 2px solid rgba(0, 0, 0, 0.3);
    transition: all 0.3s;
    position: relative;
    text-align: center;
    cursor: pointer;
  }

  .d-ptn02 .space-container {
    position: relative;
  }

  .d-ptn02#main_col #left_col #article.ranking table tbody tr td:nth-child(4),
  .d-ptn02#main_col #left_col #article.ranking table tbody tr td:nth-child(5) {
    line-height: 1.5 !important;
  }

  .d-ptn02#main_col #left_col #article.ranking table tbody tr td .btn_more a {
    display: inline-block;
    font-size: 0.85rem;
    border-radius: 14.5px;
    padding: 2px 25px;
    margin: 0 0 5px;
    background-color: #b69e84;
    color: #fff;
  }

  .d-ptn02#main_col .space_container .space_section__main #left_col #article.ranking .ranking-table table tbody tr th:nth-child(2) {
    width: 210px !important;
  }

  .d-ptn02 .text_overflow {
    padding: 0;
  }

  .d-ptn02 .thumbnail-more {
    text-align: center;
    background: #f2f2f2;
    line-height: 1.4;
    padding: 10px;
  }

  .d-ptn02 .facility_floormap {
    max-height: 215px;
    padding: 10px;
    border: 1px solid #e6e6e6;
  }

  .d-ptn02 .space_container .space_section__main .main__tab .tab__facility .tab-contents {
    display: none;
    padding: 6px;
  }

  .d-ptn02 .space_container .space_section__main .main__tab .tab__facility .tab-contents img {
    max-height: 113px;
    width: auto;
  }

  .d-ptn02 .space_container .space_section__main .main__tab .tab__facility .is-contents-active {
    display: block;
  }

  .d-ptn02 .space_container .space_section__main .main__tab .tab__facility .facility_description {
    padding-top: 30px;
    margin-top: 30px;
    border-top: 1px solid #3e3a39;
  }

  .d-ptn02 .space_container .space_section__main .main__tab .tab__container .tab__facility .facility_description .facility__text ul li dl dt {
    font-size: 1rem;
  }

  .d-ptn02 .detail_map .ranking_googlemap iframe {
    max-width: 100%;
    max-height: 200px;
  }

  .d-ptn02 .btn_map a {
    color: #939898;
  }

  .cb_content-carousel .item:nth-of-type(n+2) {
    display: block;
  }

  .cb_content-carousel .item:nth-of-type(n+4) {
    display: none;
  }

  .cb_content-carousel .carousel {
    display: flex;
  }

  @media screen and (max-width: 770px) {
    #cb_0 {
      display: none;
    }
  }
</style>

<div id="main_col" class="clearfix d-ptn02">

  <div class="space_container">

    <div class="space_section__main">

      <div id="left_col">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <div id="article" class="ranking">
          <section class="intro">
            <div class="h2_title02">
              <h1 class="rich_font"><?php the_title(); ?></h1>
            </div>
            <div class="date__wrapper">
              <div class="date__inner">
                <div class="publish_date" aria-label="公開日">
                  <i class="far fa-clock"></i>
                  <time><?php the_date("Y年n月j日"); ?></time>
                </div>
                <div class="modified_date" aria-label="更新日">
                  <i class="fas fa-sync-alt"></i>
                  <time><?php the_modified_date("Y年n月j日"); ?></time>
                </div>
              </div>
            </div>

            <div class="txt_content text_overflow">
              <?php //remove_filter ('the_content', 'wpautop'); ?>
              <?php remove_filter('the_content', 'wpautop'); ?>
              <?php the_content(); ?>
            </div>

            <script>
              jQuery(document).ready(function($){
                var count = 190;
                $('.text_overflow').each(function() {
                  var thisText = $(this).html();
                  var textLength = thisText.length;
                  if (textLength > count) {
                    var showText = thisText.substring(0, count);
                    var hideText = thisText.substring(count, textLength);
                    var insertText = showText;
                    insertText += '<span class="hide">' + hideText + '</span>';
                    insertText += '<span class="omit">…</span>';
                    insertText += '<a href="" class="nav-open02 more"><i class="fa fa-angle-double-down"></i>もっと読む</a>';
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
              });
            </script>
          </section>

          <?php
            $office_array = array();

            if (!empty((get_field('office_1'))[0])) array_push($office_array, (get_field('office_1'))[0]);
            if (!empty((get_field('office_2'))[0])) array_push($office_array, (get_field('office_2'))[0]);
            if (!empty((get_field('office_3'))[0])) array_push($office_array, (get_field('office_3'))[0]);
            if (!empty((get_field('office_4'))[0])) array_push($office_array, (get_field('office_4'))[0]);
            if (!empty((get_field('office_5'))[0])) array_push($office_array, (get_field('office_5'))[0]);
            if (!empty((get_field('office_6'))[0])) array_push($office_array, (get_field('office_6'))[0]);
            if (!empty((get_field('office_7'))[0])) array_push($office_array, (get_field('office_7'))[0]);
            if (!empty((get_field('office_8'))[0])) array_push($office_array, (get_field('office_8'))[0]);
            if (!empty((get_field('office_9'))[0])) array_push($office_array, (get_field('office_9'))[0]);
            if (!empty((get_field('office_10'))[0])) array_push($office_array, (get_field('office_10'))[0]);

            if (!empty((get_field('office_11'))[0])) array_push($office_array, (get_field('office_11'))[0]);
            if (!empty((get_field('office_12'))[0])) array_push($office_array, (get_field('office_12'))[0]);
            if (!empty((get_field('office_13'))[0])) array_push($office_array, (get_field('office_13'))[0]);
            if (!empty((get_field('office_14'))[0])) array_push($office_array, (get_field('office_14'))[0]);
            if (!empty((get_field('office_15'))[0])) array_push($office_array, (get_field('office_15'))[0]);
            if (!empty((get_field('office_16'))[0])) array_push($office_array, (get_field('office_16'))[0]);
            if (!empty((get_field('office_17'))[0])) array_push($office_array, (get_field('office_17'))[0]);
            if (!empty((get_field('office_18'))[0])) array_push($office_array, (get_field('office_18'))[0]);
            if (!empty((get_field('office_19'))[0])) array_push($office_array, (get_field('office_19'))[0]);
            if (!empty((get_field('office_20'))[0])) array_push($office_array, (get_field('office_20'))[0]);

            if (!empty((get_field('office_21'))[0])) array_push($office_array, (get_field('office_21'))[0]);
            if (!empty((get_field('office_22'))[0])) array_push($office_array, (get_field('office_22'))[0]);
            if (!empty((get_field('office_23'))[0])) array_push($office_array, (get_field('office_23'))[0]);
            if (!empty((get_field('office_24'))[0])) array_push($office_array, (get_field('office_24'))[0]);
            if (!empty((get_field('office_25'))[0])) array_push($office_array, (get_field('office_25'))[0]);
            if (!empty((get_field('office_26'))[0])) array_push($office_array, (get_field('office_26'))[0]);
            if (!empty((get_field('office_27'))[0])) array_push($office_array, (get_field('office_27'))[0]);
            if (!empty((get_field('office_28'))[0])) array_push($office_array, (get_field('office_28'))[0]);
            if (!empty((get_field('office_29'))[0])) array_push($office_array, (get_field('office_29'))[0]);
            if (!empty((get_field('office_30'))[0])) array_push($office_array, (get_field('office_30'))[0]);
          ?>

          <section class="ranking-table">
            <div class="ranking-h2-image">
              <p class="tac"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ranking/ico_ranking.png" alt="ランキング"></p>
              <h2 class="tac">ランキングまとめ</h2>
            </div>
            <div class="ranking_intro_table__wrapper">
              <table id="ranking_intro_table">
                <tr>
                  <th>
                    <!-- <i class="fas fa-crown"></i> -->
                  </th>
                  <th>オフィス名</th>
                  <th>Googleレビュー</th>
                  <th>初期費用</th>
                  <th>月額料金</th>
                </tr>
                <?php foreach($office_array as $i => $data) { ?>
                  <?php $i++; ?>

                  <?php if( $i <= 3 ) { ?>
                    <tr class="ranking_intro_table__tr tr_<?php echo $i ; ?>">
                  <?php } else { ?>
                    <tr class="ranking_intro_table__tr tr_<?php echo $i ; ?> hidden-row">
                  <?php } ?>
                    <td>
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ranking/crown_<?php echo $i ; ?>_d02.png" alt="" width="53">
                      <?php if( get_post_meta($data->ID, 'campaign-text', true) ) { ?>
                        <p class="tac"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ranking/ico_campaign.png" alt="キャンペーン中"></p>
                      <?php } ?>
                    </td>
                    <td>
                      <a href="<?php echo $data->guid; ?>"><?php echo $data->post_title; ?></a>
                      <p class="btn_more"><a href="<?php echo $data->guid; ?>"><span class="intxt">詳細ページを見る<i class="fa fa-angle-double-down"></i></span></a></p>
                    </td>
                    <td>
                      <p id="review_<?php echo $i ; ?>"></p>
                      <p>（
                        <?php if(get_post_meta($data->ID, 'google-review', true)) { ?>
                          <?php echo get_post_meta($data->ID, 'google-review', true); ?>
                        <?php } else { ?>
                          ー
                        <?php } ?>
                      ）</p>
                    </td>
                    <td>
                      <?php echo get_post_meta($data->ID, 'initialcost-1', true); ?>
                    </td>
                    <td>
                      <?php echo get_post_meta($data->ID, 'monthlyfee-1', true); ?>
                    </td>
                  </tr>
                <?php } ?>
              </table>
            </div>
            <p class="more-ranking">
              <a href="#"><i class="fa fa-angle-double-down"></i>もっとランキングを見る</a>
            </p>
          </section>

          <?php if( get_field('introductiontxt02')) { ?>
          <div class="intro_text text_overflow">
            <!-- <?php the_content(); ?> -->
            <?php the_field('introductiontxt02'); ?>
          </div>
          <?php } ?>

          <?php foreach($office_array as $i => $data) { ?>
            <?php $i++; ?>

            <div class="wrapper_rank">
              <!-- 関係フィールド -->
              <section class="space-container" id="space_<?php echo $i ; ?>">
                <?php if( get_post_meta($data->ID, 'vacant', true) == 'あり' ) { ?>
                  <p class="vacancy"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/vacancy.webp" alt="空室あり"></p>
                <?php } ?>

                <div class="space_section__intro">
                  <div class="intro__title">
                    <div class="title__icon">
                      <span class="rank first"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ranking/crown_<?php echo $i; ?>_d02.png" alt="<?php echo $value['default_order'] ; ?>" width="53"></span>
                    </div>
                    <div class="title__text">
                      <h2><?php echo $data->post_title; ?></h2>
                    </div>
                  </div>
                  <p class="date">最終更新日／<time><?php the_time('Y年n月j日'); ?></time></p>
                  <div class="intro__review">
                    <p>Googleレビュー <span id="review_detail<?php echo $i ; ?>"></span>（
                      <?php if(get_post_meta($data->ID, 'google-review', true)) { ?>
                        <?php echo get_post_meta($data->ID, 'google-review', true); ?>
                      <?php } else { ?>
                        ー
                      <?php } ?>
                      ）</p>
                  </div>
                </div>
                <div class="space_address">
                  <p>
                    住所 / <?php echo get_post_meta($data->ID, 'address-pref', true); echo get_post_meta($data->ID, 'address-city', true); echo get_post_meta($data->ID, 'address', true); ?><br />
                    アクセス / <?php echo get_post_meta($data->ID, 'accesstext', true); ?>
                  </p>
                </div>

                <?php if( get_post_meta($data->ID, 'campaign-text', true) ) { ?>
                  <a href="<?php echo $data->guid; ?>" class="space_campaign">
                    <div class="_ttl">キャンペーン</div>
                    <div class="_content"><?php echo get_post_meta($data->ID, 'campaign-text', true); ?></div>
                  </a>
                <?php } ?>

                <div class="space_imgbox">
                  <div class="space_imgbox__left">
                    <div class="_main-img"></div>
                    <ul class="_sub-img">
                      <li>
                        <?php if( get_post_meta($data->ID, 'slider_image1', true) ) { ?>
                          <img src="<?php echo wp_get_attachment_image_src(get_post_meta($data->ID, 'slider_image1', true), 'large')[0]; ?>" />
                        <?php } else { ?>
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" alt="" />
                        <?php } ?>
                      </li>
                      <li>
                        <?php if( get_post_meta($data->ID, 'slider_image2', true) ) { ?>
                          <img src="<?php echo wp_get_attachment_image_src(get_post_meta($data->ID, 'slider_image2', true), 'large')[0]; ?>" />
                        <?php } else { ?>
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" alt="" />
                        <?php } ?>
                      </li>
                      <li>
                        <?php if( get_post_meta($data->ID, 'slider_image3', true) ) { ?>
                          <img src="<?php echo wp_get_attachment_image_src(get_post_meta($data->ID, 'slider_image3', true), 'large')[0]; ?>" />
                        <?php } else { ?>
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" alt="" />
                        <?php } ?>
                      </li>
                      <li class="space_imgbox__detail-link">
                        <a href="<?php echo $data->guid; ?>">もっと<br />見る</a>
                      </li>
                    </ul>
                  </div>
                  <div class="space_imgbox__right">
                    <div class="_floormap">
                      <p class="right-area-subttl text-left">【フロアマップ】</p>
                      <?php if( get_post_meta($data->ID, 'floor-plan', true) ) { ?>
                        <?php echo get_post_meta($data->ID, 'floor-plan', true); ?>
                      <?php } else { ?>
                        <img width="370" height="170" src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" alt="" />
                      <?php } ?>
                      <!-- 間取り図設定例 -->
                      <!-- 
                      <div class="_container">
                        <img src="https://placehold.jp/3d4070/ffffff/800x800.png?text=1" alt="Image 1" class="active" style="display: block" />
                        <img src="https://placehold.jp/3d4070/ffffff/800x800.png?text=2" alt="Image 2" />
                        <img src="https://placehold.jp/3d4070/ffffff/800x800.png?text=3" alt="Image 3" />
                        <img src="https://placehold.jp/3d4070/ffffff/800x800.png?text=4" alt="Image 4" />
                        <img src="https://placehold.jp/3d4070/ffffff/800x800.png?text=5" alt="Image 5" />
                      </div>
                      <div class="_tab-container">
                        <div class="_tabs">
                          <button class="_tab active" data-target="0">12階</button>
                          <button class="_tab" data-target="1">18階</button>
                          <button class="_tab" data-target="2">22階</button>
                          <button class="_tab" data-target="3">40階</button>
                          <button class="_tab" data-target="4">60階</button>
                        </div>
                      </div>
                      -->
                    </div>

                    <div class="_googlemap">
                      <p class="right-area-subttl text-left">【地図】</p>
                      <?php if( get_post_meta($data->ID, 'googlemap-iframe', true) ) { ?>
                        <?php echo get_post_meta($data->ID, 'googlemap-iframe', true); ?>
                      <?php } else { ?>
                        <img width="370" height="170" src="<?php echo get_stylesheet_directory_uri(); ?>/images/spaces/prepare.jpg" alt="" />
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <ul class="space_spec">
                  <li>
                    <p class="_ttl">利用時間</p>
                    <?php if( get_post_meta($data->ID, 'usage-time', true) ) { ?>
                      <p><?php echo get_post_meta($data->ID, 'usage-time', true); ?></p>
                    <?php } else { ?>
                      <p>要お問い合わせ</p>
                    <?php } ?>
                  </li>
                  <li>
                    <p class="_ttl">最大利用人数</p>
                    <?php if( get_post_meta($data->ID, 'max-available', true) ) { ?>
                      <p><?php echo get_post_meta($data->ID, 'max-available', true); ?></p>
                    <?php } else { ?>
                      <p>要お問い合わせ</p>
                    <?php } ?>
                  </li>
                  <li>
                    <p class="_ttl">部屋数</p>
                    <?php if( get_post_meta($data->ID, 'rooms', true) ) { ?>
                      <p><?php echo get_post_meta($data->ID, 'rooms', true); ?></p>
                    <?php } else { ?>
                      <p>要お問い合わせ</p>
                    <?php } ?>
                  </li>
                  <li class="_last">
                    <p class="_ttl">部屋の広さ</p>
                    <?php if( get_post_meta($data->ID, 'room-size', true) ) { ?>
                      <p><?php echo get_post_meta($data->ID, 'room-size', true); ?></p>
                    <?php } else { ?>
                      <p>要お問い合わせ</p>
                    <?php } ?>
                  </li>
                </ul>

                <div class="customer-voice-table">
                  <div class="flex-center">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ranking/ico_review.png" />
                    <h3 class="customer-voice-table__ttl">ご利用された方のクチコミ</h3>
                  </div>
                  <?php if( get_post_meta($data->ID, 'reviews', true) && get_post_meta($data->ID, 'reason', true) && get_post_meta($data->ID, 'main-points', true)) { ?>
                    <h4 class="customer-voice-table__subttl"><?php echo get_post_meta($data->ID, 'reviews', true); ?></h4>
                    <div class="customer-voice-table__content">
                      <div class="customer-voice-table__tr">
                        <div class="customer-voice-table__th">
                          <p>ご利用のきっかけや背景</p>
                        </div>
                        <div class="customer-voice-table__td">
                          <p><?php echo get_post_meta($data->ID, 'reason', true); ?></p>
                        </div>
                      </div>
                      <div class="customer-voice-table__tr">
                        <div class="customer-voice-table__th">
                          <p>重視したポイント</p>
                        </div>
                        <div class="customer-voice-table__td">
                          <p><?php echo get_post_meta($data->ID, 'main-points', true); ?></p>
                        </div>
                      </div>
                    </div>
                    <div class="btn_more">
                      <a href="<?php echo $data->guid; ?>" target="_blank" rel="noopener"
                        ><span class="intxt">もっと読む <i class="fas fa-angle-double-right"></i></span
                      ></a>
                    </div>
                  <?php } else { ?>
                    <p>口コミはまだありません。</p>
                  <?php } ?>
                </div>

                <div class="space_details">
                  <div class="btn_more">
                    <a href="<?php echo $data->guid; ?>" target="_blank" rel="noopener"
                      ><span class="intxt">詳細ページを見る <i class="fas fa-angle-double-right"></i></span
                    ></a>
                  </div>
                </div>
              </section>

              <script>
                document.addEventListener("DOMContentLoaded", function () {
                  document.querySelectorAll("._floormap").forEach(function (floormap) {
                    const tabs = floormap.querySelectorAll("._tab");
                    const images = floormap.querySelectorAll("._container img");

                    tabs.forEach(function (tab, index) {
                      tab.addEventListener("click", function () {
                        // すべてのタブから 'active' クラスを削除
                        tabs.forEach(function (innerTab) {
                          innerTab.classList.remove("active");
                        });
                        // すべての画像を非表示にし、'active' クラスを削除
                        images.forEach(function (img) {
                          img.classList.remove("active");
                          img.style.display = "none";
                        });

                        // クリックされたタブと対応する画像に 'active' クラスを追加し、表示
                        this.classList.add("active");
                        images[index].classList.add("active");
                        images[index].style.display = "block";
                      });
                    });

                    // ページ読み込み時に最初のタブと画像をアクティブ表示
                    if (tabs.length > 0 && images.length > 0) {
                      tabs[0].classList.add("active");
                      images[0].classList.add("active");
                      images[0].style.display = "block";
                    }
                  });
                });
              </script>
            </div>

          <?php } ?>

          <!-- 
          <div class="popular-office">
            <div class="popular-office__ttl">
              <h2>付近の人気オフィス</h2>
            </div>
            <div class="popular-office__list">
              <div class="popular-office__item">
                <div class="popular-office__title">
                  <p>ビジネスエアポート渋谷フクラス</p>
                  <div class="popular-office__title__googlereview">Googleレビュー（4.9）</div>
                </div>
                <div class="popular-office__middle-box">
                  <div class="popular-office__img">
                    <img src="https://placehold.jp/71727f/ffffff/800x800.png?text=%E3%82%AA%E3%83%95%E3%82%A3%E3%82%B9" alt="ここにalt" />
                  </div>
                  <div class="popular-office__access">
                    <p>
                      住所 / 東京都渋谷区桜丘町26-1 セルリアンタワー15階<br />
                      アクセス / JR「渋谷駅」西口より徒歩5分。東急東横線・田園都市線、京王井の頭線、東京メトロ銀座線・半蔵門線・副都心線「渋谷駅」より徒歩5分。
                    </p>
                  </div>
                </div>
                <div class="popular-office__bottom-box">
                  <p>個室オフィス:198,0000(税込)月/〜<br />共有スペース:198,0000(税込)月/〜</p>
                </div>
                <div class="btn_more">
                  <a href="/"
                    ><span class="intxt">詳しく見る <i class="fas fa-angle-double-right"></i></span
                  ></a>
                </div>
              </div>
              <div class="popular-office__item">
                <div class="popular-office__title">
                  <p>ビジネスエアポート渋谷フクラス</p>
                  <div class="popular-office__title__googlereview">Googleレビュー（4.9）</div>
                </div>
                <div class="popular-office__middle-box">
                  <div class="popular-office__img">
                    <img src="https://placehold.jp/71727f/ffffff/800x800.png?text=%E3%82%AA%E3%83%95%E3%82%A3%E3%82%B9" alt="ここにalt" />
                  </div>
                  <div class="popular-office__access">
                    <p>
                      住所 / 東京都渋谷区桜丘町26-1 セルリアンタワー15階<br />
                      アクセス / JR「渋谷駅」西口より徒歩5分。東急東横線・田園都市線、京王井の頭線、東京メトロ銀座線・半蔵門線・副都心線「渋谷駅」より徒歩5分。
                    </p>
                  </div>
                </div>
                <div class="popular-office__bottom-box">
                  <p>個室オフィス:198,0000(税込)月/〜<br />共有スペース:198,0000(税込)月/〜</p>
                </div>
                <div class="btn_more">
                  <a href="/"
                    ><span class="intxt">詳しく見る <i class="fas fa-angle-double-right"></i></span
                  ></a>
                </div>
              </div>
            </div>
          </div>
           -->

        </div>
        <!-- END #article -->
      </div>
      <?php endwhile; endif; ?>
    </div>

    <div class="space_section__aside">

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
    </div>

  </div>


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
          <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" target=”_blank”>
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
  //ランキング3位以降のアコーディオン処理
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".more-ranking a").addEventListener("click", function (event) {
      event.preventDefault();

      const hiddenRows = document.querySelectorAll(".hidden-row");
      hiddenRows.forEach(function (row) {
        if (row.style.display === "none" || window.getComputedStyle(row).display === "none") {
          row.style.display = "table-row";
        } else {
          row.style.display = "none";
        }
      });

      const icon = this.querySelector("i");
      if (icon.classList.contains("fa-angle-double-down")) {
        icon.classList.remove("fa-angle-double-down");
        icon.classList.add("fa-angle-double-up");
        this.innerHTML = '<i class="fa fa-angle-double-up"></i>閉じる';
      } else {
        icon.classList.remove("fa-angle-double-up");
        icon.classList.add("fa-angle-double-down");
        this.innerHTML = '<i class="fa fa-angle-double-down"></i>もっとランキングを見る';
      }
    });
  });

  // サムネイル画像をクリックしたらメイン画像を切り替える処理
  document.addEventListener("DOMContentLoaded", function () {
    const imgBoxLeftElements = document.querySelectorAll(".space_imgbox__left");

    imgBoxLeftElements.forEach(function (box) {
      const mainImgDiv = box.querySelector("._main-img");
      const subImgs = box.querySelectorAll("._sub-img li img");

      // 初期状態で_main-imgに_sub-imgの最初の画像を表示
      if (subImgs.length > 0) {
        const firstImg = subImgs[0];
        const imgToDisplay = document.createElement("img");
        imgToDisplay.src = firstImg.src;
        imgToDisplay.alt = firstImg.alt;
        mainImgDiv.appendChild(imgToDisplay);
      }

      // _sub-imgの画像がクリックされたときの処理
      subImgs.forEach(function (img) {
        img.addEventListener("click", function () {
          // _main-imgの中のimg要素を取得（常に1つだけ存在することを想定）
          const mainImg = mainImgDiv.querySelector("img");
          if (mainImg) {
            mainImg.src = img.src;
            mainImg.alt = img.alt;
          }
        });
      });
    });
  });

  // 右カラム追従処理
  // function adjustOverflowX() {
  //   if (window.innerWidth >= 1201) {
  //     document.body.style.overflowX = "visible";
  //   } else {
  //     document.body.style.overflowX = "hidden";
  //   }
  // }
  // document.addEventListener("DOMContentLoaded", adjustOverflowX);
  // window.addEventListener("resize", adjustOverflowX);
</script>

<script>

jQuery(document).ready(function($){
  var fix = $(".aside__call");

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

  // var count = 120;
  // $('.text_overflow').each(function() {
  //   var thisText = $(this).html();
  //   var textLength = thisText.length;
  //   if (textLength > count) {
  //     var showText = thisText.substring(0, count);
  //     var hideText = thisText.substring(count, textLength);
  //     var insertText = showText;
  //     insertText += '<span class="hide">' + hideText + '</span>';
  //     insertText += '<span class="omit">…</span>';
  //     insertText += '<a href="" class="nav-open02 more"><i class="fa fa-angle-double-down"></i>もっと読む</a>';
  //     $(this).html(insertText);
  //   };
  // });
  // $('.text_overflow .hide').hide();
  // $('.text_overflow .more').click(function() {
  //   $(this).find('i').toggleClass('fa-angle-double-down');
  //   $(this).find('i').toggleClass('fa-angle-double-up');
  //   if ($(this).text() === '閉じる') {
  //     $(this).html('<i class="fa fa-angle-double-down"></i>もっと読む');
  //   } else {
  //     $(this).html('<i class="fa fa-angle-double-up"></i>閉じる');
  //   }
  //   $(this).prev('.omit').toggle()
  //   .prev('.hide').toggle();
  //   return false;
  // });
  //

});
</script>


<?php
get_footer();
?>
