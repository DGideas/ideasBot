<?php
//encode:UTF-8

//通用
$lgname="Botname"; //机器人账户的用户名(记录日志等操作也会用到)
$lgpassword="Password"; //机器人账户的密码
$url=array(); //建立一个数组
$defaulturl="zhwp"; //默认的站点代号,详情请参阅help/urlcode.txt
$defaultlanguage="zh-hans"; //默认的语言,具体请参阅translation/readme.txt
$useragent= $lgname."Version,by author"; //机器人的用户代理标识
$cookiefilepath=getcwd()."/cookie.log"; //机器人cURL使用的cookie记录文件

//日志
$logname="Username"; //机器人使用ideasreport()报告到的用户名
$logfile="log.log"; //机器人日志文件的文件名,不需要可以无视
$logformat="%Y/%m/%d %H:%M:%S"; //机器人记录日志文件时间戳的格式

//编辑
$editsummaryhead="[[WP:BOT|".$lgname."]]: "; //机器人编辑摘要头
$editsummarylast="([[User_talk:".$logname."|有问题?]])"; //机器人编辑摘要尾

//zhwpfunc1拓展(https://github.com/DGideas/ideasBot/blob/master/zhwpfunc1.php)
$zf_cleansandbox_min_time="300"; //最短清理沙箱时间为300秒(5分钟)

//好了,请不要继续编辑,请在点击保存之后退出


//如果您不了解下面设置的用法,请不要设置下面的参数
//定义urlcode
$url["zhwp"]="http://zh.wikipedia.org/w/api.php"; //中文维基百科
$url["enwp"]="http://en.wikipedia.org/w/api.php"; //英文维基百科
$url["arwp"]="http://ar.wikipedia.org/w/api.php"; //阿拉伯文维基百科
$url["bgwp"]="http://bg.wikipedia.org/w/api.php"; //保加利亚文维基百科
$url["cawp"]="http://ca.wikipedia.org/w/api.php"; //加泰罗尼亚文维基百科
$url["cswp"]="http://cs.wikipedia.org/w/api.php"; //捷克文维基百科
$url["dawp"]="http://da.wikipedia.org/w/api.php"; //丹麦文维基百科
$url["dewp"]="http://de.wikipedia.org/w/api.php"; //德文维基百科
$url["eswp"]="http://es.wikipedia.org/w/api.php"; //西班牙文维基百科
$url["etwp"]="http://et.wikipedia.org/w/api.php"; //爱沙尼亚文维基百科
$url["gawp"]="http://gan.wikipedia.org/w/api.php"; //赣语维基百科
$url["fawp"]="http://fa.wikipedia.org/w/api.php"; //波斯文维基百科
$url["fiwp"]="http://fi.wikipedia.org/w/api.php"; //芬兰文维基百科
$url["frwp"]="http://fr.wikipedia.org/w/api.php"; //法文维基百科
$url["hewp"]="http://he.wikipedia.org/w/api.php"; //希伯来文维基百科
$url["hrwp"]="http://hr.wikipedia.org/w/api.php"; //克罗地亚文维基百科
$url["htwp"]="http://ht.wikipedia.org/w/api.php"; //海地文维基百科
$url["huwp"]="http://hu.wikipedia.org/w/api.php"; //匈牙利文维基百科
$url["idwp"]="http://id.wikipedia.org/w/api.php"; //印度尼西亚文维基百科
$url["itwp"]="http://it.wikipedia.org/w/api.php"; //意大利文维基百科
$url["jawp"]="http://ja.wikipedia.org/w/api.php"; //日文维基百科
$url["kowp"]="http://ko.wikipedia.org/w/api.php"; //韩文维基百科
$url["srwp"]="http://sr.wikipedia.org/w/api.php"; //塞尔维亚文维基百科
$url["ruwp"]="http://ru.wikipedia.org/w/api.php"; //俄文维基百科
$url["wuwp"]="http://wuu.wikipedia.org/w/api.php"; //吴语维基百科
$url["zcwp"]="http://zh-classical.wikipedia.org/w/api.php"; //文言维基百科
$url["zywp"]="http://zh-yue.wikipedia.org/w/api.php"; //粤语维基百科


$url["zhmg"]="http://zh.moegirl.org/api.php"; //中文萌娘百科
$url["tfs"]="http://tfs.happylr.net/api.php"; //TFS

?>
