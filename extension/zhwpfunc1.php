<?php
//encode:UTF-8

//该函数用于将小于50kB,且无删除或速删模版的条目进行标记:{{Substub}},如果条目内容为空,则直接G1
function zhwp_check_50() {
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
function zhwp_check_ad(){
    $arraydata=ideas_get_recent_changes();
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

//广告检查函数核心(页面名称)
//另请参见:https://github.com/DGideas/AntiAD
function zhwp_check_ad_core($title){
    $action=0; //初始化:条目评分为0
    //先获得工作条目的完整源代码
    $articlewikied=ideas_view($title);
    echo $articlewikied;
    echo $title." : ";
    echop();
    //排除页面标题
    if (ideas_str_find($title,"列表")==true){
        $action="title:列表";
    }elseif(ideas_str_find($title,"tmp")==true){
        $action="title:tmp";
    }elseif(ideas_str_find($title,"temp")==true){
        $action="title:temp";
    }elseif(ideas_str_find($title,"测试")==true){
        $action="title:测试";
    }elseif(ideas_str_find($title,"消歧义")==true){
        $action="title:消歧义";
    }
    //排除关键字
    if (ideas_str_find($articlewikied,"{{disambig}}")==true){
        $action="keyword:消歧义模板"; 
    }elseif(ideas_str_find($articlewikied,"编程")==true){
        $action="keyword:编程"; 
    }elseif(ideas_str_find($articlewikied,"接口")==true){
        $action="keyword:接口"; 
    }elseif(ideas_str_find($articlewikied,"节目")==true){
        $action="keyword:节目"; 
    }elseif(ideas_str_find($articlewikied,"空军")==true || ideas_str_find($articlewikied,"空軍")==true){
        $action="keyword:空军"; 
    }elseif(ideas_str_find($articlewikied,"陆军")==true){
        $action="keyword:陆军"; 
    }elseif(ideas_str_find($articlewikied,"海军")==true){
        $action="keyword:海军"; 
    }elseif(ideas_str_find($articlewikied,"软件")==true){
        $action="keyword:软件"; 
    }elseif(ideas_str_find($articlewikied,"二名法")==true){
        $action="keyword:二名法"; 
    }elseif(ideas_str_find($articlewikied,"轨")==true){
        $action="keyword:轨"; 
    }elseif(ideas_str_find($articlewikied,"法学")==true){
        $action="keyword:法学"; 
    }elseif(ideas_str_find($articlewikied,"物理")==true){
        $action="keyword:物理";
    }elseif(ideas_str_find($articlewikied,"山脉")==true){
        $action="keyword:山脉";
    }elseif(ideas_str_find($articlewikied,"数学")==true){
        $action="keyword:数学"; 
    }elseif(ideas_str_find($articlewikied,"舞蹈")==true){
        $action="keyword:舞蹈"; 
    }elseif(ideas_str_find($articlewikied,"夏朝")==true){
        $action="keyword:夏朝"; 
    }elseif(ideas_str_find($articlewikied,"商朝")==true || ideas_str_find($articlewikied,"商代")==true){
        $action="keyword:商朝,商代"; 
    }elseif(ideas_str_find($articlewikied,"周朝")==true){
        $action="keyword:周朝"; 
    }elseif(ideas_str_find($articlewikied,"晋朝")==true || ideas_str_find($articlewikied,"晋代")==true){
        $action="keyword:晋朝,晋代"; 
    }elseif(ideas_str_find($articlewikied,"南北朝")==true){
        $action="keyword:南北朝"; 
    }elseif(ideas_str_find($articlewikied,"秦朝")==true || ideas_str_find($articlewikied,"秦代")==true){
        $action="keyword:秦朝,秦代"; 
    }elseif(ideas_str_find($articlewikied,"汉朝")==true || ideas_str_find($articlewikied,"汉代")==true){
        $action="keyword:汉朝,汉代"; 
    }elseif(ideas_str_find($articlewikied,"三国")==true){
        $action="keyword:三国"; 
    }elseif(ideas_str_find($articlewikied,"唐朝")==true || ideas_str_find($articlewikied,"唐代")==true){
        $action="keyword:唐朝,唐代";  
    }elseif(ideas_str_find($articlewikied,"宋朝")==true || ideas_str_find($articlewikied,"宋代")==true){
        $action="keyword:宋朝,宋代"; 
    }elseif(ideas_str_find($articlewikied,"元朝")==true || ideas_str_find($articlewikied,"元代")==true){
        $action="keyword:元朝,元代"; 
    }elseif(ideas_str_find($articlewikied,"明朝")==true || ideas_str_find($articlewikied,"明代")==true){
        $action="keyword:明朝,明代"; 
    }elseif(ideas_str_find($articlewikied,"清朝")==true || ideas_str_find($articlewikied,"清代")==true){
        $action="keyword:清朝,清代"; 
    }elseif(ideas_str_find($articlewikied,"动漫")==true){
        $action="keyword:动漫"; 
    }elseif(ideas_str_find($articlewikied,"列表")==true){
        $action="keyword:列表"; 
    }elseif(ideas_str_find($articlewikied,"出版社")==true){
        $action="keyword:出版社"; 
    }elseif(ideas_str_find($articlewikied,"医疗")==true){
        $action="keyword:医疗"; 
    }elseif(ideas_str_find($articlewikied,"辖区")==true){
        $action="keyword:辖区"; 
    }elseif(ideas_str_find($articlewikied,"市镇")==true){
        $action="keyword:市镇";
    }elseif(ideas_str_find($articlewikied,"系统")==true){
        $action="keyword:系统"; 
    }elseif(ideas_str_find($articlewikied,"核")==true){
        $action="keyword:核"; 
    }elseif(ideas_str_find($articlewikied,"特征")==true){
        $action="keyword:特征"; 
    }elseif(ideas_str_find($articlewikied,"学名")==true){
        $action="keyword:学名"; 
    }elseif(ideas_str_find($articlewikied,"朝鲜")==true){
        $action="keyword:朝鲜"; 
    }elseif(ideas_str_find($articlewikied,"分布")==true){
        $action="keyword:分布"; 
    }elseif(ideas_str_find($articlewikied,"法律")==true){
        $action="keyword:法律"; 
    }elseif(ideas_str_find($articlewikied,"校长")==true){
        $action="keyword:校长"; 
    }elseif(ideas_str_find($articlewikied,"市长")==true){
        $action="keyword:市长"; 
    }elseif(ideas_str_find($articlewikied,"气候")==true){
        $action="keyword:气候";
    }elseif(ideas_str_find($articlewikied,"气象")==true){
        $action="keyword:气象"; 
    }elseif(ideas_str_find($articlewikied,"向量")==true){
        $action="keyword:向量"; 
    }elseif(ideas_str_find($articlewikied,"歌手")==true){
        $action="keyword:歌手"; 
    }elseif(ideas_str_find($articlewikied,"泛音")==true){
        $action="keyword:泛音"; 
    }elseif(ideas_str_find($articlewikied,"社会")==true){
        $action="keyword:社会"; 
    }elseif(ideas_str_find($articlewikied,"冠军杯")==true){
        $action="keyword:冠军杯"; 
    }elseif(ideas_str_find($articlewikied,"理事会")==true){
        $action="keyword:理事会"; 
    }elseif(ideas_str_find($articlewikied,"表示")==true){
        $action="keyword:表示"; 
    }elseif(ideas_str_find($articlewikied,"大学")==true){
        $action="keyword:大学"; 
    }elseif(ideas_str_find($articlewikied,"基督教")==true){
        $action="keyword:基督教"; 
    }elseif(ideas_str_find($articlewikied,"道教")==true){
        $action="keyword:道教"; 
    }elseif(ideas_str_find($articlewikied,"佛教")==true){
        $action="keyword:佛教"; 
    }elseif(ideas_str_find($articlewikied,"中共")==true){
        $action="keyword:中共"; 
    }elseif(ideas_str_find($articlewikied,"六四")==true){
        $action="keyword:六四"; 
    }elseif(ideas_str_find($articlewikied,"镇压")==true){
        $action="keyword:镇压"; 
    }elseif(ideas_str_find($articlewikied,"单曲")==true){
        $action="keyword:单曲"; 
    }elseif(ideas_str_find($articlewikied,"歌曲")==true){
        $action="keyword:歌曲"; 
    }elseif(ideas_str_find($articlewikied,"乐队")==true){
        $action="keyword:乐队"; 
    }elseif(ideas_str_find($articlewikied,"爵士")==true){
        $action="keyword:爵士"; 
    }elseif(ideas_str_find($articlewikied,"媒体")==true){
        $action="keyword:媒体"; 
    }elseif(ideas_str_find($articlewikied,"电力")==true){
        $action="keyword:电力"; 
    }elseif(ideas_str_find($articlewikied,"列车")==true){
        $action="keyword:列车"; 
    }elseif(ideas_str_find($articlewikied,"车站")==true){
        $action="keyword:车站"; 
    }elseif(ideas_str_find($articlewikied,"动画")==true){
        $action="keyword:动画";
    }elseif(ideas_str_find($articlewikied,"漫画")==true){
        $action="keyword:漫画";
    }elseif(ideas_str_find($articlewikied,"逻辑")==true){
        $action="keyword:逻辑";
    }elseif(ideas_str_find($articlewikied,"文件")==true){
        $action="keyword:文件"; 
    }elseif(ideas_str_find($articlewikied,"人生")==true){
        $action="keyword:人生"; 
    }elseif(ideas_str_find($articlewikied,"生于")==true){
        $action="keyword:生于"; 
    }elseif(ideas_str_find($articlewikied,"毕业于")==true){
        $action="keyword:毕业于"; 
    }elseif(ideas_str_find($articlewikied,"燃烧")==true){
        $action="keyword:燃烧"; 
    }elseif(ideas_str_find($articlewikied,"基层")==true){
        $action="keyword:基层"; 
    }elseif(ideas_str_find($articlewikied,"通称")==true){
        $action="keyword:通称"; 
    }elseif(ideas_str_find($articlewikied,"演员")==true){
        $action="keyword:演员"; 
    }elseif(ideas_str_find($articlewikied,"战术")==true){
        $action="keyword:战术"; 
    }elseif(ideas_str_find($articlewikied,"战略")==true){
        $action="keyword:战略"; 
    }elseif(ideas_str_find($articlewikied,"委员")==true){
        $action="keyword:委员"; 
    }elseif(ideas_str_find($articlewikied,"事件")==true){
        $action="keyword:事件"; 
    }elseif(ideas_str_find($articlewikied,"地铁")==true){
        $action="keyword:地铁"; 
    }elseif(ideas_str_find($articlewikied,"机关")==true){
        $action="keyword:机关"; 
    }elseif(ideas_str_find($articlewikied,"法院")==true){
        $action="keyword:法院"; 
    }elseif(ideas_str_find($articlewikied,"临床")==true){
        $action="keyword:临床"; 
    }elseif(ideas_str_find($articlewikied,"细胞")==true){
        $action="keyword:细胞"; 
    }elseif(ideas_str_find($articlewikied,"出版")==true){
        $action="keyword:出版"; 
    }
    if (ideas_str_find($articlewikied,"上市公司")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"股票代码")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"有限公司")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"有限责任公司")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"互联网")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"集团")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"控股")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"差评")==true && is_numeric($action)==true){
        $action=$action+1;
    }
    if(ideas_str_find($articlewikied,"另请参见")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"[[")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"'''")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"旗下")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"发明")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"专利")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"==")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"失败")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"贸易")==true && is_numeric($action)==true){
        $action=$action+2;
    }
    if(ideas_str_find($articlewikied,"19世纪")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"参考文献")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"18世纪")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"17世纪")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"16世纪")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"慈善")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"公益")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"影响")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"捐助")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"跨国")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"国有")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"纠纷")==true && is_numeric($action)==true){
        $action=$action+3;
    }
    if(ideas_str_find($articlewikied,"注释")==true && is_numeric($action)==true){
        $action=$action+4;
    }
    if(ideas_str_find($articlewikied,"参考")==true && is_numeric($action)==true){
        $action=$action+4;
    }
    if(ideas_str_find($articlewikied,"丑闻")==true && is_numeric($action)==true){
        $action=$action+5;
    }
    if(ideas_str_find($articlewikied,"负面")==true && is_numeric($action)==true){
        $action=$action+5;
    }
    if(ideas_str_find($articlewikied,"质疑")==true && is_numeric($action)==true){
        $action=$action+5;
    }
    if(ideas_str_find($articlewikied,"英雄")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"网址")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"工作室")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"营销")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"好评")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"@")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"价值")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"团队")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"►")==true && is_numeric($action)==true){
        $action=$action-1;
    }
    if(ideas_str_find($articlewikied,"质量奖")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"获奖")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"荣誉")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"特约")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"东南亚")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"编辑")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"他们")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"出席")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"东方")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"精华")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"西方")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"西式")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"欧式")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"日式")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"料理")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"广受")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"病人")==true && is_numeric($action)==true){
        $action=$action-2;
    }
    if(ideas_str_find($articlewikied,"治病")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"团购")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"畅销")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"经典之作")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"绝对")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"首选")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"主营")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"几乎所有")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"首款")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"深受")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"品牌简介")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"品牌定位")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"品牌诠释")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"信赖")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"信得过")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"优惠")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"题词")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"贺电")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"贺礼")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"剪彩")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"赞助")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"特级")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"极品")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"高端")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"高贵")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"典雅")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"奢华")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"兼备")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"乐园")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"诚邀")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"顶峰")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"官网")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"享誉")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"最好")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"最新")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"最优秀")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"最给力")==true && is_numeric($action)==true){
        $action=$action-3;
    }
    if(ideas_str_find($articlewikied,"电话")==true && is_numeric($action)==true){
        $action=$action-4;
    }
    if(ideas_str_find($articlewikied,"我国")==true && is_numeric($action)==true){
        $action=$action-4;
    }
    if(ideas_str_find($articlewikied,"我厂")==true && is_numeric($action)==true){
        $action=$action-4;
    }
    if(ideas_str_find($articlewikied,"我司")==true && is_numeric($action)==true){
        $action=$action-4;
    }
    if(ideas_str_find($articlewikied,"加盟")==true && is_numeric($action)==true){
        $action=$action-4;
    }
    if(ideas_str_find($articlewikied,"我省")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"我市")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"省长")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"市长")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"委员长")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"推荐")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"数百年来")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"座驾")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"豪华")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"商务")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"成功")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"网店")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"地址")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideas_str_find($articlewikied,"欢迎")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"订购")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"从速")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"脱销")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"代开")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"发票")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"办证")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"单位")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"朋友")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"预约")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"只需")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"特效")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"限量")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"稀有")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"超低价格")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideas_str_find($articlewikied,"仅有")==true && is_numeric($action)==true){
            $action=$action-5;
        }

        if (is_numeric($action)==true && $action< 0){
            if (is_numeric($action)==true && $action< -5){
                //悬挂模版G10
                if (ideas_str_find(ideas_view($title),"{{d")==false && ideas_str_find(ideas_view($title),"{{advert") ==false){
                    $topwikied=ideas_view_top($title);
                    $topwikied="{{D|G11}}\r\n".$topwikied;
                    ideas_edit_top($title,$topwikied,"使用[[Template:D|G11模版]]标记疑似广告的编辑(条目评分:".$action.")");
                    ideas_log("Add {{D|G11}} to : [[".$title."]],条目评分: ".$action);
                }
            }else{
                //悬挂模版advert
                if (ideas_str_find(ideas_view($title),"{{d")==false && ideas_str_find(ideas_view($title),"{{advert") ==false){
                    $topwikied=ideas_view_top($title);
                    $topwikied="{{subst:Advert/auto}}\r\n".$topwikied;
                    ideas_edit_top($title,$topwikied,"使用[[Template:advert]]标记疑似广告的编辑(条目评分:".$action.")");
                    ideas_log("Add {{advert}} to : [[".$title."]],条目评分: ".$action);
                }
            }
        }
    //ideaslog("检测到条目[[".$title."]] ,评分:".$action); //通常情况下请注释本行,用于调试算法
    return $action;

}

//该函数用于清空中文维基百科沙盒
//目前只支持大小为267字节的沙箱
function zhwp_clean_sandbox($sandboxname="Wikipedia:沙盒"){
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
function zhwp_clean_pic_sandbox(){
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
function zhwp_wikied_from_user($user){
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
function zhwp_wikied_core($title){
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
