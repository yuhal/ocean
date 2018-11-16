<?php
header("Content-type: text/html; charset=utf-8");
set_time_limit(0);
include 'MMysql.php';

$sdk_info = json_decode(GetTableValue('yh_sdk','sdk_info',"sdk_name='toutiao_sdk'"),true);
$getdata['type'] = 'top';
$getdata['key'] = $sdk_info['key'];
$re = json_decode(curl_get('http://v.juhe.cn/toutiao/index',$getdata),true);

TrunCateTable('yh_information');

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
	if(count($list)==$i && $i>0){
		record_log("最新资讯更新成功！记录时间：".$time);
	}else{
		record_log("最新资讯更新失败！记录时间：".$time);
	}
}else{
	record_log("最新资讯更新失败！记录时间：".$time);
}





