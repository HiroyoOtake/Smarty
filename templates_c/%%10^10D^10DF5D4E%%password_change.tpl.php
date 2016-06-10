<?php /* Smarty version 2.6.5-dev, created on 2016-06-11 03:43:29
         compiled from password_change.tpl */ ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<link href='common/js/rome.css' rel='stylesheet' type='text/css' />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<title>AUR STORAGE</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="style.css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script src="sample.js"></script>
</head>
<body>
<?php echo $this->_tpl_vars['test']; ?>

  <header>
  <div></div>
  </header>
  <div class="body1" align="center">
  <a href="index.php"><img src="img/logo_s.png" alt="logo"></a>
      <br>
      <p style="font-size:16px; color:#808080;">パスワード情報を入力してください。<br>
  <FORM ACTION="upload_check.php" METHOD=post NAME=FORM1 ENCTYPE="multipart/form-data">
  <table class="aaa" align="center">
  <tr>
  <th style="color : #4D4D4D; text-align:right;">現在のパスワード&nbsp&nbsp</th>
  <td><INPUT TYPE="text" NAME="" SIZE="30" /></td>
  </tr>
  <tr>
  <th style="color : #4D4D4D; text-align:right;">新しいパスワード&nbsp&nbsp</th>
  <td><INPUT TYPE="text" NAME="" SIZE="30" /></td>
  </tr>
  <tr>
  <th style="color : #4D4D4D; text-align:right;">新しいパスワード(確認用)&nbsp&nbsp</th>
  <td><INPUT TYPE="text" NAME="" SIZE="30" /></td>
  </tr>
  </table>
  <table align="center"cellspacing="15"><tbody>
  <tr>
  <td>
  <a href="upbase.php"><img src="img/button-reset.png"></a>
  </td>
  <td>
  <input type="image" alt="実行" width="100" height="30" src="img/touroku_03.png" />
  </FORM>
  </td>
  </tr>
  </tbody></table>

  <br>


 </div>
</body>
</html>
