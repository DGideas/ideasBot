<?php
//encode:UTF-8
$ideasdb=array();

//该函数用于读取数据库设置
function ext_get_ideasdb_conf(){
    $get=file_get_contents("db/ideasdb.conf");
    preg_match("/\s*.*dbname:(.*)\s*.*/",$get,$reg);
    $GLOBALS["ideasdb"]["dbname"]=$reg[1];
    preg_match("/\s*.*dbusername:(.*)\s*.*/",$get,$reg);
    $GLOBALS["ideasdb"]["dbusername"]=$reg[1];
    preg_match("/\s*.*dbpassword:(.*)\s*.*/",$get,$reg);
    $GLOBALS["ideasdb"]["dbpassword"]=$reg[1];
    return;
}
?>
