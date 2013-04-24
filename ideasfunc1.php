<?php
//encode:UTF-8
//帮助文档:help/ideasfunc.txt


//该函数用于获得本地维基图片用量状况(标题,名称空间)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+imageusage
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//$iutitle:指明了目标图片名称,这个参数是必需的
//$iunamespace:指明了需要搜索的名称空间,默认为主名称空间
function ideas_get_image_usage($iutitle,$iunamespace="0"){
    $post="action=query&list=imageusage&iulimit=5000&iufilterredir=nonredirects&iunamespace=".$iunamespace."&iutitle=".$iutitle;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //目标页面标题:query->imageusage->iu[$i]->attributes()->title
}

//该函数用于获得特定用户的主页面名称空间用户贡献(用户名,编辑次数(默认为100))
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+usercontribs
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//$user:指明了目标用户,这个参数是必需的
//$times:指明了要查询的条目数,默认为100
function ideas_get_user_contribs($user,$times="100"){
    $post="action=query&list=usercontribs&ucuser=".$user."&uclimit=".$times."&ucnamespace=0";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //所撰条目:query->usercontribs->item[$i]->attributes()->title
    //编辑时间:query->usercontribs->item[$i]->attributes()->timestamp
    //名称空间:query->usercontribs->item[$i]->attributes()->ns
}

?>
