<?php
    include_once (dirname(__FILE__)."/config.php");
    include_once ("translation.php");
    include_once ("ideasfunc1.php");
    include_once ("ideasfunc2.php");
    include_once ("api/allpages.php");
    include_once ("api/createaccount.php");
    include_once ("api/connect.php");
    include_once ("api/delete.php");
    include_once ("api/edit.php");
    include_once ("api/imageusage.php");
    include_once ("api/info.php");
    include_once ("api/login.php");
    include_once ("api/move.php");
    include_once ("api/recentchanges.php");
    include_once ("api/revisions.php");
    include_once ("api/usercontribs.php");
    include_once ("api/search.php");
    //include_once ("labs/cluster.php") //取消注释以启用测试功能
    //将您使用的拓展置于此处
    //include_once ("extension/checkad.php"); //取消注释以启用该拓展
    //include_once ("extension/ideasdb.php"); //取消注释以启用该拓展
    //include_once ("extension/import.php"); //取消注释以启用该拓展
    //include_once ("extension/pediawiki.php"); //取消注释以启用该拓展
    //include_once ("extension/tfsfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhwpfunc1.php"); //取消注释以启用该拓展
    //include_once ("extension/zhmgfunc1.php"); //取消注释以启用该拓展
    include_once ("extension/example.php"); //这是一个例子,您可以覆盖它或者仿照它添加拓展
    
    ideas_webverify();
?>
