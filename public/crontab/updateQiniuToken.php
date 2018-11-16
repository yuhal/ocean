<?php
header("Content-type: text/html; charset=utf-8");
set_time_limit(0);
include 'MMysql.php';
include '/var/www/ocean/extend/qiniu/QiniuSdk.php';

$qiniu_sdk = json_decode(GetTableValue('yh_sdk','sdk_info',"sdk_name='qiniu_sdk'"),true);
$Qiniu = new \qiniu\QiniuSdk($qiniu_sdk);

$msg = "七牛云图片更新失败！记录时间：".date('Y-m-d H:i:s');
$tableList = GetTableColumn('information_schema.tables','table_name',"table_name like '%yh_%' and table_name <> 'yh_sys_log'");
foreach ($tableList as $key => $value) {
	$fieldList = GetTableColumn('information_schema.columns','column_name',"table_name = '{$value}' and (data_type = 'varchar' or data_type = 'text')");
	foreach ($fieldList as $k => $v) {
		$tokenUrl = GetTableValue($value,$v,"{$v} like '%?e=%' and {$v} like '%&token=%'");
		if($tokenUrl){
			//如果字段内容是json,则转为数组
			$jsonArr = json_decode($tokenUrl);
			if($jsonArr){
				foreach ($jsonArr as $k2 => $v2) {
					$temp[$k2] = $v2;
					if(strstr($v2, '?e=') && strstr($v2, '&token=')){
						$urlInfo = explode('?', $v2);
						$arr['baseUrl'] = current($urlInfo);
						$temp[$k2] = $Qiniu->privateDownloadUrl($arr);	
					}
				}	
				$tempValue = json_encode($temp);
				$sql = "update {$value} set {$v}='{$tempValue}'";
			}else{
				$urlInfo = explode('?', $tokenUrl);
				$arr['baseUrl'] = current($urlInfo);
				$str = $Qiniu->privateDownloadUrl($arr);
				$sql = "update {$value} set {$v}='{$str}'";
			}
			$re = $mysql->doSql($sql);
			if($re){
				record_log('七牛云图片更新成功！记录时间'.$time.' 记录信息：'.$sql);
			}else{
				record_log('七牛云图片更新失败！记录时间'.$time.' 记录信息：'.$sql);
			}
		}
	}
}
