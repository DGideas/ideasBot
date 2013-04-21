<?php
//encode:UTF-8


//该函数用于cURL POST连接
//$post:指明了附加POST的内容,默认为空
//$site:指明了连接到的站点,默认为$defaulturl
//API帮助:https://www.mediawiki.org/wiki/API:Main_page
function ideas_connect($post="",$site="") {
    global $url,$useragent,$cookiefilepath;
    // 创建一个新cURL资源
    $ideasconnect = curl_init();
    // 设置XML格式
    if ($post!=""){
        $post=$post."&format=xml";
    }
    
    if ($site==""){
        curl_setopt ($ideasconnect, CURLOPT_URL, $url[$GLOBALS["wiki"]]);
    }else{
        curl_setopt ($ideasconnect, CURLOPT_URL, $url[$site]);
    }
    curl_setopt ($ideasconnect, CURLOPT_HEADER, false);
    curl_setopt ($ideasconnect, CURLOPT_ENCODING, "UTF-8");
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

?>
