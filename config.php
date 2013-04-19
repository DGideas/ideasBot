<?php
//encode:UTF-8

//通用
$lgname="Botname"; //机器人账户的用户名(记录日志等操作也会用到)
$lgpassword="Password"; //机器人账户的密码
$author="Username"; //您自己的用户名,用于机器人报告等多种用途
$defaulturl="zhwp"; //默认的站点代号,请参阅help/urlcode.txt
$wiki="zhwp"; //指定初始的预设工作维基,请参阅help/workwiki.txt
$defaultlanguage="zh-hans"; //默认的语言,请参阅translation/readme.txt
$useragent= $lgname."Version,by ideasBot based."; //机器人的用户代理标识(useragent)
$cookiefilepath=dirname(__FILE__)."/cookie.log"; //机器人使用的cookie临时文件,需要RWRWRW权限,使用绝对路径
$feedback=true; //设为true以参加用户反馈计划,以帮助我们改善.我们不会收集您的隐私信息.请参见help/feedback.txt

//日志
$logname=$author; //机器人使用ideas_report()报告到的用户名
$logfile=dirname(__FILE__)."log.log"; //机器人日志文件,不需要可以无视
$logformat="%Y/%m/%d %H:%M:%S"; //机器人记录日志文件时间戳的格式

//编辑
$editsummaryhead="[[User:".$lgname."|".$lgname."]]: "; //机器人编辑摘要头
$editsummarylast="([[User_talk:".$logname."|任何问题?]])"; //机器人编辑摘要尾


//好了,请不要继续编辑,请在点击保存之后退出


//简化参数
$dfl=$defaultlanguage;
//更换工作目录
chdir(dirname(__FILE__));
//如果您不了解下面设置的用法,请不要设置下面的参数
//定义urlcode
$url=array(); //建立一个数组

$url["meta"]="http://meta.wikimedia.org/w/api.php"; 
$url["labs"]="http://wikitech.wikimedia.org/w/api.php"; 
$url["tech"]="http://wikitech.wikimedia.org/w/api.php"; 
$url["species"]="http://species.wikimedia.org/w/api.php"; 
$url["commons"]="http://commons.wikimedia.org/w/api.php"; 
$url["data"]="http://www.wikidata.org/w/api.php"; 

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

$url["tfs"]="http://test.happylr.net/api.php"; 

?>
