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
//另请参见:https://github.com/DGideas/AntiAD
function zhwp_check_ad_core($title){
        $action=0; //初始化:条目评分为0
        //先获得工作条目的完整源代码
        $articlewikied=ideasview($title);
        echo $articlewikied;
        echo $title." : ";
        echop();
        //排除页面标题
        if (ideasstrfind($title,"列表")==true){
            $action="title:列表";
        }elseif(ideasstrfind($title,"tmp")==true){
            $action="title:tmp";
        }elseif(ideasstrfind($title,"temp")==true){
            $action="title:temp";
        }elseif(ideasstrfind($title,"测试")==true){
            $action="title:测试";
        }elseif(ideasstrfind($title,"消歧义")==true){
            $action="title:消歧义";
        }
        //排除关键字
        if (ideasstrfind($articlewikied,"{{disambig}}")==true){
            $action="keyword:消歧义模板"; 
        }elseif(ideasstrfind($articlewikied,"编程")==true){
            $action="keyword:编程"; 
        }elseif(ideasstrfind($articlewikied,"接口")==true){
            $action="keyword:接口"; 
        }elseif(ideasstrfind($articlewikied,"节目")==true){
            $action="keyword:节目"; 
        }elseif(ideasstrfind($articlewikied,"空军")==true || ideasstrfind($articlewikied,"空軍")==true){
            $action="keyword:空军"; 
        }elseif(ideasstrfind($articlewikied,"陆军")==true){
            $action="keyword:陆军"; 
        }elseif(ideasstrfind($articlewikied,"海军")==true){
            $action="keyword:海军"; 
        }elseif(ideasstrfind($articlewikied,"软件")==true){
            $action="keyword:软件"; 
        }elseif(ideasstrfind($articlewikied,"二名法")==true){
            $action="keyword:二名法"; 
        }elseif(ideasstrfind($articlewikied,"轨")==true){
            $action="keyword:轨"; 
        }elseif(ideasstrfind($articlewikied,"法学")==true){
            $action="keyword:法学"; 
        }elseif(ideasstrfind($articlewikied,"物理")==true){
            $action="keyword:物理";
        }elseif(ideasstrfind($articlewikied,"山脉")==true){
            $action="keyword:山脉";
        }elseif(ideasstrfind($articlewikied,"数学")==true){
            $action="keyword:数学"; 
        }elseif(ideasstrfind($articlewikied,"舞蹈")==true){
            $action="keyword:舞蹈"; 
        }elseif(ideasstrfind($articlewikied,"夏朝")==true){
            $action="keyword:夏朝"; 
        }elseif(ideasstrfind($articlewikied,"商朝")==true || ideasstrfind($articlewikied,"商代")==true){
            $action="keyword:商朝,商代"; 
        }elseif(ideasstrfind($articlewikied,"周朝")==true){
            $action="keyword:周朝"; 
        }elseif(ideasstrfind($articlewikied,"晋朝")==true || ideasstrfind($articlewikied,"晋代")==true){
            $action="keyword:晋朝,晋代"; 
        }elseif(ideasstrfind($articlewikied,"南北朝")==true){
            $action="keyword:南北朝"; 
        }elseif(ideasstrfind($articlewikied,"秦朝")==true || ideasstrfind($articlewikied,"秦代")==true){
            $action="keyword:秦朝,秦代"; 
        }elseif(ideasstrfind($articlewikied,"汉朝")==true || ideasstrfind($articlewikied,"汉代")==true){
            $action="keyword:汉朝,汉代"; 
        }elseif(ideasstrfind($articlewikied,"三国")==true){
            $action="keyword:三国"; 
        }elseif(ideasstrfind($articlewikied,"唐朝")==true || ideasstrfind($articlewikied,"唐代")==true){
            $action="keyword:唐朝,唐代";  
        }elseif(ideasstrfind($articlewikied,"宋朝")==true || ideasstrfind($articlewikied,"宋代")==true){
            $action="keyword:宋朝,宋代"; 
        }elseif(ideasstrfind($articlewikied,"元朝")==true || ideasstrfind($articlewikied,"元代")==true){
            $action="keyword:元朝,元代"; 
        }elseif(ideasstrfind($articlewikied,"明朝")==true || ideasstrfind($articlewikied,"明代")==true){
            $action="keyword:明朝,明代"; 
        }elseif(ideasstrfind($articlewikied,"清朝")==true || ideasstrfind($articlewikied,"清代")==true){
            $action="keyword:清朝,清代"; 
        }elseif(ideasstrfind($articlewikied,"动漫")==true){
            $action="keyword:动漫"; 
        }elseif(ideasstrfind($articlewikied,"列表")==true){
            $action="keyword:列表"; 
        }elseif(ideasstrfind($articlewikied,"出版社")==true){
            $action="keyword:出版社"; 
        }elseif(ideasstrfind($articlewikied,"医疗")==true){
            $action="keyword:医疗"; 
        }elseif(ideasstrfind($articlewikied,"辖区")==true){
            $action="keyword:辖区"; 
        }elseif(ideasstrfind($articlewikied,"市镇")==true){
            $action="keyword:市镇";
        }elseif(ideasstrfind($articlewikied,"系统")==true){
            $action="keyword:系统"; 
        }elseif(ideasstrfind($articlewikied,"核")==true){
            $action="keyword:核"; 
        }elseif(ideasstrfind($articlewikied,"特征")==true){
            $action="keyword:特征"; 
        }elseif(ideasstrfind($articlewikied,"学名")==true){
            $action="keyword:学名"; 
        }elseif(ideasstrfind($articlewikied,"朝鲜")==true){
            $action="keyword:朝鲜"; 
        }elseif(ideasstrfind($articlewikied,"分布")==true){
            $action="keyword:分布"; 
        }elseif(ideasstrfind($articlewikied,"法律")==true){
            $action="keyword:法律"; 
        }elseif(ideasstrfind($articlewikied,"校长")==true){
            $action="keyword:校长"; 
        }elseif(ideasstrfind($articlewikied,"市长")==true){
            $action="keyword:市长"; 
        }elseif(ideasstrfind($articlewikied,"气候")==true){
            $action="keyword:气候";
        }elseif(ideasstrfind($articlewikied,"气象")==true){
            $action="keyword:气象"; 
        }elseif(ideasstrfind($articlewikied,"向量")==true){
            $action="keyword:向量"; 
        }elseif(ideasstrfind($articlewikied,"歌手")==true){
            $action="keyword:歌手"; 
        }elseif(ideasstrfind($articlewikied,"泛音")==true){
            $action="keyword:泛音"; 
        }elseif(ideasstrfind($articlewikied,"社会")==true){
            $action="keyword:社会"; 
        }elseif(ideasstrfind($articlewikied,"冠军杯")==true){
            $action="keyword:冠军杯"; 
        }elseif(ideasstrfind($articlewikied,"理事会")==true){
            $action="keyword:理事会"; 
        }elseif(ideasstrfind($articlewikied,"表示")==true){
            $action="keyword:表示"; 
        }elseif(ideasstrfind($articlewikied,"大学")==true){
            $action="keyword:大学"; 
        }elseif(ideasstrfind($articlewikied,"基督教")==true){
            $action="keyword:基督教"; 
        }elseif(ideasstrfind($articlewikied,"道教")==true){
            $action="keyword:道教"; 
        }elseif(ideasstrfind($articlewikied,"佛教")==true){
            $action="keyword:佛教"; 
        }elseif(ideasstrfind($articlewikied,"中共")==true){
            $action="keyword:中共"; 
        }elseif(ideasstrfind($articlewikied,"六四")==true){
            $action="keyword:六四"; 
        }elseif(ideasstrfind($articlewikied,"镇压")==true){
            $action="keyword:镇压"; 
        }elseif(ideasstrfind($articlewikied,"单曲")==true){
            $action="keyword:单曲"; 
        }elseif(ideasstrfind($articlewikied,"歌曲")==true){
            $action="keyword:歌曲"; 
        }elseif(ideasstrfind($articlewikied,"乐队")==true){
            $action="keyword:乐队"; 
        }elseif(ideasstrfind($articlewikied,"爵士")==true){
            $action="keyword:爵士"; 
        }elseif(ideasstrfind($articlewikied,"媒体")==true){
            $action="keyword:媒体"; 
        }elseif(ideasstrfind($articlewikied,"电力")==true){
            $action="keyword:电力"; 
        }elseif(ideasstrfind($articlewikied,"列车")==true){
            $action="keyword:列车"; 
        }elseif(ideasstrfind($articlewikied,"车站")==true){
            $action="keyword:车站"; 
        }elseif(ideasstrfind($articlewikied,"动画")==true){
            $action="keyword:动画";
        }elseif(ideasstrfind($articlewikied,"漫画")==true){
            $action="keyword:漫画";
        }elseif(ideasstrfind($articlewikied,"逻辑")==true){
            $action="keyword:逻辑";
        }elseif(ideasstrfind($articlewikied,"文件")==true){
            $action="keyword:文件"; 
        }elseif(ideasstrfind($articlewikied,"人生")==true){
            $action="keyword:人生"; 
        }elseif(ideasstrfind($articlewikied,"生于")==true){
            $action="keyword:生于"; 
        }elseif(ideasstrfind($articlewikied,"毕业于")==true){
            $action="keyword:毕业于"; 
        }elseif(ideasstrfind($articlewikied,"燃烧")==true){
            $action="keyword:燃烧"; 
        }elseif(ideasstrfind($articlewikied,"基层")==true){
            $action="keyword:基层"; 
        }elseif(ideasstrfind($articlewikied,"通称")==true){
            $action="keyword:通称"; 
        }elseif(ideasstrfind($articlewikied,"演员")==true){
            $action="keyword:演员"; 
        }elseif(ideasstrfind($articlewikied,"战术")==true){
            $action="keyword:战术"; 
        }elseif(ideasstrfind($articlewikied,"战略")==true){
            $action="keyword:战略"; 
        }elseif(ideasstrfind($articlewikied,"委员")==true){
            $action="keyword:委员"; 
        }elseif(ideasstrfind($articlewikied,"事件")==true){
            $action="keyword:事件"; 
        }elseif(ideasstrfind($articlewikied,"地铁")==true){
            $action="keyword:地铁"; 
        }elseif(ideasstrfind($articlewikied,"机关")==true){
            $action="keyword:机关"; 
        }elseif(ideasstrfind($articlewikied,"法院")==true){
            $action="keyword:法院"; 
        }elseif(ideasstrfind($articlewikied,"临床")==true){
            $action="keyword:临床"; 
        }elseif(ideasstrfind($articlewikied,"细胞")==true){
            $action="keyword:细胞"; 
        }elseif(ideasstrfind($articlewikied,"出版")==true){
            $action="keyword:出版"; 
        }
        if (ideasstrfind($articlewikied,"上市公司")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"股票代码")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"有限公司")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"有限责任公司")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"互联网")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"集团")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"控股")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"差评")==true && is_numeric($action)==true){
            $action=$action+1;
        }
        if(ideasstrfind($articlewikied,"另请参见")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"[[")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"'''")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"旗下")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"发明")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"专利")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"==")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"失败")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"贸易")==true && is_numeric($action)==true){
            $action=$action+2;
        }
        if(ideasstrfind($articlewikied,"19世纪")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"参考文献")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"18世纪")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"17世纪")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"16世纪")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"慈善")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"公益")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"影响")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"捐助")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"跨国")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"国有")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"纠纷")==true && is_numeric($action)==true){
            $action=$action+3;
        }
        if(ideasstrfind($articlewikied,"注释")==true && is_numeric($action)==true){
            $action=$action+4;
        }
        if(ideasstrfind($articlewikied,"参考")==true && is_numeric($action)==true){
            $action=$action+4;
        }
        if(ideasstrfind($articlewikied,"丑闻")==true && is_numeric($action)==true){
            $action=$action+5;
        }
        if(ideasstrfind($articlewikied,"负面")==true && is_numeric($action)==true){
            $action=$action+5;
        }
        if(ideasstrfind($articlewikied,"质疑")==true && is_numeric($action)==true){
            $action=$action+5;
        }
        if(ideasstrfind($articlewikied,"英雄")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"网址")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"工作室")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"营销")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"好评")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"@")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"价值")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"团队")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"►")==true && is_numeric($action)==true){
            $action=$action-1;
        }
        if(ideasstrfind($articlewikied,"质量奖")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"获奖")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"荣誉")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"特约")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"东南亚")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"编辑")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"他们")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"出席")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"东方")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"精华")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"西方")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"西式")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"欧式")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"日式")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"料理")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"广受")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"病人")==true && is_numeric($action)==true){
            $action=$action-2;
        }
        if(ideasstrfind($articlewikied,"治病")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"团购")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"畅销")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"经典之作")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"绝对")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"首选")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"主营")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"几乎所有")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"首款")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"深受")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"品牌简介")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"品牌定位")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"品牌诠释")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"信赖")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"信得过")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"优惠")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"题词")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"贺电")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"贺礼")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"剪彩")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"赞助")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"特级")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"极品")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"高端")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"高贵")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"典雅")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"奢华")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"兼备")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"乐园")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"诚邀")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"顶峰")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"官网")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"享誉")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"最好")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"最新")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"最优秀")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"最给力")==true && is_numeric($action)==true){
            $action=$action-3;
        }
        if(ideasstrfind($articlewikied,"电话")==true && is_numeric($action)==true){
            $action=$action-4;
        }
        if(ideasstrfind($articlewikied,"我国")==true && is_numeric($action)==true){
            $action=$action-4;
        }
        if(ideasstrfind($articlewikied,"我厂")==true && is_numeric($action)==true){
            $action=$action-4;
        }
        if(ideasstrfind($articlewikied,"我司")==true && is_numeric($action)==true){
            $action=$action-4;
        }
        if(ideasstrfind($articlewikied,"加盟")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"我省")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"我市")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"省长")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"市长")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"委员长")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"推荐")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"数百年来")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"座驾")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"豪华")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"商务")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"成功")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"网店")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"地址")==true && is_numeric($action)==true){
            $action=$action-4;
        }
    if(ideasstrfind($articlewikied,"欢迎")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"订购")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"从速")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"脱销")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"代开")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"发票")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"办证")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"单位")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"朋友")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"预约")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"只需")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"特效")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"限量")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"稀有")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"超低价格")==true && is_numeric($action)==true){
            $action=$action-5;
        }
    if(ideasstrfind($articlewikied,"仅有")==true && is_numeric($action)==true){
            $action=$action-5;
        }

        if (is_numeric($action)==true && $action< 0){
            if (is_numeric($action)==true && $action< -5){
                //悬挂模版G10
                if (ideasstrfind(ideasview($title),"{{d")==false && ideasstrfind(ideasview($title),"{{advert") ==false){
                    $topwikied=ideasviewtop($title);
                    $topwikied="{{D|G11}}\r\n".$topwikied;
                    ideasedittop($title,$topwikied,"使用[[Template:D|G11模版]]标记疑似广告的编辑(条目评分:".$action.")");
                    ideaslog("Add {{D|G11}} to : [[".$title."]],条目评分: ".$action);
                }
            }else{
                //悬挂模版advert
                if (ideasstrfind(ideasview($title),"{{d")==false && ideasstrfind(ideasview($title),"{{advert") ==false){
                    $topwikied=ideasviewtop($title);
                    $topwikied="{{subst:Advert/auto}}\r\n".$topwikied;
                    ideasedittop($title,$topwikied,"使用[[Template:advert]]标记疑似广告的编辑(条目评分:".$action.")");
                    ideaslog("Add {{advert}} to : [[".$title."]],条目评分: ".$action);
                }
            }
        }
    //ideaslog("检测到条目[[".$title."]] ,评分:".$action); //通常情况下请注释本行,用于调试算法
    return $action;

}

