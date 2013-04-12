<?php
//encode:UTF-8
//帮助文档:help/ideasfunc.txt


//该函数用于cURL连接
function ideas_connect($post="",$site="") {
    global $url,$useragent,$cookiefilepath,$defaulturl;
    // 创建一个新cURL资源
    $ideasconnect = curl_init();
    // 设置XML格式
    if ($post!=""){
        $post=$post."&format=xml";
    }
    
    if ($site==""){
        curl_setopt ($ideasconnect, CURLOPT_URL, $url[$defaulturl]);
    }else{
        curl_setopt ($ideasconnect, CURLOPT_URL, $url[$site]);
    }
    curl_setopt ($ideasconnect, CURLOPT_HEADER, false);
    curl_setopt ($ideasconnect, CURLOPT_ENCODING, "UTF-8" );
    curl_setopt ($ideasconnect, CURLOPT_USERAGENT, $useragent);
    curl_setopt ($ideasconnect, CURLOPT_POST, true); 
    curl_setopt ($ideasconnect, CURLOPT_POSTFIELDS,$post);
    curl_setopt ($ideasconnect, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ideasconnect, CURLOPT_COOKIEFILE, $cookiefilepath);
    curl_setopt ($ideasconnect, CURLOPT_COOKIEJAR, $cookiefilepath);
    
    // 抓取URL并把它传递给浏览器
    $data=curl_exec($ideasconnect);
    
    // 关闭cURL资源，并且释放系统资源
    //curl_close($ideasconnect);
    return $data;
}

//该函数用于输出空行
function echop(){
    echo "<p />\r\n";
    return;
}

//该函数用于登录(用户名,密码)
//已经修复一个并发连接导致的错误
//Note:$site参数暂时不用
function ideas_login($site=""){
    global $lgname,$lgpassword;
    $result=ideas_login_core($lgname,$lgpassword);
    if ($result == "Success"){
        echo"登陆成功";
        echop();
    }else{
        echo "登录失败,返回值为:";
        echop();
        echo ($result);
        //通常的错误是wrongpassword,needtoken,wrongtoken.
        if ($result=="needtoken"){
            echo "如果这个错误是偶尔出现的,请检查程序防止并发登录.并确保cookie.log至少有RWRWRW权限";
            exit();
        }elseif ($result=="wrongtoken"){
            $result=ideas_login_core($lgname,$lgpassword);
        }
    }
    return;
}

