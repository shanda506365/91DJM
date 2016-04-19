<?php
class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');

        if ($this->customer->isLogged()) {
            //$this->response->redirect($this->url->link_static('account/account', '', 'SSL'));
            $this->response->redirect(HTTP_SERVER);
        }

        $data['meta_title'] = '登录 - ' . $this->config->get('config_name');

        //广告加载
        $this->load->model('design/banner');
        $data['data_banner'] = $this->model_design_banner->banner_to_json(14);

        //获取短信验证码的网址
        $data['url_login'] = $this->url->link('account/login/doLogin', '', 'SSL');

        $this->response->setOutput($this->load->view('login.html', $data));

	}

    public function doLogin() {
        $this->load->model('account/customer');

        $mobile = trim($this->request->post['mobile']);

        if (is_mobile($mobile) == false) {
            output_error("电话号码必须11位数！");
        }

        if ($this->model_account_customer->getTotalCustomersByMobile($this->request->post['mobile']) == 0) {
            output_error("该手机号的用户不存在！");
        }

        $password = trim($this->request->post['password']);
        if ((utf8_strlen($password) < 6) || (utf8_strlen($password) > 20)) {
            output_error('密码必须是 6 至 20 字符之间！');
        }

        if (!$this->customer->login($mobile, $password)) {

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

        $data = array(
            "suc" => true,
            "msg" => '登录成功',
            "data" => isset($this->session->data['redirect']) ? $this->session->data['redirect'] : HTTP_SERVER
        );

        unset($this->session->data['redirect']);

        echo json_encode($data);
    }
}
