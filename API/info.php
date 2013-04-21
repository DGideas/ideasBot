<?php
//encode:UTF-8

//该函数用于获取执行相应动作的token(标题,动作)
//$title:指明了目标页面,这个参数是必需的
//$intoken:指明了需要获得的令牌种类,默认为edit
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+info
function ideas_get_token($title,$intoken="edit"){
    $post="action=query&prop=info&titles=".$title."&intoken=".$intoken;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page[0]->attributes()->edittoken;
}

?>
