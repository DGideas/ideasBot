<?php
//Inculde file
//Author:DGideas
    include_once (dirname(__FILE__)."/config.php");
    include_once ("ideasfunc1.php");
    include_once ("ideasfunc2.php");
	include_once ("mediawiki.php");
	include_once ("DGStorage.php");
	
    //将您使用的拓展置于此处
    //include_once ("extension/checkad.php"); //取消注释以启用该拓展
    //include_once ("extension/ideasdb.php"); //取消注释以启用该拓展
    include_once ("extension/import.php"); //注释以禁用该拓展
    //include_once ("extension/pediawiki.php"); //取消注释以启用该拓展
    //include_once ("extension/testfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhwpfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhmgfunc1.php"); //取消注释以启用该拓展
	
	include_once ("extension/example.php"); //这是一个例子,您可以覆盖它或者仿照它添加拓展
	
    $ideastext=array();
    include_once ("translation/en.php");
    include_once ("translation/zh-hans.php");
    include_once ("translation/zh-hant.php");
    include_once ("translation/jp.php");
?>