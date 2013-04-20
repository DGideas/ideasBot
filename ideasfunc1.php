<?php
//encode:UTF-8
//帮助文档:help/ideasfunc.txt


//该函数用于获取最近更改(recentchanges)的条目(查询数量,查询种类,名称空间,筛选器,额外)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+recentchanges
//$rclimit:指明了返回最近更改的数量,默认为5000
//$rctype:指明了最近更改类型的过滤器,默认为新条目
//$rcnamespace:指明了最近更改名称空间的过滤器,默认为主名称空间
//$rcshow:指明了最近更改属性的过滤器,默认为不显示机器人更改和重定向页
//$extra:指明了附加到POST请求的额外内容,以&开头
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

//该函数用于基于条件查询条目(非重定向)列表(条件)
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+allpages
//$extra:指明了附加到POST请求的信息,以一个&开头
function ideas_list($extra){
    if ($extension==""){
        $post="action=query&list=allpages&aplimit=5000&apfilterredir=nonredirects";
    }else{
        $post="action=query&list=allpages&aplimit=5000&apfilterredir=nonredirects&".$extra;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //请注意,如果没有搜索到任何结果,使用返回值可能造成不可预料的后果
    //搜索内容为:query->allpages->p[$i]->attributes()->title
}

//该函数用于获得本地维基图片用量状况(标题,名称空间)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+imageusage
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//$iutitle:指明了目标图片名称,这个参数是必需的
//$iunamespace:指明了需要搜索的名称空间,默认为主名称空间
function ideas_get_image_usage($iutitle,$iunamespace="0"){
    $post="action=query&list=imageusage&iulimit=5000&iufilterredir=nonredirects&iunamespace=".$iunamespace."&iutitle=".$iutitle;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //目标页面标题:query->imageusage->iu[$i]->attributes()->title
}

//该函数用于获得特定用户的主页面名称空间用户贡献(用户名,编辑次数(默认为100))
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+usercontribs
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//$user:指明了目标用户,这个参数是必需的
//$times:指明了要查询的条目数,默认为100
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

//该函数用于获取执行相应动作的token(标题,动作)
//$title:指明了目标页面,这个参数是必需的
//$intoken:指明了需要获得的令牌种类,默认为edit
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+info
function ideas_get_token($title,$intoken="edit"){
    $post="action=query&prop=info&titles=".$title."&intoken=".$intoken;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page[0]->attributes()->edittoken;
}

//该函数用于编辑条目(标题,内容,摘要)(覆盖!)
//WARNING:本函数会覆盖!页面原有内容
//$title:指明了目标页面的标题,这个参数是必需的
//$text:指明了页面的内容
//$summary:指明了编辑摘要,默认为空
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=edit
function ideas_edit($title,$text,$summary=""){
    //步骤1:获得edittoken
    $edittoken=ideas_get_token($title,"edit");
    $edittokenhtml=str_ireplace("+\\","%2B%5C",$edittoken); //自动将末尾+\ HTML编码为%2B%5C
    $text=urlencode($text);//HTML编码
    $summary=urlencode($summary);//HTML编码
    //步骤2:添加新段落
    if ($summary==""){
        $post="action=edit&title=".$title."&text=".$text."&token=".$edittokenhtml;
    }else{
        $summary=ideas_summary($summary); //处理编辑摘要头尾
        $post="action=edit&title=".$title."&text=".$text."&token=".$edittokenhtml."&summary=".$summary;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

//该函数用于编辑条目顶部(添加管理模版等)(标题,内容,摘要)
//WARNING:函数不稳定
//$title:指明了目标页面的标题,这个参数是必需的
//$text:指明了第0段的内容
//$summary:指明了编辑摘要,默认为空
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=edit
function ideas_edit_top($title,$text,$summary=""){
    //步骤1:获得edittoken
    $edittoken=ideas_get_token($title,"edit");
    $edittokenhtml=str_ireplace("+\\","%2B%5C",$edittoken); //自动将末尾+\ HTML编码为%2B%5C
    $text=urlencode($text);//HTML编码
    $summary=urlencode($summary);//HTML编码
    //步骤2:添加新段落
    if ($summary==""){
        $post="action=edit&title=".$title."&section=0&text=".$text."&token=".$edittokenhtml;
    }else{
        $summary=ideas_summary($summary); //处理编辑摘要头尾
        $post="action=edit&title=".$title."&section=0&text=".$text."&token=".$edittokenhtml."&summary=".$summary;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

//该函数用于添加新段落(标题,段落标题,内容,编辑摘要)
//WARNING:函数不稳定
//$title:指明了目标页面的标题,这个参数是必需的
//$sectiontitle:指明了段落的标题
//$text:指明了页面的内容
//$summary:指明了编辑摘要,默认为空
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=edit
function ideas_edit_new($title,$sectiontitle,$text,$summary=""){
    //步骤1:获得edittoken
    $edittoken=ideas_get_token($title,"edit");
    $edittokenhtml=str_ireplace("+\\","%2B%5C",$edittoken); //自动将末尾+\ HTML编码为%2B%5C
    $summary=urlencode($summary);//HTML编码
    $text=urlencode($text);//HTML编码
    //步骤2:添加新段落
    if ($summary==""){
        $post="action=edit&title=".$title."&section=new&sectiontitle=".$sectiontitle."&text=".$text."&token=".$edittokenhtml;
    }else{
        $summary=ideas_summary($summary); //处理编辑摘要头尾
        $post="action=edit&title=".$title."&section=new&sectiontitle=".$sectiontitle."&text=".$text."&token=".$edittokenhtml."&summary=".$summary;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

?>
