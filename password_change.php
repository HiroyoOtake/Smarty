<?php

/*Smartyを使えるようにする*/
require 'Smarty/Smarty.class.php';
$smarty = new Smarty;

/*SESSIONを使えるようにする*/
session_start();

/*SESSIONの受け取り*/
$sales_id = $_SESSION['sales_id'];
//var_dump($_SESSION);

/*POSTの受け取り*/
@$c_pass = $_POST['c_pass'];
@$n_pass = $_POST['n_pass'];
@$n_pass_r = $_POST['n_pass_r'];
//var_dump($c_pass);
//var_dump($n_pass);
//var_dump($n_pass_r);

/* lu_salesからログイン中のユーザのデータを読みだす。wehre=$_SESSION['sales_id']*/
@$con = pg_connect("host=127.0.0.1 port=5432 dbname=download user=postgres password=");

if ($con == false) {
	print("認証データベースへの接続に失敗しました。理由；$php_errormsg<br>\n");
	exit;
}

$sql = "SELECT * FROM lu_sales WHERE sales_id=$sales_id";
$result = pg_query($con,$sql);
$sales_password = pg_fetch_result($result, 0, 6);
//var_dump($sales_password);

/*画面で入力されたパスワードのバリデーション(データチェックすること)*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	/*現在のパスワード(画面で入力された)DBに入っている現在のパスワードが一致してるかチェック
	一致してなければエラー
	一致してれば次のチェック*/
	if ($sales_password !== $c_pass) {
		$smarty->assign("n_pass_error", "*現在のパスワードがまちがっています。");
		$smarty->display('password_change.tpl');
		exit;
	} else {
		//echo "c_pass OK";

		/*新しいパスワードが一致しているか又は空じゃないかチェック*/ 
		/*ver1
		if ($n_pass == $n_pass_r && $n_pass !== "" && $n_pass_r !== "") {
		echo "n_pass OK";
		} else {
			$smarty->assign("n_pass_error", "新しいパスワードがまちがっています。");
			$smarty->display('password_change.tpl');
			exit;
		} 
		*/

		/*ver2*/
		if ($n_pass !== $n_pass_r || $n_pass == "" || $n_pass_r == "") {
			$smarty->assign("n_pass_error", "*新しいパスワードがまちがっています。");
			$smarty->display('password_change.tpl');
			exit;
		} else {
			//echo "n_pass OK";

			/*DBのパスワード変更 UPDATE where= sales_id*/
			@$con = pg_connect("host=127.0.0.1 port=5432 dbname=download user=postgres password=");

			if ($con == false) {
				print("認証データベースへの接続に失敗しました。理由；$php_errormsg<br>\n");
				exit;
			}

			$sql = "UPDATE lu_sales SET password='$n_pass' WHERE sales_id=$sales_id";
			$result = pg_query($con,$sql);
			//$sql = "SELECT * from lu_sales WHERE sales_id=$sales_id";
			//$result = pg_query($con,$sql);
			//@$sales_password = pg_fetch_result($result, 0, 6);
			//var_dump($sales_password);

			header("Location:password_change_thanks.php");
		} 

	} 

} else {

/*Smartyでhtmlを読み込む*/
$smarty -> display('password_change.tpl');

}

/*
if (1) {
	$smarty->assign("n_pass_error", "新しいパスワードを入力してください。");
	$smarty->display('password_change.tpl');
        exit;
}
$smarty -> assign("test", "足湯");
*/

 ?>
