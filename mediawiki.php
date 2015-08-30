<?php
//This file include MediaWiki APIs.
//Author:DGideas

class ideasBot
{
	function __construct()
	{
		
	}
	
	public function register()
	{
		
	}
	
	public function login()
	{
		
	}
	
	public function get()
	{
		
	}
	
	public function edit()
	{
		
	}
	
	public function delete()
	{
		
	}
	
	public function watch()
	{
		
	}
	
	public function unwatch()
	{
		
	}
	
	public function protect()
	{
		
	}
	
	public function rollback()
	{
		
	}
	
	public function move()
	{
		
	}
	
	public function undelete()
	{
		
	}
	
	public function patrol()
	{
		
	}
	
	protected function get_token()
	{
		
	}
	
	protected function uuid(){
		if (function_exists('com_create_guid')){ 
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);
			$uuid = substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12);
			$uuid=strtolower($uuid);
			return $uuid;
		}
	}

}

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

//该函数用于注册用户(用户名,密码)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=createaccount
function ideas_reg($username,$password){
    global $lgname,$lgpassword,$lang;
    $result=ideas_reg_core($username,$password);
    if ($result == "Success"){
        echo $GLOBALS["ideastext"][$lang]["ok"];
        echop();
    }else{
        echo $GLOBALS["ideastext"][$lang]["error"];
        echop();
        echo $result;
        ideas_feedback($GLOBALS["ideastext"][$lang]["loginfailed"].":".$result);
        //通常的错误是wrongpassword,needtoken,wrongtoken.
    }
    return;
}

//该函数是注册功能的核心模块
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=createaccount
function ideas_reg_core($name,$password){
    $post="action=createaccount&name=".$name."&password=".$password;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $token = $xml->createaccount[0]->attributes()->token;
    $post="action=createaccount&name=".$name."&password=".$password."&lgtoken=".$token;
    $data=ideas_connect($post);
    $xml = simplexml_load_string($data);
    //登陆过程完成
    return $xml->createaccount[0]->attributes()->result;
}

//该函数用于登录(用户名,密码)
//$site:指明了要登陆到的站点,默认为$GLOBALS["wiki"]
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=login
function ideas_login($wiki="",$username="",$password=""){
    global $lgname,$lgpassword,$ideastext,$defaultlanguage;
    if ($username==""){
        $result=ideas_login_core($lgname,$lgpassword);
    }else{
        $result=ideas_login_core($username,$password);
    }
    if ($result == "Success"){
        echo $GLOBALS["ideastext"][$defaultlanguage]["loginsuccess"];
        $GLOBALS["islogin"]=true;
        echop();
    }else{
        echo $GLOBALS["ideastext"][$defaultlanguage]["loginfailed"];
        echop();
        echo ($result);
        ideas_feedback($GLOBALS["ideastext"][$defaultlanguage]["loginfailed"].":".$result);
        //通常的错误是wrongpassword,needtoken,wrongtoken.
        if ($result=="needtoken"){
            echo $GLOBALS["ideastext"][$defaultlanguage]["needRW"];
            exit();
        }elseif ($result=="wrongtoken"){
            $result=ideas_login_core($lgname,$lgpassword,$wiki);
        }
    }
    return;
}

//该函数是登录功能的核心模块
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=login
//Note:$site参数暂时不用
//$lgname:指明了登录的用户名
//$lgpassword:指明了用户名对应的密码
//$site:指明了使用的站点
function ideas_login_core($lgname,$lgpassword){
    ideas_clean_cookie(); //登录前先清除cookie缓存
    $post="action=login&lgname=".$lgname."&lgpassword=".$lgpassword;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $token = $xml->login[0]->attributes()->token;
    $post="action=login&lgname=".$lgname."&lgpassword=".$lgpassword."&lgtoken=".$token;
    $data=ideas_connect($post);
    $xml = simplexml_load_string($data);
    //登陆过程完成
    return $xml->login[0]->attributes()->result;
}

