<?php
//encode:UTF-8

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
