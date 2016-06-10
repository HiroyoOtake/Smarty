<?php
require 'Smarty/Smarty.class.php';
$smarty = new Smarty;

$smarty -> assign("test", "足湯");
$smarty -> display('password_change.tpl');
 ?>
