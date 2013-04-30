<?php
//encode:UTF-8
//帮助文档:help/ideasfunc.txt

//该函数用于输出空行
function echop(){
    echo "<p />\r\n";
    return;
}

//该函数用于搜索文本中的关键字,是stristr的拓展,返回值类型为bool(字符串,关键字)
function ideas_str_find($str,$keyword){
    $return=stristr($str,$keyword);
    if ($return==false){
        return false;
    }else{
        return true;
    }
}

//该函数用于填充编辑摘要
//通过config.php的用户相关设置
function ideas_summary($editsummary){
    global $editsummaryhead,$editsummarylast;
    $editsummary=$editsummaryhead.$editsummary.$editsummarylast;
    return $editsummary;
}

//该函数用于进行关键词替换(基于str_ireplace,自动替换多次)
function ideas_str_replace($oldstr,$newstr,$string){
    $string=str_ireplace($oldstr,$newstr,$string);
    return $string;
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
    preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})Z/",$timestamp,$reg);
    $year=$reg[1] ;//年
    $month=$reg[2] ;//月
    $day=$reg[3] ;//日
    $hour=$reg[4] ;//时
    $minute=$reg[5] ;//分
    $second=$reg[6] ;//秒
    //test passed, by DGideas, 20130413
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
function ideas_log($text){
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
function ideas_report($text){
    global $logname,$dfl;
    $text=$text."\r\n\r\n~~~~";//添加签名
    $xml=ideas_edit_new("User_talk:".$logname,$GLOBALS["ideastext"][$dfl]["report"].": ".time(),$text);
    if ($xml->edit->attributes()->result=="Success"){
        echo $GLOBALS["ideastext"][$dfl]["reportsuccess"];
        echop();
    }else{
        if ($xml->error->attributes()->code=="ratelimited"){
            echo $GLOBALS["ideastext"][$dfl]["reportfailed"];
            echop();
        }else{
            echo $GLOBALS["ideastext"][$dfl]["reportfailed"].": ".$xml->error->attributes()->code;
            ideas_log($GLOBALS["ideastext"][$dfl]["reportfailed"].$xml->error->attributes()->code);
            echop();
        }
    }
    return;
}

//该函数用于发送用户反馈信息
//兼容性增强:by DGideas,20130420
function ideas_feedback($feedback,$title=""){
    if ($GLOBALS["isfeedback"]==true){
        return;
    }
    global $lang,$lgname;
    if ($GLOBALS["feedback"]==true){
        if ($title==""){
            $title=$lgname." - ".$GLOBALS["ideastext"][$lang]["feedback"];
        }
        if (mail("dgideaswikipedia@gmail.com",$title,$feedback)==false){
            $post="version=".$GLOBALS["version"]."&feedback=".$feedback."&title=".$title;
            $data=ideas_connect($post,"feedback");
        }
    }
    return;
}

//该函数用于更改工作维基,是$GLOBALS["wiki"]的变通方法
function set_wiki($workwiki){
    $GLOBALS["wiki"]=$workwiki;
    return;
}

//该函数用于以Web方式运行脚本时的用户身份验证,参见:help/webverify.txt
function ideas_webverify(){
    global $getname,$getpassword,$lang,$getverify;
    if ($getverify==true){
        if (isset($_GET[$getname])&&$_GET[$getname]==$getpassword){
        }else{
            echo $GLOBALS["ideastext"][$lang]["error"];
            exit();
        }
    }
    return;
}

?>
