<?php
//encode:UTF-8

//该函数用于登录(用户名,密码)
//$site:指明了要登陆到的站点,默认为$GLOBALS["wiki"]
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=login
function ideas_login($wiki="",$username="",$password=""){
    global $lgname,$lgpassword,$ideastext,$defaultlanguage;
    if ($username==""){
        $result=ideas_login_core($lgname,$lgpassword);
    }else{
        $result=ideas_login_core($username,$password);
    }
    if ($result == "Success"){
        echo $GLOBALS["ideastext"][$defaultlanguage]["loginsuccess"];
        $GLOBALS["islogin"]=true;
        echop();
    }else{
        echo $GLOBALS["ideastext"][$defaultlanguage]["loginfailed"];
        echop();
        echo ($result);
        ideas_feedback($GLOBALS["ideastext"][$defaultlanguage]["loginfailed"].":".$result);
        //通常的错误是wrongpassword,needtoken,wrongtoken.
        if ($result=="needtoken"){
            echo $GLOBALS["ideastext"][$defaultlanguage]["needRW"];
            exit();
        }elseif ($result=="wrongtoken"){
            $result=ideas_login_core($lgname,$lgpassword,$wiki);
        }
    }
    return;
}

//该函数是登录功能的核心模块
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=login
//Note:$site参数暂时不用
//$lgname:指明了登录的用户名
//$lgpassword:指明了用户名对应的密码
//$site:指明了使用的站点
function ideas_login_core($lgname,$lgpassword){
    ideas_clean_cookie(); //登录前先清除cookie缓存
    $post="action=login&lgname=".$lgname."&lgpassword=".$lgpassword;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $token = $xml->login[0]->attributes()->token;
    $post="action=login&lgname=".$lgname."&lgpassword=".$lgpassword."&lgtoken=".$token;
    $data=ideas_connect($post);
    $xml = simplexml_load_string($data);
    //登陆过程完成
    return $xml->login[0]->attributes()->result;
}

?>
