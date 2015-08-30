<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<?php
include_once("include.php");
$a=new ideasBot();
$a->set('zhwp','username','password');
$a->connect();
print($a->get('首页'));

?>