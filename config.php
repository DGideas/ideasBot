<?php
//encode:UTF-8

//更换工作目录
chdir(dirname(__FILE__));

//请在下方进行您的设定
//通用
$lgname="Botname"; //机器人账户的用户名(记录日志等操作也会用到)
$lgpassword="Password"; //机器人账户的密码
$author="Username"; //您自己的用户名,用于机器人报告等多种用途
$wiki="zhwp"; //指定初始的预设工作维基,请参阅help/workwiki.txt.默认的站点代号,请见下方
$defaultlanguage="zh-hans"; //默认的语言,请参阅translation/readme.txt
$cookiefilepath=dirname(__FILE__)."/cookie.log"; //机器人使用的cookie临时文件,需要RWRWRW权限,使用绝对路径
$feedback=true; //设为true以参加用户反馈.我们不会收集您的隐私信息.请参见help/feedback.txt
$maxexecutiontime="300"; //设定代码最大执行时间,在安全模式中无效.为了最大限度地避免问题代码,最好不要设置为0(无限时)

//日志
$logname=&$author; //机器人使用ideas_report()报告到的用户名
$logfile=dirname(__FILE__)."/log.log"; //机器人日志文件,不需要可以无视
$logformat="%Y/%m/%d %H:%M:%S"; //机器人记录日志文件时间戳的格式

//编辑
$editsummaryhead="[[User:".$lgname."|".$lgname."]]: "; //机器人编辑摘要头
$editsummarylast="([[User_talk:".$lgname."|任何问题?]])"; //机器人编辑摘要尾

//Web触发
$getverify=false; //设置为true以检查URL后作为密码的参数.请不要在本地运行时开启.
$getname=&$lgname; //设置从网页运行脚本时,URL后作为密码的参数名称
$getpassword=&$lgpassword; //设置从网页运行脚本时,URL后作为密码的参数值

//调试
$written=true; //仅供调试时使用!写入锁定,防止误操作.

//好了,请不要继续编辑,请在点击保存之后退出
//请不要改动下面的参数,除非您非常明白它的工作原理

//设定版本
$version="1.0.460";

//机器人的用户代理标识
$useragent= " By IdeasBot Framework, Version:".$version; 

//初始化变量
$islogin=false; //用户登录状态
$isfeedback=false; //反馈状态

//简化参数
$dfl=$defaultlanguage;
$lang=$defaultlanguage;

//设定代码最大执行时间
ini_set("max_execution_time",$maxexecutiontime);

//定义urlcode(参见help/urlcode.txt)
$url=array(); //建立一个数组

$url["meta"]="http://meta.wikimedia.org/w/api.php"; 
$url["labs"]="http://wikitech.wikimedia.org/w/api.php"; 
$url["tech"]="http://wikitech.wikimedia.org/w/api.php"; 
$url["species"]="http://species.wikimedia.org/w/api.php"; 
$url["commons"]="http://commons.wikimedia.org/w/api.php"; 
$url["data"]="http://www.wikidata.org/w/api.php"; 
$url["mw"]="http://www.mediawiki.org/w/api.php";
$url["mediawiki"]=&$url["mw"];

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

$url["archlinux"]="http://wiki.archlinux.org/api.php";
$url["bioedu"]="http://bio.cug.edu.cn/w/api.php";
$url["boinc"]="http://boinc.berkeley.edu/w/api.php";
$url["codex"]="http://codex.wordpress.org/api.php";
$url["filezilla"]="http://wiki.filezilla-project.org/wiki/api.php";
$url["mozilla"]="http://wiki.mozilla.org/api.php";
$url["nocow"]="http://www.nocow.cn/api.php";
$url["smmw"]="http://www.semantic-mediawiki.org/w/api.php";
$url["tfs"]="http://test.happylr.net/api.php"; 
$url["ubuntu"]="http://wiki.ubuntu.org.cn/api.php";
$url["wps"]="http://community.wps.cn/wiki/api.php";
$url["52poke"]="http://wiki.52poke.com/api.php";

$url["feedback"]="http://bots.wmflabs.org/~dgideas/ideasbot/feedback.php";

?>
