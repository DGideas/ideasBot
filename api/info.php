<?php
//encode:UTF-8

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

?>
