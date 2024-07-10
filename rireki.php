<?php
global $rireki;

//記事ページのみcookieに登録
if(is_singular('space') ){

//閲覧履歴用のcookieが存在する場合
if( isset($_COOKIE['rireki']) ){

//配列にする
$rireki = explode(",", $_COOKIE['rireki']);

//cookieに現在の記事IDがあるかどうか調べる
$aruno = in_array($post->ID, $rireki);

//ある場合の処理
if($aruno == true){

//cookieにある現在の記事IDを削除（順番整理＆表示除外用）
$rireki = array_diff($rireki,array($post->ID));
$rireki = array_values($rireki);
}
$set_rireki = $rireki;

//cookieに登録
$touroku = $post->ID.','.implode(",", $set_rireki);
setcookie( 'rireki', $touroku, time() + 7776000,'/','hubspaces.jp', 1);

//cookieに現在の記事IDが無い場合の処理
}else{
$touroku = $post->ID;
setcookie( 'rireki', $touroku, time() + 7776000,'/','hubspaces.jp', 1);
}

//記事ページ以外ならcookieの読み込みのみ
}else{
if( isset($_COOKIE['rireki']) ){
$rireki = explode(",", $_COOKIE['rireki']);
}
}
?>