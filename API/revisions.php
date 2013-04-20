<?php
//encode:UTF-8

//该函数用于获得特定单个页的Wikied文本(页面名称)
//$pagename:指明了目标页面名称,这个参数是必需的
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideas_view($pagename){
    $post="action=query&prop=revisions&rvprop=content&format=xml&titles=".$pagename;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $wikied=$xml->xpath("//rev");
    return $wikied[0];
}

//该函数用于获得第0段的Wikied文本(页面名称)
//$pagename:指明了目标页面名称,这个参数是必需的
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideas_view_top($pagename){
    $post="action=query&prop=revisions&rvsection=0&rvprop=content&format=xml&titles=".$pagename;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $wikied=$xml->xpath("//rev");
    return $wikied[0];
}

//该函数用于获得页面最近的编者(页面名称)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
//$title:指明了目标页面名称,这个参数是必需的
function ideas_get_author($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=15&rvprop=user";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //用法:query->pages->page->revisions->rev[$i]->attributes()->user
}

//该函数用于获得页面的作者(页面名称)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
//$title:指明了目标页面名称,这个参数是必需的
function ideas_get_creator($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=1&rvdir=newer";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page->revisions->rev[0]->attributes()->user;
    //直接返回页面作者
}

//该函数用于获得页面最后的编辑时间
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
//$title:指明了目标页面名称,这个参数是必需的
function ideas_get_last_edit_time($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=1";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page->revisions->rev[0]->attributes()->timestamp;
    //直接返回最后编辑时间(推荐使用ideas_deal_timestamp($timestamp,$returntype)函数处理MediaWiki格式时间戳)
}

//该函数用于获取页面的大小
//$title:指明了目标页面名称,这个参数是必需的
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideas_get_size($title){
    $post="action=query&prop=revisions&titles=".$title."&rvprop=size";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page[0]->revisions->rev->attributes()->size;
}


?>
