<?php
//encode:UTF-8
//定义的变量:pwtitle:pediawiki系列函数共享条目名
$pwtitle;

//该函数是pediawiki功能的主函数(条目标题,条目加粗)
function ext_pediawiki($title,$titlebols=true){
    $GLOBALS["pwtitle"]=$title;
    ext_pw_titlebold();
}

//该函数用于在条目正文第一次出现条目名时将其加粗
function ext_pw_titlebold(){
    global $lang;
    $tbtext=ideas_view($GLOBALS["pwtitle"]);
    if (ideas_str_find($tbtext,"'''".$GLOBALS["pwtitle"]."'''")==false){
        if (ideas_str_find($tbtext,"<b>".$GLOBALS["pwtitle"]."</b>")==false){
            $tbtext=preg_replace("/".$GLOBALS["pwtitle"]."/","'''".$GLOBALS["pwtitle"]."'''",$tbtext,"1");
        }
    }
    ideas_edit($GLOBALS["pwtitle"],$tbtext,$GLOBALS["ideastext"][$lang]["wikied"]);
    return;
}

?>
