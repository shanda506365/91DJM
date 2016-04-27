<?php
function token($length = 32) {
	// Create token to login with
	$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$token = '';
	
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, strlen($string) - 1)];
	}	
	
	return $token;
}
//生成系统订单号
function initOrderNo($length = 11) {
    return date('ymd').rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
}
/*
 * 集成codeIgniter的数据访问类，数据库错误显示，需要用到该函数
 * */
function log_message($level = 'error', $message, $php_error = FALSE)
{
    if ($level == 'error') {
        echo($message);
    }
    $handle = fopen(DIR_LOGS . 'error_sql.log', 'a');
    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
    fclose($handle);
}
//电话号码隐藏中间4位
function cover_telephone($telephone) {
    $return = trim($telephone);
    if (strlen($telephone) == 11) {
        $return = substr($telephone, 0, 3) . '****' . substr($telephone, 7, 4);
    }
    return $return;
}
//json输出
function output_json($arr) {
    echo json_encode($arr);
    exit;
}
//json输出成功信息
function output_success($msg) {
    $data = array(
        "suc" => true,
        "msg" => $msg
    );
    echo json_encode($data);
    exit;
}
//json输出错误信息
function output_error($msg) {
    $data = array(
        "suc" => false,
        "msg" => $msg
    );
    echo json_encode($data);
    exit;
}
//短信日志
function log_sms($message)
{
    $handle = fopen(DIR_LOGS . 'error_sms.log', 'a');
    fwrite($handle, date('Y-m-d H:i:s') . ' - ' . print_r($message, true) . "\n");
    fclose($handle);
}
//验证手机号
function is_mobile($mobile) {
    if(preg_match("/^1\d{10}$/", $mobile)){
        return true;
    }
    return false;
}
//验证日期
function is_date($str) {
    $is_date = strtotime($str) ? strtotime($str) : false;
    if( $is_date === false) {
        return false;
    }
    return true;
}
//文件大小格式，直观显示
function format_bytes($size) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}
//得到文件后缀
function get_extension($file){
//    if (is_file($file)) {
//        return pathinfo($file, PATHINFO_EXTENSION);
//    }
//    return false;
    return substr($file, strrpos($file, '.') + 1);
}
//得到当前完整url
function get_url(){
    $url = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'];
    $url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : urlencode($_SERVER['PHP_SELF']) . '?' . urlencode($_SERVER['QUERY_STRING']);
    return $url;
}
//单选的文本显示
function radioName($type = 1) {
    if ($type == 1) {
        return '是';
    } else {
        return '否';
    }
}
//对象转数组
function objectToArray($e){
    $e=(array)$e;
    foreach($e as $k=>$v){
        if( gettype($v)=='resource' ) return;
        if( gettype($v)=='object' || gettype($v)=='array' )
            $e[$k]=(array)objectToArray($v);
    }
    return $e;
}