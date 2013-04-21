<?php
//encode:UTF-8

//该函数用于删除条目(标题,内容,摘要)(覆盖!)
//WARNING:本函数会覆盖页面原有内容
//$title:指明了目标页面的标题,这个参数是必需的
//$text:指明了页面的内容
//$summary:指明了编辑摘要,默认为空
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=edit
function ideas_edit($title,$text,$summary=""){
    //步骤1:获得edittoken
    $edittokenhtml=ideas_get_token($title,"edit");
    $text=urlencode($text);//HTML编码
    $summary=urlencode($summary);//HTML编码
    //步骤2:添加新段落
    if ($summary==""){
        $post="action=edit&title=".$title."&text=".$text."&token=".$edittokenhtml;
    }else{
        $summary=ideas_summary($summary); //处理编辑摘要头尾
        $post="action=edit&title=".$title."&text=".$text."&token=".$edittokenhtml."&summary=".$summary;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

?>
