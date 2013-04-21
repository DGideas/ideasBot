<?php
//encode:UTF-8

//该函数用于删除页面(标题,原因)
//$title:指明了目标页面的标题,这个参数是必需的
//$reason:指明了删除页面的原因
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=delete
function ideas_delete($title,$reason=""){
    //步骤1:获得令牌
    $edittokenhtml=ideas_get_token($title,"delete");
    //步骤2:删除页面
    if ($reason==""){
        $post="action=delete&title=".$title."&token=".$edittokenhtml;
    }else{
        $reason=ideas_summary($reason); //处理编辑摘要头尾
        $post="action=delete&title=".$title."&token=".$edittokenhtml."&reason=".$reason;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

?>
