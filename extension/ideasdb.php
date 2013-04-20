<?php
//encode:UTF-8
$ideasdb=array();

//该函数用于读取数据库设置
function ext_get_ideasdb_conf(){
    $get=file_get_contents("db/ideasdb.conf");
    preg_match("/dbname:([0-9a-zA-Z]*)\sdbusername:([0-9a-zA-Z]*)\sdbpassword:([0-9a-zA-Z]*)/",$get,$reg);
    $GLOBALS["ideasdb"]["dbname"]=$reg[1];
    $GLOBALS["ideasdb"]["dbusername"]=$reg[2];
    $GLOBALS["ideasdb"]["dbpassword"]=$reg[3];
    return;
}
?>
