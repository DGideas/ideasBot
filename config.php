<?php
//encode:UTF-8

//通用
$lgname="Botname"; //机器人账户的用户名(记录日志等操作也会用到)
$lgpassword="Password"; //机器人账户的密码
$url=array(); //建立一个数组
//zhwp:中文维基百科
//enwp:英文维基百科
//zhmg:中文萌娘百科
$defaulturl="zhwp"; //默认的站点代号
$useragent= $lgname."Version,by author"; //机器人的用户代理标识
$cookiefilepath=getcwd()."/cookie.log"; //机器人cURL使用的cookie记录文件

//定义API.php位置
$url["zhwp"]="http://zh.wikipedia.org/w/api.php"; //中文维基百科
$url["enwp"]="http://en.wikipedia.org/w/api.php"; //英文维基百科
$url["zhmg"]="http://zh.moegirl.org/api.php"; //中文萌娘百科

//日志
$logname="Username"; //机器人使用ideasreport()报告到的用户名
$logfile="log.log"; //机器人日志文件的文件名,不需要可以无视
$logformat="%Y/%m/%d %H:%M:%S"; //机器人记录日志文件时间戳的格式

//编辑
$editsummaryhead="[[WP:BOT|".$lgname."]]: "; //机器人编辑摘要头
$editsummarylast="([[User_talk:".$logname."|报告错误]])"; //机器人编辑摘要尾

//zhwpfunc1拓展(https://github.com/DGideas/ideasBot/blob/master/zhwpfunc1.php)
$zf_cleansandbox_min_time=300; //最短清理沙箱时间为300秒(5分钟)

//好了,请不要继续编辑,请在点击保存之后退出
?>
