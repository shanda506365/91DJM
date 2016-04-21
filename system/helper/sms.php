<?php
define("SMS_TPL_REGISTER", "SMS_7225793");//注册短信模版，必须在 http://www.alidayu.com/admin/service/tpl 存在
define("SMS_TPL_CHANGE_MOBILE", "SMS_8215243");//用户变更手机号码发送的短信模版

define("SMS_SIGN", "91搭积木");//签名，必须在 http://www.alidayu.com/admin/service/sign 存在

/*
 * stdClass Object
(
    [result] => stdClass Object
        (
            [err_code] => 0
            [model] => 101099859855^1101579226917
            [success] => 1
        )
    [request_id] => z28diyi5odne
)
 * */
function send_sms($mobile, $pars, $tpl, $extend = "") {
    include dirname(__FILE__)."/../../system/library/aliyun/TopSdk.php";
    $c = new TopClient;
    $c->format = "json";
    $c->appkey = SMS_APPKEY;
    $c->secretKey = SMS_SECRET;
    $req = new AlibabaAliqinFcSmsNumSendRequest;
    $req->setExtend($extend);//传入改值，能够在查询短信列表的接口，得到该值，比如客户ID
    $req->setSmsType("normal");
    $req->setSmsFreeSignName(SMS_SIGN);//"搭积木"
    $req->setSmsParam(json_encode($pars));//{\"code\":\"123456\",\"product\":\"搭积木\"}
    if (is_array($mobile)) {
        $req->setRecNum(implode(",", $mobile));
    } else {
        $req->setRecNum($mobile);
    }
    $req->setSmsTemplateCode($tpl);//"SMS_7225793"  模版
    $resp = $c->execute($req);
//    echo '<pre>';
//    print_r($resp);
//如果有错误
//    stdClass Object
//    (
//        [code] => 15
//    [msg] => Remote service error
//    [sub_code] => isv.BUSINESS_LIMIT_CONTROL
//    [sub_msg] => 触发业务流控
//    [request_id] => r4l9wpv0j4f3
//)
    //记录错误日志
    if (property_exists($resp, "code")) {
        log_sms($mobile . " : " . $resp->code . " : " . $resp->msg);
        return false;
    } else {
        return $resp->result;
    }
}

/*
 * stdClass Object
(
    [current_page] => 1
    [page_size] => 10
    [total_count] => 3
    [total_page] => 1
    [values] => stdClass Object
        (
            [fc_partner_sms_detail_dto] => Array
                (
                    [0] => stdClass Object
                        (
                            [extend] => 111
                            [rec_num] => 18048505035
                            [result_code] => DELIVRD
                            [sms_code] => SMS_7225793
                            [sms_content] => 【搭积木】验证码******，您正在注册成为**搭积木用户，感谢您的支持！
                            [sms_receiver_time] => 2016-04-06 10:07:42
                            [sms_send_time] => 2016-04-06 10:07:36
                            [sms_status] => 3
                        )

                    [1] => stdClass Object
                        (
                            [extend] => michaelzhouh
                            [rec_num] => 18048505035
                            [result_code] => DELIVRD
                            [sms_code] => SMS_7225793
                            [sms_content] => 【搭积木】验证码******，您正在注册成为**搭积木用户，感谢您的支持！
                            [sms_receiver_time] => 2016-04-06 10:02:09
                            [sms_send_time] => 2016-04-06 10:01:59
                            [sms_status] => 3
                        )
                )
        )
    [request_id] => 10fk1u2fwpryn
)
 */
function query_sms_list($mobile, $date, $page = 1, $page_size = 10) {
    include dirname(__FILE__)."/../../system/library/aliyun/TopSdk.php";
    $c = new TopClient;
    $c->format = "json";
    $c->appkey = SMS_APPKEY;
    $c->secretKey = SMS_SECRET;
    $req = new AlibabaAliqinFcSmsNumQueryRequest;
    //$req->setBizId("1234^1234");//流水，可以为空
    $req->setRecNum($mobile);//电话号码
    $req->setQueryDate($date);//日期 date("Ymd")
    $req->setCurrentPage($page);
    $req->setPageSize($page_size);
    $resp = $c->execute($req);
//    echo '<pre>';
//    print_r($resp);
    return $resp;
}