<?php
//encode:UTF-8

//该函数用于基于条件查询条目(非重定向)列表(条件)
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+allpages
//$extra:指明了附加到POST请求的信息,以一个&开头
function ideas_list($extra){
    if ($extension==""){
        $post="action=query&list=allpages&aplimit=5000&apfilterredir=nonredirects";
    }else{
        $post="action=query&list=allpages&aplimit=5000&apfilterredir=nonredirects&".$extra;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //请注意,如果没有搜索到任何结果,使用返回值可能造成不可预料的后果
    //搜索内容为:query->allpages->p[$i]->attributes()->title
}

?>
