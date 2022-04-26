<?php
require_once "dbclass.php";
$db = new DB();
$arr = $db->runQuery("select * from tblproduct");
print_r($arr);
?>
