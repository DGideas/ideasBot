<?php
//encode:UTF-8

//该函数用于获取最近更改(recentchanges)的条目(查询数量,查询种类,名称空间,筛选器,额外)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+recentchanges
//$rclimit:指明了返回最近更改的数量,默认为100
//$rctype:指明了最近更改类型的过滤器,默认为新条目和编辑
//$rcnamespace:指明了最近更改名称空间的过滤器,默认为主名称空间
//$rcshow:指明了最近更改属性的过滤器,默认为不显示机器人更改和重定向页
//$extra:指明了附加到POST请求的额外内容,以&开头
function ideas_get_recent_changes($rclimit="100",$rctype="new|edit",$rcnamespace="0",$rcshow="!bot|!redirect",$extra=""){
    if ($extra=""){
        $post="action=query&list=recentchanges&rctype=".$rctype."&rclimit=".$rclimit."&rcnamespace=".$rcnamespace."&rcshow=".$rcshow;
    }else{
        $post="action=query&list=recentchanges&rctype=".$rctype."&rclimit=".$rclimit."&rcnamespace=".$rcnamespace."&rcshow=".$rcshow.$extra;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //条目名称为:query->recentchanges->rc[$i]->attributes()->title
    //条目编者为:query->recentchanges->rc[$i]->attributes()->user
    //条目名称空间为:query->recentchanges->rc[$i]->attributes()->ns
    //其他的属性:pageid,revid,timestamp......
}

?>
