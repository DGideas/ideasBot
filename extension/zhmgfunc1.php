<?php
//encode:UTF-8

//该函数用于清空中文萌娘百科沙盒
//目前只支持大小为16字节的沙箱
function ext_zhmg_clean_sandbox($sandboxname="Help:沙盒"){
    if (ideas_get_size($sandboxname)!="16"){
        $author=ideas_get_author($sandboxname);
        $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
        ideas_edit($sandboxname,"{{沙盒顶部}}","清理沙盒");
        ideas_log("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
    }else{
            if (ideas_str_find(ideas_view($sandboxname),"{{沙盒顶部}}")==true){
        }else{
            $author=ideas_get_author($sandboxname);
            $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
            ideas_edit($sandboxname,"{{沙盒顶部}}","清理沙盒");
            ideas_log("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
        }
    }
    return;
}

//该函数用于当{{急需改进}}{{不完整}}同时出现在一个条目内时去掉{{不完整}}
//https://zh.moegirl.org/index.php?title=%E7%A8%8B%E5%BA%8F%E5%91%98%E6%8B%9B%E5%8B%9F%E4%B8%AD&oldid=135505
function ext_zhmg_clean_a(){
    $result=ideas_get_recent_changes("20");
    $i=0;
    $isum=count($result->query->recentchanges->rc);
    do{
        $wikied=ideas_view($result->query->recentchanges->rc[$i]->attributes()->title);
        if(ideas_str_find($wikied,"{{急需改进}}")==true && ideas_str_find($wikied,"{{不完整}}")==true){
            $wikied=ideas_str_replace("{{不完整}}","",$wikied);
            ideas_edit($result->query->recentchanges->rc[$i]->attributes()->title,$wikied,"{{急需改进}}{{不完整}}同时出现在一个条目内时去掉{{不完整}}");
        }
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

//该函数用于将用户页中的{{人物信息}}替换为{{用户信息}}
//https://zh.moegirl.org/index.php?title=User_talk:Baskice&oldid=106897
function ext_zhmg_clean_b(){
    $result=ideas_get_recent_changes("10","new|edit","2");
    $i=0;
    $isum=count($result->query->recentchanges->rc);
    do{
        $wikied=ideas_view($result->query->recentchanges->rc[$i]->attributes()->title);
        if(ideas_str_find($wikied,"{{人物信息")==true){
            $wikied=ideas_str_replace("{{人物信息","{{用户信息",$wikied);
            ideas_edit($result->query->recentchanges->rc[$i]->attributes()->title,$wikied,"将用户页中的{{人物信息}}替换为{{用户信息}}");
        }
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

//该函数用于将条目中的{{用户信息}}替换为{{人物信息}}
//https://zh.moegirl.org/index.php?title=User_talk:Baskice&oldid=106897
function ext_zhmg_clean_c(){
    $result=ideas_get_recent_changes("20");
    $i=0;
    $isum=count($result->query->recentchanges->rc);
    do{
        $wikied=ideas_view($result->query->recentchanges->rc[$i]->attributes()->title);
        if(ideas_str_find($wikied,"{{用户信息")==true){
            $wikied=ideas_str_replace("{{用户信息","{{人物信息",$wikied);
            ideas_edit($result->query->recentchanges->rc[$i]->attributes()->title,$wikied,"将条目中的{{用户信息}}替换为{{人物信息}}");
        }
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

//该函数用于将条目名包含一个中文冒号：时自动将其换为英文冒号:并且不保留重定向
//https://zh.moegirl.org/index.php?title=User_talk:Baskice&oldid=106897
function ext_zhmg_clean_d(){
    $result=ideas_get_recent_changes("20");
    $i=0;
    $isum=count($result->query->recentchanges->rc);
    do{
        $title=$result->query->recentchanges->rc[$i]->attributes()->title;
        if(ideas_str_find($title,"：")==true){
            $titlenew=ideas_str_replace("：",":",$title);
            ideas_move_noredirect($title,$titlenew,$reason="条目名包含一个中文冒号：时自动将其换为英文冒号:不留重定向");
        }
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

//该函数用于条目名包含中文括号（）时,自动将其换为英文括号().如果有人保持维基习惯,写_(的,去掉_
//https://zh.moegirl.org/index.php?title=User_talk:Baskice&oldid=106897
function ext_zhmg_clean_e(){
    $result=ideas_get_recent_changes("20");
    $i=0;
    $isum=count($result->query->recentchanges->rc);
    do{
        $change=false;
        $title=$result->query->recentchanges->rc[$i]->attributes()->title;
        $titlenew=$title;
        if(ideas_str_find($titlenew,"（")==true){
            $titlenew=ideas_str_replace("（","(",$titlenew);
            $change=true;
        }
        if(ideas_str_find($titlenew,"）")==true){
            $titlenew=ideas_str_replace("）",")",$titlenew);
            $change=true;
        }
        if(ideas_str_find($titlenew,"_(")==true){
            $titlenew=ideas_str_replace("_(","(",$titlenew);
            $change=true;
        }
        if($change==true){
            ideas_move_noredirect($title,$titlenew,$reason="修改条目名,并移动,不留重定向");
        }
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

?>
