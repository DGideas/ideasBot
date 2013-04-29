<?php
//encode:UTF-8

//该函数用于注册用户(用户名,密码)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=createaccount
function ideas_reg($username,$password){
    global $lgname,$lgpassword,$lang;
    $result=ideas_reg_core($username,$password);
    if ($result == "Success"){
        echo $GLOBALS["ideastext"][$lang]["ok"];
        echop();
    }else{
        echo $GLOBALS["ideastext"][$lang]["error"];
        echop();
        echo $result;
        ideas_feedback($GLOBALS["ideastext"][$lang]["loginfailed"].":".$result);
        //通常的错误是wrongpassword,needtoken,wrongtoken.
    }
    return;
}

//该函数是注册功能的核心模块
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=createaccount
function ideas_reg_core($name,$password){
    $post="action=createaccount&name=".$name."&password=".$password;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $token = $xml->createaccount[0]->attributes()->token;
    $post="action=createaccount&name=".$name."&password=".$password."&lgtoken=".$token;
    $data=ideas_connect($post);
    $xml = simplexml_load_string($data);
    //登陆过程完成
    return $xml->createaccount[0]->attributes()->result;
}


?>
