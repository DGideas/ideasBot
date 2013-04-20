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
?>
