<?php

/*Smartyを使えるようにする*/
require 'Smarty/Smarty.class.php';
$smarty = new Smarty;

$p_c_tpl = "password_change.tpl"; 

/*SESSIONを使えるようにする*/
session_start();

/*SESSIONの取り出し*/
$sales_id = $_SESSION['sales_id'];
//var_dump($_SESSION);

/*POSTの受け取り*/
$c_pass = @$_POST['c_pass'];
$n_pass = @$_POST['n_pass'];
$n_pass_r = @$_POST['n_pass_r'];
//var_dump($c_pass);
//var_dump($n_pass);
//var_dump($n_pass_r);

/* lu_salesからログイン中のユーザのデータを読みだす。wehre=$_SESSION['sales_id']*/
$con = pg_connect("host=127.0.0.1 port=5432 dbname=download user=postgres password=");

if ($con == false) {
//	print("認証データベースへの接続に失敗しました。理由；$php_errormsg<br>\n");
	print("認証データベースへの接続に失敗しました。");
	exit;
}

// テキストデータをエスケープする
$escaped = pg_escape_string($sales_id);
$sql = "SELECT * FROM lu_sales WHERE sales_id='$escaped'";
$result = pg_query($con,$sql);
$sales_password = pg_fetch_result($result,'password');
//var_dump($sales_password);
//exit;

/*画面で入力されたパスワードのバリデーション(データチェックすること)*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	/*現在のパスワード(画面で入力された)DBに入っている現在のパスワードが一致してるかチェック
	一致してなければエラー
	一致してれば次のチェック*/
	if ($sales_password !== $c_pass) {
		$smarty->assign("c_pass_error", "*現在のパスワードがまちがっています。");
		$smarty->display($p_c_tpl);
		exit;
	} else {
		//echo "c_pass OK";

		if ($n_pass !== $n_pass_r || $n_pass == "") {
			$smarty->assign("n_pass_error", "*新しいパスワードがまちがっています。");
			$smarty->display($p_c_tpl);
			exit;
		} else {
			//echo "n_pass OK";

			if (strlen($n_pass) < 8) {
				//$c = strlen($n_pass);	
                                //var_dump($c);
                                //exit;
				$smarty->assign("count_error", "*パスワードは8文字以上を入力して下さい。");
				$smarty->display($p_c_tpl);
				exit;
			} else {

				$escaped2 = pg_escape_string($n_pass);
				$sql = "UPDATE lu_sales SET password='$escaped2' WHERE sales_id='$escaped'";
				$result = pg_query($con,$sql);

				if ($result == false) {
					$smarty->assign("sql_error", "*クエリが正しく動作していません。");
					$smarty->display($p_c_tpl);
					exit;
				} else {
					header("Location:password_change_thanks.php");
			}
		} 

	} 
}

} else {

/*Smartyでhtmlを読み込む*/
$smarty -> display($p_c_tpl);

}

 ?>
