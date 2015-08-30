<?php
//encode:UTF-8

chdir(dirname(__FILE__));

//====================Settings====================
//==========Main==========
$author="Username"; //您自己的用户名,用于机器人报告等多种用途
$wiki="zhwp"; //指定初始的预设工作维基,请参阅help/workwiki.txt.默认的站点代号,请见下方
$defaultlanguage="zh-hans"; //默认的语言,请参阅translation/readme.txt
$cookiefilepath=dirname(__FILE__)."/cookie.log"; //机器人使用的cookie临时文件,需要RWRWRW权限,使用绝对路径
$feedback=true; //设为true以参加用户反馈.我们不会收集您的隐私信息.请参见help/feedback.txt
$maxexecutiontime="300"; //设定代码最大执行时间,在安全模式中无效.为了最大限度地避免问题代码,最好不要设置为0(无限时)

//==========Log==========
$logname=&$author; //机器人使用ideas_report()报告到的用户名
$logfile=dirname(__FILE__)."/log.log"; //机器人日志文件,不需要可以无视
$logformat="%Y/%m/%d %H:%M:%S"; //机器人记录日志文件时间戳的格式

//==========Edit==========
$editsummaryhead="[[User:".$lgname."|".$lgname."]]: "; //机器人编辑摘要头
$editsummarylast="([[User_talk:".$lgname."|任何问题?]])"; //机器人编辑摘要尾

//==========Web==========
$getverify=false; //设置为true以检查URL后作为密码的参数.请不要在本地运行时开启.
$getname=&$lgname; //设置从网页运行脚本时,URL后作为密码的参数名称
$getpassword=&$lgpassword; //设置从网页运行脚本时,URL后作为密码的参数值

//==========Debug==========
$written=true; //Enable debug mode can let the bot running under read-only mode.




//好了,请不要继续编辑,请在点击保存之后退出
//请不要改动下面的参数,除非您非常明白它的工作原理




//==========Version==========
$version="2.0 MileStone1";

//==========Bot's User-Agent==========
$useragent= " By ideasBot Framework, Version:".$version; 

//==========init var==========
$islogin=false; //User login status
$isfeedback=false; //Feedback Status

//==========args==========
$dfl=$defaultlanguage;
$lang=$defaultlanguage;

//==========set max exec time==========
ini_set("max_execution_time",$maxexecutiontime);

?>
