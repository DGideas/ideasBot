<?php
//encode:UTF-8


//广告检查函数核心(页面名称)
function ext_check_ad($title){
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


?>
