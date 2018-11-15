<?php
header("Content-type: text/html; charset=utf-8");
set_time_limit(0);
include 'MMysql.php';

$tableList = GetTableColumn('information_schema.tables','table_name',"table_name like '%yh_%'");
foreach ($tableList as $key => $value) {
	$fieldList = GetTableColumn('information_schema.columns','column_name',"table_name = '{$value}' and data_type = 'varchar'");
	foreach ($fieldList as $k => $v) {
		$isTokenField = GetTableValue($value,$v,"{$v} like '%&token=%'");
		if($isTokenField){
			echo $isTokenField.PHP_EOL;
		}
	}
}exit;

$sdk_info = json_decode(GetTableValue('yh_sdk','sdk_info',"sdk_name='toutiao_sdk'"),true);
$getdata['type'] = 'top';
$getdata['key'] = $sdk_info['key'];
$re = json_decode(curl_get('http://v.juhe.cn/toutiao/index',$getdata),true);

TrunCateTable('yh_information');
$msg = "最新资讯更新失败！记录时间：".date('Y-m-d H:i:s');
if($re['result']['data']){
	$list = $re['result']['data'];
	$i = 0;
	foreach ($list as $key => $value) {
		$information_data['id'] = $key+1;
		$information_data['url'] = $value['url'];
		$information_data['title'] = $value['title'];
		if($mysql->insert('yh_information',$information_data)){
			$i++;
		}
	}
	if(count($list)!=$i){
		$log_data['text'] = $msg;
		$mysql->insert('yh_sys_log',$log_data);
	}
}else{
	$log_data['text'] = $msg;
	$mysql->insert('yh_sys_log',$log_data);
}





