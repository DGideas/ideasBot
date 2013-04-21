<?php
//encode:UTF-8

//该函数用于基于关键字的简单搜索(关键字,名称空间代码)
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+search
//$searchtext:指明了需要搜索的内容
//$namespace:指明了需要搜索的名称空间
function ideas_search($searchtext,$namespace="0"){
    $post="action=query&list=search&srsearch=".$searchtext."&srnamespace=".$namespace;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //搜索条数为:query->searchinfo->attributes()->totalhits
    //搜索内容为:query->search->p[$i]->attributes()->title
}

?>
