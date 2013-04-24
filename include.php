<?php
    include_once (dirname(__FILE__)."/config.php");
    include_once ("translation.php");
    include_once ("ideasfunc1.php");
    include_once ("ideasfunc2.php");
    include_once ("API/connect.php");
    include_once ("API/delete.php");
    include_once ("API/edit.php");
    include_once ("API/login.php");
    include_once ("API/move.php");
    include_once ("API/recentchanges.php");
    include_once ("API/revisions.php");
    include_once ("API/info.php");
    include_once ("API/search.php");
    //include_once ("labs/cluster.php") //取消注释以启用测试功能
    //将您使用的拓展置于此处
    //include_once ("extension/ideasdb.php"); //取消注释以启用该拓展
    //include_once ("extension/import.php"); //取消注释以启用该拓展
    //include_once ("extension/tfsfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhwpfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhmgfunc1.php"); //取消注释以启用该拓展
    include_once ("extension/example.php"); //这是一个例子,您可以覆盖它或者仿照它添加拓展
    
    ideas_webverify();
?>
