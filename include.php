<?php
//Inculde file
//Author:DGideas
    include_once ("/config.php");
    include_once ("ideasfunc2.php");
	include_once ("mediawiki.php");
	include_once ("DGStorage.php");
	
    //将您使用的拓展置于此处
    //include_once ("extension/ideasdb.php"); //取消注释以启用该拓展
    include_once ("extension/import.php"); //注释以禁用该拓展
    //include_once ("extension/pediawiki.php"); //取消注释以启用该拓展
    //include_once ("extension/testfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhwpfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhmgfunc1.php"); //取消注释以启用该拓展
	
    $ideastext=array();
    include_once ("translation/en.php");
    include_once ("translation/zh-hans.php");
    include_once ("translation/zh-hant.php");
    include_once ("translation/jp.php");
?>