//该函数是登录功能的核心模块
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=login
//Note:$site参数暂时不用
function ideas_login_core($username,$password,$site=""){
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

//该函数用于获取最近更改(recentchanges)的条目(查询数量,查询种类,名称空间,筛选器,额外)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+recentchanges
function ideas_get_recent_changes($rclimit="5000",$rctype="new",$rcnamespace="0",$rcshow="!bot|!redirect",$extra=""){
    if ($extra=""){
        $post="action=query&list=recentchanges&rctype=".$rctype."&rclimit=".$rclimit."&rcnamespace=".$rcnamespace."&rcshow=".$rcshow;
    }else{
        $post="action=query&list=recentchanges&rctype=".$rctype."&rclimit=".$rclimit."&rcnamespace=".$rcnamespace."&rcshow=".$rcshow.$extra;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //条目名称为:query->recentchanges->rc[$i]->attributes()->title
    //条目编者为:query->recentchanges->rc[$i]->attributes()->user
    //条目名称空间为:query->recentchanges->rc[$i]->attributes()->ns
    //其他的属性:pageid,revid,timestamp......
}

//该函数用于基于关键字的简单搜索(关键字,名称空间代码)
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+search
function ideas_search($searchtext,$namespace="0"){
    $post="action=query&list=search&srsearch=".$searchtext."&srnamespace=".$namespace;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //搜索条数为:query->searchinfo->attributes()->totalhits
    //搜索内容为:query->search->p[$i]->attributes()->title
}

//该函数用于基于条件查询条目(非重定向)列表(条件)
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
function ideaslist($extension){
    if ($extension==""){
        $post="action=query&list=allpages&aplimit=5000&apfilterredir=nonredirects";
    }else{
        $post="action=query&list=allpages&aplimit=5000&apfilterredir=nonredirects&".$extension;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //请注意,如果没有搜索到任何结果,使用返回值可能造成不可预料的后果
    //搜索内容为:query->allpages->p[$i]->attributes()->title
}

//该函数用于获得特定单个页的Wikied文本(页面名称)
function ideasview($pagename){
    $post="action=query&prop=revisions&rvprop=content&format=xml&titles=".$pagename;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $wikied=$xml->xpath("//rev");
    return $wikied[0];
}

//该函数用于获得第0段的Wikied文本(页面名称)
function ideasviewtop($pagename){
    $post="action=query&prop=revisions&rvsection=0&rvprop=content&format=xml&titles=".$pagename;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $wikied=$xml->xpath("//rev");
    return $wikied[0];
}

//该函数用于获得页面最近的编者(页面名称)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideasgetauthor($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=15&rvprop=user";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //用法:query->pages->page->revisions->rev[$i]->attributes()->user
}

//该函数用于获得页面的作者(页面名称)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
//WARNING:本函数请酌情使用!!!由于历史原因可能无法准确获取页面的真实作者(如首页)
function ideas_get_creator($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=1&rvdir=newer";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page->revisions->rev[0]->attributes()->user;
    //直接返回页面作者
}

//该函数用于获得页面最后的编辑时间
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideas_get_last_edit_time($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=1";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page->revisions->rev[0]->attributes()->timestamp;
    //直接返回最后编辑时间(推荐使用ideas_deal_timestamp($timestamp,$returntype)函数处理MediaWiki格式时间戳)
}

//该函数用于获得本地维基图片用量状况(标题,名称空间)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+imageusage
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
function ideasgetimageusage($iutitle,$iunamespace="0"){
    $post="action=query&list=imageusage&iulimit=5000&iufilterredir=nonredirects&iunamespace=".$iunamespace."&iutitle=".$iutitle;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //目标页面标题:query->imageusage->iu[$i]->attributes()->title
}

//该函数用于搜索文本中的关键字,是stristr的拓展,返回值类型为bool(字符串,关键字)
function ideasstrfind($str,$keyword){
    $return=stristr($str,$keyword);
    if ($return==false){
        return false;
    }else{
        return true;
    }
}

//该函数用于获取页面的大小
function ideas_get_size($title){
    $post="action=query&prop=revisions&titles=".$title."&rvprop=size";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page[0]->revisions->rev->attributes()->size;
}

//该函数用于获取执行相应动作的token(标题,动作)
function ideasgettoken($title,$intoken="edit"){
    $post="action=query&prop=info&titles=".$title."&intoken=".$intoken;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page[0]->attributes()->edittoken;
}

//该函数用于编辑条目顶部(添加管理模版等)(标题,内容,摘要)
function ideasedittop($title,$text,$summary=""){
    //步骤1:获得edittoken
    $edittoken=ideasgettoken($title,"edit");
    $edittokenhtml=str_ireplace("+\\","%2B%5C",$edittoken); //自动将末尾+\ HTML编码为%2B%5C
    $text=urlencode($text);//HTML编码
    $summary=urlencode($summary);//HTML编码
    //步骤2:添加新段落
    if ($summary==""){
        $post="action=edit&title=".$title."&section=0&text=".$text."&token=".$edittokenhtml;
    }else{
        $summary=ideassummary($summary); //处理编辑摘要头尾
        $post="action=edit&title=".$title."&section=0&text=".$text."&token=".$edittokenhtml."&summary=".$summary;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}
//该函数用于编辑条目(标题,内容,摘要)(覆盖!)
//WARNING:本函数会覆盖!页面原有内容
function ideasedit($title,$text,$summary=""){
    //步骤1:获得edittoken
    $edittoken=ideasgettoken($title,"edit");
    $edittokenhtml=str_ireplace("+\\","%2B%5C",$edittoken); //自动将末尾+\ HTML编码为%2B%5C
    $text=urlencode($text);//HTML编码
    $summary=urlencode($summary);//HTML编码
    //步骤2:添加新段落
    if ($summary==""){
        $post="action=edit&title=".$title."&text=".$text."&token=".$edittokenhtml;
    }else{
        $summary=ideassummary($summary); //处理编辑摘要头尾
        $post="action=edit&title=".$title."&text=".$text."&token=".$edittokenhtml."&summary=".$summary;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}


//该函数用于添加新段落(标题,段落标题,内容,编辑摘要)
function ideaseditnew($title,$sectiontitle,$text,$summary=""){
    //步骤1:获得edittoken
    $edittoken=ideasgettoken($title,"edit");
    $edittokenhtml=str_ireplace("+\\","%2B%5C",$edittoken); //自动将末尾+\ HTML编码为%2B%5C
    $summary=urlencode($summary);//HTML编码
    $text=urlencode($text);//HTML编码
    //步骤2:添加新段落
    if ($summary==""){
        $post="action=edit&title=".$title."&section=new&sectiontitle=".$sectiontitle."&text=".$text."&token=".$edittokenhtml;
    }else{
        $summary=ideassummary($summary); //处理编辑摘要头尾
        $post="action=edit&title=".$title."&section=new&sectiontitle=".$sectiontitle."&text=".$text."&token=".$edittokenhtml."&summary=".$summary;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

//该函数用于填充编辑摘要
//通过config.php的用户相关设置
function ideassummary($editsummary){
    global $editsummaryhead,$editsummarylast;
    $editsummary=$editsummaryhead.$editsummary.$editsummarylast;
    return $editsummary;
}

//该函数用于进行关键词替换(基于str_ireplace,自动替换多次)
function ideasstrreplace($oldstr,$newstr,$string){
    $string=str_ireplace($oldstr,$newstr,$string);
    return $string;
}

//该函数用于获得特定用户的主页面名称空间用户贡献(用户名,编辑次数(默认为100))
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+usercontribs
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
function ideas_get_user_contribs($user,$times="100"){
    $post="action=query&list=usercontribs&ucuser=".$user."&uclimit=".$times."&ucnamespace=0";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //所撰条目:query->usercontribs->item[$i]->attributes()->title
    //编辑时间:query->usercontribs->item[$i]->attributes()->timestamp
    //名称空间:query->usercontribs->item[$i]->attributes()->ns
}

//该函数用于清除cookie缓存
function ideas_clean_cookie(){
    global $cookiefilepath;
    $filehandle2=fopen($cookiefilepath,"w");
    fwrite($filehandle2,"");
    fclose($filehandle2);
    return;
}

//该函数用于处理MediaWiki格式时间戳,基于正则表达式.接受形如:2013-04-05T15:21:00Z
//含有两个参数:$timestamp:需要处理的时间戳
//$returntype:返回类型
//unixtime(类似于UNIX时间戳,默认):1365175260
//mysql:MYSQL格式:2013-04-05 15:21:00
//year:仅年:2013
//month:仅月:04
//day:仅日:05
//hour:仅小时:15
//minute:仅分钟:21
//second:仅秒:00
//all:堆积:20130405152100
//该函数会对$returntype进行检查,如果请求的不是预期的格式,则返回false
function ideas_deal_timestamp($timestamp,$returntype="unixtime"){
    ereg("[0-9]{4}",$timestamp,$reg);
    $year=$reg[0] ;
    //年
    ereg("-[0-9]{2}-",$timestamp,$reg);
    $month=$reg[0] ;
    ereg("[0-9]{2}",$month,$reg);
    $month=$reg[0] ;
    //月
    ereg("-[0-9]{2}T",$timestamp,$reg);
    $day=$reg[0] ;
    ereg("[0-9]{2}",$day,$reg);
    $day=$reg[0] ;
    //日
    ereg("T[0-9]{2}",$timestamp,$reg);
    $hour=$reg[0] ;
    ereg("[0-9]{2}",$hour,$reg);
    $hour=$reg[0] ;
    //时
    ereg(":[0-9]{2}:",$timestamp,$reg);
    $minute=$reg[0] ;
    ereg("[0-9]{2}",$minute,$reg);
    $minute=$reg[0] ;
    //分
    ereg(":[0-9]{2}Z",$timestamp,$reg);
    $second=$reg[0] ;
    ereg("[0-9]{2}",$second,$reg);
    $second=$reg[0] ;
    //秒
    if ($returntype=="all"){
        return $year.$month.$day.$hour.$minute.$second;
    }elseif ($returntype=="year"){
        return $year;
    }elseif ($returntype=="month"){
        return $month;
    }elseif ($returntype=="day"){
        return $day;
    }elseif ($returntype=="hour"){
        return $hour;
    }elseif ($returntype=="minute"){
        return $minute;
    }elseif ($returntype=="second"){
        return $second;
    }elseif ($returntype=="unixtime"){
        $unixtime=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
        $unixtime=strtotime($unixtime);
        return $unixtime;
    }elseif ($returntype=="mysql"){
        $mysqltime=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
        return $mysqltime;
    }else{
        return false;
    }
}

//该函数用于记录运行日志.自动添加时间戳和换行,部分兼容Wikied格式(文本)
function ideaslog($text){
    global $logfile,$logformat;
    $text="* ".strftime($logformat).": ".$text."\r\n";
    //写文件
    $filehandle=fopen($logfile,"a");
    fwrite($filehandle,$text);
    fclose($filehandle);
    //file_put_contents($logfile,$text);
    return;
}

//该函数用于向主人报告,自动添加标题和签名(文本)
function ideasreport($text){
    global $logname;
    $text=$text."\r\n\r\n~~~~";//添加签名
    $xml=ideaseditnew("User_talk:".$logname,"报告 :".time(),$text,$edittoken);
    if ($xml->edit->attributes()->result=="Success"){
        echo "成功报告,在".time();
        echop();
    }else{
        if ($xml->error->attributes()->code=="ratelimited"){
            echo "编辑频率过快,编辑失败";
            echop();
        }else{
            echo "报告失败,详细信息为:".$xml->error->attributes()->code;
            ideaslog("报告失败".$xml->error->attributes()->code);
            echop();
        }
    }
    return;
}

?>
