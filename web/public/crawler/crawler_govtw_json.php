<?php
//namespace crawler;
 ini_set("max_execution_time", "300");
require '../class/class_crawler.php' ;
header('Content-Type: application/json; charset=utf-8');
$url='http://gis.taiwan.net.tw/XMLReleaseALL_public/scenic_spot_C_f.json';

$re_json=new crawler();
$privateip='';
echo $re_json->Curl_st($url);

?>