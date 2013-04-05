<?php
//encode:UTF-8

//该函数用于将小于50kB,且无删除或速删模版的条目进行标记:{{Substub}},如果条目内容为空,则直接G1
function zhwp_check_50() {
    $arraydata=ideaslist("apmaxsize=50");
    $i=0;
    $isum=count ($arraydata->query->allpages->p);
    if ($isum!=0){
        do{
            if (ideasstrfind($arraydata->query->allpages->p[$i]->attributes()->title,"temp")==false && ideasstrfind($arraydata->query->allpages->p[$i]->attributes()->title,"tmp")==false && ideasstrfind($arraydata->query->allpages->p[$i]->attributes()->title,"测试")==false ){
                if (ideasview($arraydata->query->allpages->p[$i]->attributes()->title)==""){
                    //如果条目内容为空,暂停悬挂
                    //$topwikied=ideasviewtop($arraydata->query->allpages->p[$i]->attributes()->title);
                    //$topwikied="{{D|A1}}\r\n".$topwikied;
                    //ideasedittop($arraydata->query->allpages->p[$i]->attributes()->title,$topwikied,"添加{{[[Template:D|A1]]}}标记到条目");
                    //ideaslog("Add {{D|A1}} to : [[".$arraydata->query->allpages->p[$i]->attributes()->title."]]");
                }else{
                        if (ideasstrfind(ideasview($arraydata->query->allpages->p[$i]->attributes()->title),"{{d")==false && ideasstrfind(ideasview($arraydata->query->allpages->p[$i]->attributes()->title),"{{substub") && ideasstrfind(ideasview($arraydata->query->allpages->p[$i]->attributes()->title),"{{copyvio") ==false){
                        $topwikied=ideasviewtop($arraydata->query->allpages->p[$i]->attributes()->title);
                        $topwikied="{{subst:Substub/auto}}\r\n".$topwikied;
                        ideasedittop($arraydata->query->allpages->p[$i]->attributes()->title,$topwikied,"添加[[Template:Substub|小小作品]]标记到条目");
                        ideaslog("Add {{Substub}} to : [[".$arraydata->query->allpages->p[$i]->attributes()->title."]]");
                    }
                }
        }else{
    
        }
        $i=$i+1;
        }while($i <= ($isum-1));
    }else{
    //没有小于50字节条目则跳过
    }
    return;
}

//该函数用于从最近更改中检测新创建的广告条目,并将其标记
function zhwp_check_ad(){
    $arraydata=ideasgetrecentchanges();
    $i=0;
    $isum=count ($arraydata->query->recentchanges->rc);
    do{
        $actionresult=zhwp_check_ad_core($arraydata->query->recentchanges->rc[$i]->attributes()->title);
        //针对创建低质条目的用户进行审查
        if (is_numeric($actionresult)==true && $actionresult< -3){
            $goaluser=ideas_get_creator($arraydata->query->recentchanges->rc[$i]->attributes()->title);
            $goalusercontribs=ideas_get_user_contribs($goaluser,"50");
            $isumb=count ($goalusercontribs->query->usercontribs->item);
            $ib=0;
            $blacklist=0; //用户黑名单记录初始化
            do{
                if (zhwp_check_ad_core($goalusercontribs->query->usercontribs->item[$ib]->attributes()->title)<0){
                    $blacklist=$blacklist+1;
                }
                $ib=$ib+1;
            }while($ib <= ($isumb-1));
            if ($blacklist>2){
                //if (ideasstrfind(ideasview("user_talk:DGideas"),$goaluser)==false){
                    ideasreport("请注意".$goaluser."的最近50次编辑,有超过3次被机器人判定为广告");
                //}
            }
            //ideaslog ($goaluser.",blacklist=".$blacklist);
        }
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

//广告检查函数核心(页面名称)
function zhwp_check_ad_core($title){
//该函数的细节由于考虑到安全性并未公开,如需详细源代码请联系DGideas
}

//该函数用于清空中文维基百科沙盒
//目前只支持大小为267字节的沙箱
function zhwp_clean_sandbox($sandboxname="Wikipedia:沙盒"){
    if (ideas_get_size($sandboxname)!="267"){
        $author=ideasgetauthor($sandboxname);
        $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
        ideasedit($sandboxname,"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理沙盒");
        ideaslog("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
    }else{
            if (ideasstrfind(ideasview($sandboxname),"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}")==true && ideasstrfind(ideasview($sandboxname),"{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}")==true){
        }else{
            $author=ideasgetauthor($sandboxname);
            $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
            ideasedit($sandboxname,"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理沙盒");
            ideaslog("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
        }
    }
    return;
}

//该函数用于清空中文维基百科图片沙盒
//目前只支持大小为279字节的沙箱
function zhwp_clean_pic_sandbox(){
    $sandboxname="File:沙盒.png";
    if (ideas_get_size($sandboxname)!="279"){
        $author=ideasgetauthor($sandboxname);
        $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
        ideasedit($sandboxname,"{{PD-self}}\r\n{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理图片沙盒描述");
        ideaslog("清理了图片沙盒:[[".$sandboxname."]],最近编者为:".$user);
    }else{
            if (ideasstrfind(ideasview($sandboxname),"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}")==true && ideasstrfind(ideasview($sandboxname),"{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}")==true && ideasstrfind(ideasview($sandboxname),"{{PD-self}}")==true){
        }else{
            $author=ideasgetauthor($sandboxname);
            $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
            ideasedit($sandboxname,"{{PD-self}}\r\n{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理图片沙盒描述");
            ideaslog("清理了图片沙盒:[[".$sandboxname."]],最近编者为:".$user);
        }
    }
    return;
}

?>
