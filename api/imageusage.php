<?php
//encode:UTF-8

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

?>
