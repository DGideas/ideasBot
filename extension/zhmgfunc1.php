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
?>
