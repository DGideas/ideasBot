<?php
//encode:UTF-8

//该函数用于将小于50kB,且无删除或速删模版的条目进行标记:{{Substub}},如果条目内容为空,则直接G1
function ext_zhwp_check_50() {
    $arraydata=ideas_list("apmaxsize=50");
    $i=0;
    $isum=count ($arraydata->query->allpages->p);
    if ($isum!=0){
        do{
            if (ideas_str_find($arraydata->query->allpages->p[$i]->attributes()->title,"temp")==false && ideas_str_find($arraydata->query->allpages->p[$i]->attributes()->title,"tmp")==false && ideas_str_find($arraydata->query->allpages->p[$i]->attributes()->title,"测试")==false ){
                if (ideas_view($arraydata->query->allpages->p[$i]->attributes()->title)==""){
                    //如果条目内容为空,暂停悬挂
                    //$topwikied=ideas_view_top($arraydata->query->allpages->p[$i]->attributes()->title);
                    //$topwikied="{{D|A1}}\r\n".$topwikied;
                    //ideasedittop($arraydata->query->allpages->p[$i]->attributes()->title,$topwikied,"添加{{[[Template:D|A1]]}}标记到条目");
                    //ideaslog("Add {{D|A1}} to : [[".$arraydata->query->allpages->p[$i]->attributes()->title."]]");
                }else{
                        if (ideas_str_find(ideas_view($arraydata->query->allpages->p[$i]->attributes()->title),"{{d")==false && ideas_str_find(ideas_view($arraydata->query->allpages->p[$i]->attributes()->title),"{{substub") && ideas_str_find(ideas_view($arraydata->query->allpages->p[$i]->attributes()->title),"{{copyvio") ==false){
                        $topwikied=ideas_view_top($arraydata->query->allpages->p[$i]->attributes()->title);
                        $topwikied="{{subst:Substub/auto}}\r\n".$topwikied;
                        ideas_edit_top($arraydata->query->allpages->p[$i]->attributes()->title,$topwikied,"添加[[Template:Substub|小小作品]]标记到条目");
                        ideas_log("Add {{Substub}} to : [[".$arraydata->query->allpages->p[$i]->attributes()->title."]]");
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
function ext_zhwp_check_ad(){
    $arraydata=ideas_get_recent_changes();
    $i=0;
    $isum=count ($arraydata->query->recentchanges->rc);
    do{
        $actionresult=ext_check_ad($arraydata->query->recentchanges->rc[$i]->attributes()->title);
        //针对创建低质条目的用户进行审查
        if (is_numeric($actionresult)==true && $actionresult< -3){
            $goaluser=ideas_get_creator($arraydata->query->recentchanges->rc[$i]->attributes()->title);
            $goalusercontribs=ideas_get_user_contribs($goaluser,"50");
            $isumb=count ($goalusercontribs->query->usercontribs->item);
            $ib=0;
            $blacklist=0; //用户黑名单记录初始化
            do{
                if (ext_check_ad($goalusercontribs->query->usercontribs->item[$ib]->attributes()->title)<0){
                    $blacklist=$blacklist+1;
                }
                $ib=$ib+1;
            }while($ib <= ($isumb-1));
            if ($blacklist>2){
                //if (ideas_str_find(ideas_view("user_talk:DGideas"),$goaluser)==false){
                    //ideas_report("请注意".$goaluser."的最近50次编辑,有超过3次被机器人判定为广告");
                //}
            }
            //ideas_log ($goaluser.",blacklist=".$blacklist);
        }
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

//该函数用于清空中文维基百科沙盒
//目前只支持大小为267字节的沙箱
function ext_zhwp_clean_sandbox($sandboxname="Wikipedia:沙盒"){
    $zf_cleansandbox_min_time="300"; //最短清理沙箱时间为300秒(5分钟)
    $timestamp=ideas_get_last_edit_time($sandboxname);
    $unixtime=ideas_deal_timestamp($timestamp);
    $now=time();
    $second=$now-$unixtime;
    if ($second>=$zf_cleansandbox_min_time){
        if (ideas_get_size($sandboxname)!="267"){
            $author=ideas_get_author($sandboxname);
            $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
            ideas_edit($sandboxname,"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理沙盒");
            ideas_log("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
        }else{
                if (ideas_str_find(ideas_view($sandboxname),"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}")==true && ideas_str_find(ideas_view($sandboxname),"{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}")==true){
            }else{
                $author=ideas_get_author($sandboxname);
                $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
                ideas_edit($sandboxname,"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理沙盒");
                ideas_log("清理了沙盒:[[".$sandboxname."]],最近编者为:".$user);
            }
        }
    }
    return;
}

//该函数用于清空中文维基百科图片沙盒
//目前只支持大小为279字节的沙箱
function ext_zhwp_clean_pic_sandbox(){
    $sandboxname="File:沙盒.png";
    $zf_cleansandbox_min_time="300"; //最短清理沙箱时间为300秒(5分钟)
    $timestamp=ideas_get_last_edit_time("File:沙盒.png");
    $unixtime=ideas_deal_timestamp($timestamp);
    $now=time();
    $second=$now-$unixtime;
    if ($second>=$zf_cleansandbox_min_time){
        if (ideas_get_size($sandboxname)!="279"){
            $author=ideas_get_author($sandboxname);
            $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
            ideas_edit($sandboxname,"{{PD-self}}\r\n{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理图片沙盒描述");
            ideas_log("清理了图片沙盒:[[".$sandboxname."]],最近编者为:".$user);
        }else{
                if (ideas_str_find(ideas_view($sandboxname),"{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}")==true && ideas_str_find(ideas_view($sandboxname),"{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}")==true && ideas_str_find(ideas_view($sandboxname),"{{PD-self}}")==true){
            }else{
                $author=ideas_get_author($sandboxname);
                $user=$author->query->pages->page->revisions->rev[0]->attributes()->user;
                ideas_edit($sandboxname,"{{PD-self}}\r\n{{請注意：請在這行文字底下進行您的測試，請不要刪除或變更這行文字以及這行文字以上的部份。}}\r\n{{请注意：请在这行文字底下进行您的测试，请不要删除或变更这行文字以及这行文字以上的部分。}}","清理图片沙盒描述");
                ideas_log("清理了图片沙盒:[[".$sandboxname."]],最近编者为:".$user);
            }
        }
    }
    return;
}
//WARNING:以下函数为测试函数,运行可能不稳定!!!
//WARNING:以下函数为测试函数,运行可能不稳定!!!
//WARNING:以下函数为测试函数,运行可能不稳定!!!
//WARNING:以下函数为测试函数,运行可能不稳定!!!
//WARNING:以下函数为测试函数,运行可能不稳定!!!

//该函数用于基于用户贡献维基化条目
function ext_zhwp_wikied_from_user($user){
    $usercontribs=ideas_get_user_contribs($user,"50");
    $isum=count($usercontribs->query->usercontribs->item);
    $i=0;
    do{
        zhwp_wikied_core($usercontribs->query->usercontribs->item[$i]->attributes()->title);
        $i=$i+1;
    }while($i <= ($isum-1));
    return;
}

//该函数是页面维基化的核心函数
function ext_zhwp_wikied_core($title){
    $wikied=ideas_view($title);
    $wikied2=$wikied;
    if (ideas_str_find($wikied,$title)==true){
        //如果条目中出现同标题的文字
        if (ideas_str_find($wikied,"'''".$title."'''")==false){
            //如果没有加粗
            $wikied=ideasstrreplace($title,"'''".$title."'''",$wikied);
            ideas_log("加粗了同标题的文字:".$title);
        }
    }
    if  (ideas_str_find($wikied,"<ref>")==true){
        //如果有注释标签
        if (ideas_str_find($wikied,"{{reflist}}")==false){
            //又没有{{reflist}}
            $wikied=$wikied."\r\n{{reflist}}";
            ideas_log("添加reflist到以下条目:".$title);
        }
    }
    if ($wikied2!=$wikied){
        //如果有改动
        ideas_edit("User:ideasBot/sandbox/".$title,$wikied,"维基化页面");
    }
    return;
}

?>
