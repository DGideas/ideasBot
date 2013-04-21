<?php
//encode:UTF-8

//该函数用于跨维基导入页面,是API:action=import的变通方法
//使用前,请确保至少登陆目标维基
//$fromwiki:指定了来源维基
//$targetwiki:指定了目标维基
//$fromtitle:指定了来源页面名称
//$targetwiki:指定了目标页面名称
//$summary:指定了编辑摘要(留空则填写缺省摘要)
function ext_import($fromwiki,$targetwiki,$fromtitle,$targettitle,$summary=""){
    global $lang;
    $GLOBALS["wiki"]=$fromwiki;
    $wikied=ideas_view($fromtitle);
    $GLOBALS["wiki"]=$targetwiki;
    if ($summary!=""){
        ideas_edit($targettitle,$wikied,$summary);
    }else{
        ideas_edit($targettitle,$wikied,$GLOBALS["ideastext"][$lang]["importwiki"]);
    }
    return;
}

?>
