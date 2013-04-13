<?php
//encode:UTF-8

//通用
$lgname="Botname"; //机器人账户的用户名(记录日志等操作也会用到)
$lgpassword="Password"; //机器人账户的密码
$url=array(); //建立一个数组
$defaulturl="zhwp"; //默认的站点代号,详情请参阅help/urlcode.txt
$defaultlanguage="zh-hans"; //默认的语言,具体请参阅translation/readme.txt
$useragent= $lgname."Version,by DGideas"; //机器人的用户代理标识
$cookiefilepath=getcwd()."/cookie.log"; //机器人使用的cookie记录文件
//注意:请输入机器人cookie临时文件的*绝对路径*

//日志
$logname="Username"; //机器人使用ideasreport()报告到的用户名
$logfile="log.log"; //机器人日志文件的文件名,不需要可以无视
$logformat="%Y/%m/%d %H:%M:%S"; //机器人记录日志文件时间戳的格式

//编辑
$editsummaryhead="[[User:".$lgname."|".$lgname."]]: "; //机器人编辑摘要头
$editsummarylast="([[User_talk:".$logname."|任何问题?]])"; //机器人编辑摘要尾

$zf_cleansandbox_min_time="300"; //最短清理沙箱时间为300秒(5分钟)

//好了,请不要继续编辑,请在点击保存之后退出


//如果您不了解下面设置的用法,请不要设置下面的参数
//定义urlcode
$url["zhwp"]="http://zh.wikipedia.org/w/api.php"; 
$url["enwp"]="http://en.wikipedia.org/w/api.php"; 
$url["arwp"]="http://ar.wikipedia.org/w/api.php"; 
$url["bgwp"]="http://bg.wikipedia.org/w/api.php"; 
$url["cawp"]="http://ca.wikipedia.org/w/api.php"; 
$url["cswp"]="http://cs.wikipedia.org/w/api.php"; 
$url["dawp"]="http://da.wikipedia.org/w/api.php"; 
$url["dewp"]="http://de.wikipedia.org/w/api.php"; 
$url["eswp"]="http://es.wikipedia.org/w/api.php"; 
$url["etwp"]="http://et.wikipedia.org/w/api.php"; 
$url["gawp"]="http://gan.wikipedia.org/w/api.php"; 
$url["fawp"]="http://fa.wikipedia.org/w/api.php"; 
$url["fiwp"]="http://fi.wikipedia.org/w/api.php"; 
$url["frwp"]="http://fr.wikipedia.org/w/api.php"; 
$url["hewp"]="http://he.wikipedia.org/w/api.php"; 
$url["hrwp"]="http://hr.wikipedia.org/w/api.php"; 
$url["htwp"]="http://ht.wikipedia.org/w/api.php"; 
$url["huwp"]="http://hu.wikipedia.org/w/api.php"; 
$url["idwp"]="http://id.wikipedia.org/w/api.php"; 
$url["itwp"]="http://it.wikipedia.org/w/api.php"; 
$url["jawp"]="http://ja.wikipedia.org/w/api.php"; 
$url["kowp"]="http://ko.wikipedia.org/w/api.php"; 
$url["srwp"]="http://sr.wikipedia.org/w/api.php"; 
$url["test"]="http://test.wikipedia.org/w/api.php"; 
$url["test2"]="http://test2.wikipedia.org/w/api.php"; 
$url["ruwp"]="http://ru.wikipedia.org/w/api.php"; 
$url["wuwp"]="http://wuu.wikipedia.org/w/api.php"; 
$url["zcwp"]="http://zh-classical.wikipedia.org/w/api.php"; 
$url["zywp"]="http://zh-yue.wikipedia.org/w/api.php"; 

$url["zhmg"]="http://zh.moegirl.org/api.php";
$url["enmg"]="http://en.moegirl.org/api.php";
$url["jpmg"]="http://jp.moegirl.org/api.php";

$url["tfs"]="http://tfs.happylr.net/api.php"; 

?>
