<?php
//encode:UTF-8
//注意:请务必在每次执行操作后关闭数据库
$ideasdb=array();

//该函数用于读取数据库设置
function ext_ideasdb_get_conf(){
    $get=file_get_contents("db/ideasdb.conf");
    preg_match("/\s*.*dbname:(.*)\s*.*/",$get,$reg);
    $GLOBALS["ideasdb"]["dbname"]=$reg[1];
    preg_match("/\s*.*dbusername:(.*)\s*.*/",$get,$reg);
    $GLOBALS["ideasdb"]["dbusername"]=$reg[1];
    preg_match("/\s*.*dbpassword:(.*)\s*.*/",$get,$reg);
    $GLOBALS["ideasdb"]["dbpassword"]=$reg[1];
    preg_match("/\s*.*dbversion:(.*)\s*.*/",$get,$reg);
    $GLOBALS["ideasdb"]["dbversion"]=$reg[1];
    return;
}

//该函数用于读取数据库
function ext_ideasdb_load_db($db){
    if (file_get_contents("db/db".$db.".stat")!="inuse"){
        $data=file("db/db".$db.".idb");
        return $data;
    }else{
        return false;
    }
}

//该函数用于关闭数据库
function ext_ideasdb_close_db($db){
    $handle=fopen("db/db".$db.".stat","w");
    fwrite($handle,"null");
    fclose($handle);
    return;
}
?>
