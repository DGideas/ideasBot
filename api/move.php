<?php
//encode:UTF-8

//该函数用于简单移动页面(标题,原因),同时移动讨论页,不移动子页面,保留重定向
//$title:指明了目标页面(移动前)的标题,这个参数是必需的
//$titletarget:指明了目标页面(移动后)的标题,这个参数是必需的
//$reason:指明了移动页面的原因
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=move
function ideas_move($title,$titletarget,$reason=""){
    //步骤1:获得令牌
    $edittokenhtml=ideas_get_token($title,"move");
    //步骤2:移动页面
    if ($reason==""){
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml;
    }else{
        $reason=ideas_summary($reason); //处理编辑摘要头尾
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml."&reason=".$reason;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

//该函数用于简单移动页面(标题,原因),同时移动讨论页,不移动子页面,不保留重定向
//$title:指明了目标页面(移动前)的标题,这个参数是必需的
//$titletarget:指明了目标页面(移动后)的标题,这个参数是必需的
//$reason:指明了移动页面的原因
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=move
function ideas_move_noredirect($title,$titletarget,$reason=""){
    //步骤1:获得令牌
    $edittokenhtml=ideas_get_token($title,"move");
    //步骤2:移动页面
    if ($reason==""){
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml."&noredirect=";
    }else{
        $reason=ideas_summary($reason); //处理编辑摘要头尾
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml."&reason=".$reason."&noredirect=";
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

?>
