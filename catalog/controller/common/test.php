<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/31
 * Time: 8:12
 */
class ControllerCommonTest extends Controller
{
    public function index()
    {
        //$this->response->setOutput($this->load->view('index.html', array()));
//        $this->load->helper("sms");
//        $pars = array(
//            "code" => "123456",
//            "product" => "搭积木"
//        );
//        $result = send_sms("18048505035", $pars, "SMS_7225793", date("Y-m-d"));
//        echo '<pre>';
//        print_r($result);

        echo '<pre>';
        print_r($this->config->get('config_name'));
    }
}