//该函数用于清空中文维基百科沙盒
//目前只支持大小为267字节的沙箱
function zhwp_clean_sandbox($sandboxname="Wikipedia:沙盒"){
    $zf_cleansandbox_min_time; //最短清理沙盒时间(秒)
    $timestamp=ideas_get_last_edit_time($title);
    $unixtime=ideas_deal_timestamp($timestamp,"unixtime");
    $now=time();
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
//以下函数为测试函数,运行可能不稳定
//以下函数为测试函数,运行可能不稳定
//以下函数为测试函数,运行可能不稳定
//以下函数为测试函数,运行可能不稳定
//以下函数为测试函数,运行可能不稳定
//以下函数为测试函数,运行可能不稳定

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
    $wikied=ideasview($title);
    $wikied2=$wikied;
    if (ideasstrfind($wikied,$title)==true){
        //如果条目中出现同标题的文字
        if (ideasstrfind($wikied,"'''".$title."'''")==false){
            //如果没有加粗
            $wikied=ideasstrreplace($title,"'''".$title."'''",$wikied);
            ideaslog("加粗了同标题的文字:".$title);
        }
    }
    if  (ideasstrfind($wikied,"<ref>")==true){
        //如果有注释标签
        if (ideasstrfind($wikied,"{{reflist}}")==false){
            //又没有{{reflist}}
            $wikied=$wikied."\r\n{{reflist}}";
            ideaslog("添加reflist到以下条目:".$title);
        }
    }
    if ($wikied2!=$wikied){
        //如果有改动
        ideasedit("User:ideasBot/sandbox/".$title,$wikied,"维基化页面");
    }
    return;
}

//该函数用于从最近更改列表中进行反破坏
function zhwp_anti_vandal(){
    $arraydata=ideasgetrecentchanges();
    $i=0;
    $isum=count ($arraydata->query->recentchanges->rc);
    do{
        zhwp_anti_vandal_core($arraydata->query->recentchanges->rc[$i]->attributes()->title);
    }while($i <= ($isum-1));
    return;
}

//该函数是反破坏模块的核心函数
function zhwp_anti_vandal_core($title){
    return;
}

?>
