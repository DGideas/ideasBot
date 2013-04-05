<?php
//encode:UTF-8

//开始编辑配置文件
//通用
$lgname="Botname"; //机器人账户的用户名(记录日志等操作也会用到)
$lgpassword="Password"; //机器人账户的密码
$url="http://zh.wikipedia.org/w/api.php"; //机器人运行MW所在MediaWiki软件api.php地址
$useragent= $lgname."Version,by author"; //机器人的用户代理标识
$cookiefilepath=getcwd()."/cookie.log"; //机器人cURL使用的cookie记录文件

//日志
$logname="Username"; //机器人使用ideasreport()报告到的用户名
$logfile="log.log"; //机器人日志文件的文件名,不需要可以无视
$logformat="%Y/%m/%d %H:%M:%S"; //机器人记录日志文件时间戳的格式

//编辑
$editsummaryhead="[[WP:BOT|".$lgname."]]: "; //机器人编辑摘要头
$editsummarylast="([[User_talk:".$logname."|报告错误]])"; //机器人编辑摘要尾

//好了,请不要继续编辑,请在点击保存之后退出
?>
