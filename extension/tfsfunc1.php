<?php
//encode:UTF-8

//该函数用于清空TFS沙盒
//目前只支持大小为46字节的沙箱
function tfs_clean_sandbox($sandboxname="Sandbox"){
    if (ideas_get_size($sandboxname)!="46"){
        $author=ideasgetauthor($sandboxname);
        $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
        ideasedit($sandboxname,"{{请在本段文字下方尝试您的编辑}}","清理沙盒");
        ideaslog("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
    }else{
            if (ideasstrfind(ideas_view($sandboxname),"{{请在本段文字下方尝试您的编辑}}")==true){
        }else{
            $author=ideasgetauthor($sandboxname);
            $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
            ideasedit($sandboxname,"{{请在本段文字下方尝试您的编辑}}","清理沙盒");
            ideaslog("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
        }
    }
    return;
}
?>
