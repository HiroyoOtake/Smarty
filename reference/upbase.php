<!DOCTYPE html>
<html lang="ja">
<head>
<link href='common/js/rome.css' rel='stylesheet' type='text/css' />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<title>AUR STORAGE</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="css/style.css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script src="sample.js"></script>
</head>
<body>

  <header>
  <div></div>
  </header>
  <div class="body1" align="center">
  <a href="index.php"><img src="img/logo_s.png" alt="logo"></a>
      <br>
      <p style="font-size:16px; color:#808080;">アップロード情報を入力してください。<br>

      <p class="attention">
      ※最大アップロードサイズは1.5GBです。<br>
      ※ダウンロード終了日時を過ぎると、実ファイルがデータベースから削除され復元できなくなります。<br>
      </p>

  <FORM ACTION="upload_check.php" METHOD=post NAME=FORM1 ENCTYPE="multipart/form-data">
  <table class="aaa" align="center">
  <tr>
  <th style="color : #4D4D4D; text-align:right;">顧客名称&nbsp&nbsp</th>
  <td><INPUT TYPE="text" NAME="custname" SIZE="30" value="株式会社●●●●" /></td>
  </tr>
  <tr>
  <th style="color:#4D4D4D;text-align:right;">ファイル名&nbsp&nbsp</th>
  <td>
  <INPUT TYPE="file" NAME="file1" SIZE="30"></td>
  </tr>
  <th style="color : #4D4D4D; text-align:right;">担当者名&nbsp&nbsp</th>
  <td>
  <INPUT TYPE="hidden" NAME="sales_name">
  <SELECT name="sales_id">

<?php

/*セッション開始*/
session_start();

  $SalesId = $_SESSION['sales_id'];

  $con = pg_connect("host=localhost port=5432 dbname=download user=postgres password=hottamale");

        if ($con == false ) {
                print(" cannot connect database grace ");
                exit;
        }

        $sql = "select sales_id, sales_name from lu_sales where category_id notnull order by category_id asc, sales_sort_id asc";

        $result = pg_exec($sql);

        if ($result == false) {
                printf ("sql fail");
                exit;
        }

        $rows = pg_numrows($result);
        $columns = pg_numfields($result);

        for ($i = 0; $i < $rows; $i++)
        {
                $sales_id = pg_result($result,$i,0);
                $sales_name = pg_result($result,$i,1);

                if($SalesId == $sales_id ) {
                        print ("<OPTION VALUE=\"$sales_id\" selected>$sales_name</OPTION>\n");
                } else {
                        print ("<OPTION VALUE=\"$sales_id\">$sales_name</OPTION>\n");
                }
        }

        $sql_s = "select sales_id, sales_name from lu_sales where sales_id='$SalesId'";
        $result_s = pg_query($con,$sql_s);
        $sales_name_s = pg_fetch_result($result_s, 0, 1);
        $sales_id_s = pg_fetch_result($result_s, 0, 0);
        var_dump($sales_name_s);
　?>

</select>
</td>
  </tr>
  <th style="color : #4D4D4D; text-align:right;">ダウンロード開始日時&nbsp&nbsp</th>
  <td><input id='Input_1' class='input' name='starttime' SIZE="30" value="<?php print (date('Y-m-d H:i')) ?>"></td>
  </tr>
  <tr>
  <th style="color : #4D4D4D; text-align:right;">ダウンロード終了日時&nbsp&nbsp</th>
  <td><input id='Input_2' class='input' name='endtime' SIZE="30" value="<?php print (date('Y-m-d H:i' , strtotime('+1 week'))) ?>"></td>
  </tr>
  <tr>
  </table>
  <table align="center"cellspacing="15"><tbody>
  <tr>
  <td>
  <a href="upbase.php"><img src="img/button-reset.png"></a>　
  </td>
  <td>
  <input type="hidden" name="sales_id_s" value="<?php print $sales_id_s; ?>">
  <input type="hidden" name="sales_name" value="<?php print $sales_name_s; ?>">
  <input type="image" alt="実行" width="100" height="30" src="img/button-run.png" />
  </FORM>
  </td>
  </tr>
  </tbody></table>

  <br>

  <form action="view.php" method="post" name="FORM2">
      <input type="hidden" name="sales_id_s" value="<?php print $sales_id_s; ?>">
      <a href="javascript:document.FORM2.submit()"><font color="#808080">過去一ヶ月分のアップロード情報一覧</font></a>
  </form>
  </p>

<script type='text/javascript' src='common/js/rome.js'></script>
<script type="text/javascript">
rome(Input_1,  {
  dateValidator: rome.val.beforeEq(Input_2)
});
rome(Input_2, {
  dateValidator: rome.val.afterEq(Input_1)
});
　</script>
 </div>
　</body>
　</html>

