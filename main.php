<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php
include_once ('config.php');
include_once ('zhwpfunc1.php');
include_once ('ideasfunc1.php');
ideas_login();

zhwp_check_50();
zhwp_check_ad();
zhwp_clean_sandbox();
zhwp_clean_pic_sandbox();

//最后几行
echop ();
echo "已登出";
?>