//该函数用于删除页面(标题,原因)
//$title:指明了目标页面的标题,这个参数是必需的
//$reason:指明了删除页面的原因
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=delete
function ideas_delete($title,$reason=""){
    //步骤1:获得令牌
    $edittokenhtml=ideas_get_token($title,"delete");
    //步骤2:删除页面
    if ($reason==""){
        $post="action=delete&title=".$title."&token=".$edittokenhtml;
    }else{
        $reason=ideas_summary($reason); //处理编辑摘要头尾
        $post="action=delete&title=".$title."&token=".$edittokenhtml."&reason=".$reason;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

//该函数用于编辑条目(标题,内容,摘要)(覆盖!)
//WARNING:本函数会覆盖页面原有内容
//$title:指明了目标页面的标题,这个参数是必需的
//$text:指明了页面的内容,这个参数是必需的
//$summary:指明了编辑摘要,默认为空
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=edit
function ideas_edit($title,$text,$summary=""){
    //步骤1:获得edittoken
    $edittokenhtml=ideas_get_token($title,"edit");
    $title=urlencode($title);//HTML编码
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
//$title:指明了目标页面的标题,这个参数是必需的
//$text:指明了第0段的内容
//$summary:指明了编辑摘要,默认为空
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=edit
function ideas_edit_top($title,$text,$summary=""){
    //步骤1:获得edittoken
    $edittokenhtml=ideas_get_token($title,"edit");
    $title=urlencode($title);//HTML编码
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
//$title:指明了目标页面的标题,这个参数是必需的
//$sectiontitle:指明了段落的标题,这个参数是必需的
//$text:指明了页面的内容
//$summary:指明了编辑摘要,默认为空
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=edit
function ideas_edit_new($title,$sectiontitle,$text,$summary=""){
    //步骤1:获得edittoken
    $edittokenhtml=ideas_get_token($title,"edit");
    $title=urlencode($title);//HTML编码
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

//该函数用于获取执行相应动作的token(标题,动作)
//$title:指明了目标页面,这个参数是必需的
//$intoken:指明了需要获得的令牌种类,默认为edit
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+info
function ideas_get_token($title,$intoken="edit"){
    global $lang;
    $post="action=query&prop=info&titles=".$title."&intoken=".$intoken;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    if ($intoken=="edit"){
        $rtn=str_ireplace("+\\","%2B%5C",$xml->query->pages->page[0]->attributes()->edittoken); //自动将末尾+\ HTML编码为%2B%5C
        return $rtn;
    }elseif ($intoken=="protect"){
        $rtn=str_ireplace("+\\","%2B%5C",$xml->query->pages->page[0]->attributes()->protecttoken); //自动将末尾+\ HTML编码为%2B%5C
        return $rtn;
    }elseif ($intoken=="delete"){
        $rtn=str_ireplace("+\\","%2B%5C",$xml->query->pages->page[0]->attributes()->deletetoken); //自动将末尾+\ HTML编码为%2B%5C
        return $rtn;
    }elseif ($intoken=="email"){
        $rtn=str_ireplace("+\\","%2B%5C",$xml->query->pages->page[0]->attributes()->emailtoken); //自动将末尾+\ HTML编码为%2B%5C
        return $rtn;
    }elseif ($intoken=="move"){
        $rtn=str_ireplace("+\\","%2B%5C",$xml->query->pages->page[0]->attributes()->movetoken); //自动将末尾+\ HTML编码为%2B%5C
        return $rtn;
    }elseif ($intoken=="watch"){
        $rtn=str_ireplace("+\\","%2B%5C",$xml->query->pages->page[0]->attributes()->watchtoken); //自动将末尾+\ HTML编码为%2B%5C
        return $rtn;
    }else{
        ideas_feedback($GLOBALS["ideastext"][$lang]["usingunknownstr"].":".$intoken);
    }
}

//该函数用于简单移动页面(标题,原因),同时移动讨论页,不移动子页面,保留重定向
//$title:指明了目标页面(移动前)的标题,这个参数是必需的
//$titletarget:指明了目标页面(移动后)的标题,这个参数是必需的
//$reason:指明了移动页面的原因
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=move
function ideas_move($title,$titletarget,$reason=""){
    //步骤1:获得令牌
    $edittokenhtml=ideas_get_token($title,"move");
    //步骤2:移动页面
    if ($reason==""){
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml;
    }else{
        $reason=ideas_summary($reason); //处理编辑摘要头尾
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml."&reason=".$reason;
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

//该函数用于简单移动页面(标题,原因),同时移动讨论页,不移动子页面,不保留重定向
//$title:指明了目标页面(移动前)的标题,这个参数是必需的
//$titletarget:指明了目标页面(移动后)的标题,这个参数是必需的
//$reason:指明了移动页面的原因
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=move
function ideas_move_noredirect($title,$titletarget,$reason=""){
    //步骤1:获得令牌
    $edittokenhtml=ideas_get_token($title,"move");
    //步骤2:移动页面
    if ($reason==""){
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml."&noredirect=";
    }else{
        $reason=ideas_summary($reason); //处理编辑摘要头尾
        $post="action=move&from=".$title."&to=".$titletarget."&token=".$edittokenhtml."&reason=".$reason."&noredirect=";
    }
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
}

//该函数用于获取最近更改(recentchanges)的条目(查询数量,查询种类,名称空间,筛选器,额外)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+recentchanges
//$rclimit:指明了返回最近更改的数量,默认为100
//$rctype:指明了最近更改类型的过滤器,默认为新条目和编辑
//$rcnamespace:指明了最近更改名称空间的过滤器,默认为主名称空间
//$rcshow:指明了最近更改属性的过滤器,默认为不显示机器人更改和重定向页
//$extra:指明了附加到POST请求的额外内容,以&开头
function ideas_get_recent_changes($rclimit="100",$rctype="new|edit",$rcnamespace="0",$rcshow="!bot|!redirect",$extra=""){
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

//该函数用于获得特定单个页的Wikied文本(页面名称)
//$pagename:指明了目标页面名称,这个参数是必需的
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideas_view($pagename){
    $post="action=query&prop=revisions&rvprop=content&format=xml&titles=".$pagename;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $wikied=$xml->xpath("//rev");
    return $wikied[0];
}

//该函数用于获得第0段的Wikied文本(页面名称)
//$pagename:指明了目标页面名称,这个参数是必需的
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideas_view_top($pagename){
    $post="action=query&prop=revisions&rvsection=0&rvprop=content&format=xml&titles=".$pagename;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    $wikied=$xml->xpath("//rev");
    return $wikied[0];
}

//该函数用于获得页面最近的编者(页面名称)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
//$title:指明了目标页面名称,这个参数是必需的
function ideas_get_author($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=15&rvprop=user";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //用法:query->pages->page->revisions->rev[$i]->attributes()->user
}

//该函数用于获得页面的作者(页面名称)
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
//$title:指明了目标页面名称,这个参数是必需的
function ideas_get_creator($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=1&rvdir=newer";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page->revisions->rev[0]->attributes()->user;
    //直接返回页面作者
}

//该函数用于获得页面最后的编辑时间
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
//$title:指明了目标页面名称,这个参数是必需的
function ideas_get_last_edit_time($title){
    $post="action=query&prop=revisions&titles=".$title."&rvlimit=1";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page->revisions->rev[0]->attributes()->timestamp;
    //直接返回最后编辑时间(推荐使用ideas_deal_timestamp($timestamp,$returntype)函数处理MediaWiki格式时间戳)
}

//该函数用于获取页面的大小
//$title:指明了目标页面名称,这个参数是必需的
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+revisions
function ideas_get_size($title){
    $post="action=query&prop=revisions&titles=".$title."&rvprop=size";
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml->query->pages->page[0]->revisions->rev->attributes()->size;
}

//该函数用于基于关键字的简单搜索(关键字,名称空间代码)
//提示:该函数获得数据可能小于给定值,强烈建议预先使用count()计数以免发生错误
//API帮助:https://zh.wikipedia.org/w/api.php?action=help&modules=query+search
//$searchtext:指明了需要搜索的内容
//$namespace:指明了需要搜索的名称空间
function ideas_search($searchtext,$namespace="0"){
    $post="action=query&list=search&srsearch=".$searchtext."&srnamespace=".$namespace;
    $data=ideas_connect($post);
    //分析数据
    $xml = simplexml_load_string($data);
    return $xml;
    //搜索条数为:query->searchinfo->attributes()->totalhits
    //搜索内容为:query->search->p[$i]->attributes()->title
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

