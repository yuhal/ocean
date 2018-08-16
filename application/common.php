<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//use Endroid\QrCode\QrCode;
//use qiniu\sdk\Qiniusdk;

function getAccessToken($url,$type){
    $res=@file_get_contents('access_token.json');
    $result=json_decode($res,true);     
    $expires_time=isset($result[$type]['expires_time']) ? $result[$type]['expires_time'] : 0;
    //如果过了有效时间，那么重新生成
    if(time()>$expires_time){
        $json=json_decode(http_request($url),true);
        $expires_time=time()+3600;//最大的token保存时间
        $result[$type] = [
            'access_token'=>$json['access_token'],
            'openid'=>isset($json['openid']) ? $json['openid'] : $json['uid'],
            'expires_time'=> $expires_time
        ];
        $save_token = json_encode($result);
        file_put_contents('access_token.json',$save_token);
        return $json;
    }else{
        return $result[$type];
    }        
}

/** 
 * 七牛云上传文件 
 * 
 * @param array $file 图片信息 
 * @return false|array 
 */
function qiniu_upload($file){
    $qiniu_sdk = config('sdk.qiniu_sdk');
    $ext = get_extension($file['name']);
    $title = uniqid().'.'.strtolower($ext);
    $savefile= '/var/www/ocean/runtime/temp/'.$title; 
    move_uploaded_file($file['tmp_name'],$savefile);
    try {
        $Qiniu = new \qiniu\QiniuSdk($qiniu_sdk);
        $Qiniu->upload($title,$savefile);
        return $qiniu_sdk['url'].$title;
    }catch(\Exception $e){
        return false;
    }
    
}

/** 
 * 获取远程文件大小 
 * 
 * @param string $url 远程文件的链接 
 * @return false|array 
 */
function getFileSize($url)   
{   
    $url = parse_url($url);   
    if($fp = @fsockopen($url['host'],empty($url['port'])?80:$url['port'],$error))   
    {   
        fputs($fp,"GET ".(empty($url['path'])?'/':$url['path'])." HTTP/1.1\r\n");   
        fputs($fp,"Host:$url[host]\r\n\r\n");   
        while(!feof($fp))   
        {   
            $tmp = fgets($fp);   
            if(trim($tmp) == '')   
            {   
                break;   
            }  
            elseif(preg_match('/Content-Length:(.*)/si',$tmp,$arr))   
            {   
                return formatSizeUnits(trim($arr[1]));   
            }   
        }   
        return null;   
    }   
    else   
    {   
        return null;   
    }   
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/** 
 * 首字母大写转换
 * 
 * @param array $arr  
 * @return false|str 
 */
function arrtoucfirst($arr){
    if(is_array($arr)){
        $str = '';
        foreach ($arr as $value) {
            $str .= ucfirst($value);
        }    
        return $str;
    }
    return false;
}

function parse_data($url,$data=''){
    if(!empty($data)){
        $res=http_request($url,$data);
    }else{
        $res=http_request($url);
    }
    if(!empty($res)){
        return json_decode($res);
    }
}

function http_request($url,$data=''){
    $ch=curl_init();//初始化（买电话）
    //设置参数
    curl_setopt($ch,CURLOPT_URL,$url);  
    //跳到证书检查
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//设置内容是不是返回
    //判断的那个钱是不是有post数据的发送
    if(!empty($data)){
        curl_setopt($ch,CURLOPT_POST,1);//设置post提交数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//设置post提交数据
    }
    $outopt=curl_exec($ch);//请求的地址输出了什么数据就会返回什么数据
    if($outopt === FALSE){
        return "curl 错误信息：".curl_error($ch);
    }   
    curl_close($ch);
    return $outopt;
}

function getQrcode($url){ 
    echo '不支持微信登陆';exit;
    $qrCode=new QrCode();  
    $qrCode->setText($url)
        ->setSize(300)//大小
        ->setLabelFontPath(VENDOR_PATH.'endroid/qrcode/assets/noto_sans.otf')
        ->setErrorCorrectionLevel('high')
        ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
        ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
        ->setLabel('')
        ->setLabelFontSize(16);
    header('Content-Type: '.$qrCode->getContentType());
    echo $qrCode->writeString();
    exit;
}

//文本去除'_=+'
function str_content_replace($str){
    return str_replace(array("_","=","+"),'',trim(htmlspecialchars($str)));
}

//文本去空
function str_content_replace2($str){
    return preg_replace('# #', '', $str);
}

function is_mobile_request()  
{  
     $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';  
     $_SERVER['HTTP_USER_AGENT'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
     $mobile_browser = '0';  
     if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))  
      $mobile_browser++;  
     if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))  
      $mobile_browser++;  
     if(isset($_SERVER['HTTP_X_WAP_PROFILE']))  
      $mobile_browser++;  
     if(isset($_SERVER['HTTP_PROFILE']))  
      $mobile_browser++;  
     $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));  
     $mobile_agents = array(  
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',  
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',  
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',  
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',  
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',  
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',  
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',  
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',  
        'wapr','webc','winw','winw','xda','xda-'
        );  
     if(in_array($mobile_ua, $mobile_agents))  
      $mobile_browser++;  
     if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)  
      $mobile_browser++;  
     // Pre-final check to reset everything if the user is on Windows  
     if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)  
      $mobile_browser=0;  
     // But WP7 is also Windows, with a slightly different characteristic  
     if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)  
      $mobile_browser++;  
     if($mobile_browser>0)  
      return true;  
     else
      return false;
} 



/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 * @return object
 */
function array_to_object($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array_to_object($v);
        }
    }
 
    return (object)$arr;
}
 
/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
 
    return $obj;
}

function replace_sprit($str){
    $str = str_replace("/","乄",$str);
    return str_replace("\"","'",$str);
}

function model_exchange($model){
    $arr = array_map("ucfirst",explode('_', $model));
    $str = '';
    foreach ($arr as $key=>$value) {
      $str.=$value;
    }
    return $str;
}

function play_file($file,$name){
    $arr_file = array();
    $count = count($file['name']);
    for($i=0;$i<$count;$i++){
        if($file['name'][$i]){
            $arr_file[$name][$i]['name'] = $file['name'][$i];
            $arr_file[$name][$i]['type'] = $file['type'][$i];
            $arr_file[$name][$i]['tmp_name'] = $file['tmp_name'][$i];
            $arr_file[$name][$i]['error'] = $file['error'][$i];
            $arr_file[$name][$i]['size'] = $file['size'][$i]; 
        }  
    }
    return $arr_file;
}

//获取文件扩展名
function get_extension($file){ 
    return substr(strrchr($file, '.'), 1); 
} 

function checkuc($file){
    foreach ($file as $key => $value) {
        if (preg_match("/[\x7f-\xff]/", $value['name'])) {  //判断字符串中是否有中文
            return false;
        }
    }
    return true;
}
