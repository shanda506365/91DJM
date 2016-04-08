<?php
class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');


        //广告加载
        $this->load->model('design/banner');
        $data['data_banner'] = $this->model_design_banner->banner_to_json(14);

        //获取短信验证码的网址
        $data['url_random'] = $this->url->link('account/login/getSmsRandom', '', 'SSL');
        $data['url_register'] = $this->url->link('account/login/doLogin', '', 'SSL');

        $this->response->setOutput($this->load->view('login.html', $data));

	}

    public function getSmsRandom() {
        $mobile = trim($this->request->get['mobile']);

        if (is_mobile($mobile) == false) {
            output_error("电话号码必须11位数");
        }

        $this->load->helper("sms");
        $code = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
        $this->session->data['login_code'] = $code;
        $pars = array(
            "code" => $code,
            "product" => "搭积木"
        );
        $result = send_sms($mobile, $pars, SMS_TPL_REGISTER, date("Y-m-d H:i:s"));
        if ($result) {
            if ($result->success) {

            }
        }
        output_success("验证码发送成功！");
        //$this->session->data['payment_address'] =
    }

    public function doLogin() {
        $this->load->model('account/customer');

        $mobile = trim($this->request->get['mobile']);

        if (is_mobile($mobile) == false) {
            output_error("电话号码必须11位数！");
        }

        if ($this->model_account_customer->getTotalCustomersByMobile($this->request->post['mobile'])) {
            output_error("该手机号已被注册！");
        }

        // Customer Group
        if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $this->request->post['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $password = trim($this->request->post['password']);
        if ((utf8_strlen($password) < 6) || (utf8_strlen($password) > 20)) {
            output_error('密码必须是 6 至 20 字符之间！');
        }

        $confirm = trim($this->request->post['confirm']);
        if ($confirm != $password) {
            output_error('两次输入的密码不同！');
        }

        $random = trim($this->request->post['random']);
        if ($this->session->data['register_code'] != $random) {
            output_error('短信验证码错误！');
        }

        $data = array(
            'customer_group_id' => $customer_group_id,
            'mobile'    => $mobile,
            'password' => $password
        );

        $customer_id = $this->model_account_customer->addCustomer($data);

        if (!$this->customer->login($mobile, $this->request->post['password'])) {

            $this->model_account_customer->addLoginAttempt($mobile);

            output_error("帐号密码有误！");

        } else {
            $this->model_account_customer->deleteLoginAttempts($mobile);
        }

        // Add to activity log
        $this->load->model('account/activity');

        $activity_data = array(
            'customer_id' => $this->customer->getId(),
            'name'        => $this->customer->getMobile()
        );

        $this->model_account_activity->addActivity('login', $activity_data);

        unset($this->session->data['login_code']);

        output_success("注册成功！");
    }
}
