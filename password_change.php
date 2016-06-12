<?php

/*Smartyを使えるようにする*/
require 'Smarty/Smarty.class.php';
$smarty = new Smarty;

$p_c_tpl = "password_change.tpl"; 

/*SESSIONを使えるようにする*/
session_start();

/*SESSIONの取り出し*/
$sales_id = $_SESSION['sales_id'];

/*POSTの受け取り*/
$c_pass = @$_POST['c_pass'];
$n_pass = @$_POST['n_pass'];
$n_pass_r = @$_POST['n_pass_r'];

/* lu_salesからログイン中のユーザのデータを読みだす。*/
$con = pg_connect("host=127.0.0.1 port=5432 dbname=download user=postgres password=");

if ($con == false) {
	print("認証データベースへの接続に失敗しました。");
	exit;
}

// テキストデータをエスケープする
$escaped = pg_escape_string($sales_id);

$sql = "SELECT * FROM lu_sales WHERE sales_id='$escaped'";
$result = pg_query($con,$sql);
$sales_password = pg_fetch_result($result,'password');

/*画面で入力されたパスワードのバリデーション*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$errors = array();

	if ($sales_password !== $c_pass) {
	  $errors['c_pass_error'] = "*現在のパスワードが間違っています。<br>";
	}

	if ($n_pass !== $n_pass_r || $n_pass == "") {
	  $errors['n_pass_error'] = "*新しいパスワードは同じものを2回入力して下さい。<br>";
	}

	if (strlen($n_pass) < 8) {
	  $errors['count_error'] = "*8文字以上のパスワード変更を入力して下さい。<br>";
	} else {
		$escaped2 = pg_escape_string($n_pass);
		$sql = "UPDATE lu_sales SET password='$escaped2' WHERE sales_id='$escaped'";
		$result = pg_query($con,$sql);
        } 

	if ($result == false) {
	  $errors['sql_error'] = "*クエリが正しく動作していません。";
	}

	if ($errors) {
	  $smarty->assign('errors', $errors);
	  $smarty->display($p_c_tpl);
	  exit;
	}

header('Location: password_change_thanks.php');


} else { 

/*Smartyでhtmlを読み込む*/
$smarty -> display($p_c_tpl);

}

 ?>
