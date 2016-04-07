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
        "success" => true,
        "message" => $msg
    );
    echo json_encode($data);
    exit;
}
//json输出错误信息
function output_error($msg) {
    $data = array(
        "success" => false,
        "message" => $msg
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

function is_mobile($mobile) {
    if(preg_match("/^1\d{10}$/", $mobile)){
        return true;
    }
    return false;
}