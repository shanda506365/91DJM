<?php
class ControllerAccountForgotpass extends Controller {
    private $error = array();

    public function index() {
        if ($this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->language->load('account/forgotten');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/customer');

        $this->load->language('mail/forgotten');

        $data['meta_title'] = $this->language->get('heading_title') . ' - ' . $this->config->get('config_name');

        //获取短信验证码的网址
        $data['url_random'] = $this->url->link('account/register/getSmsRandom', '', 'SSL');
        $data['url_register'] = $this->url->link('account/register/doRegister', '', 'SSL');

        $this->response->setOutput($this->load->view('forgotpass.html', $data));
    }

    protected function validate() {
        if (!isset($this->request->post['email'])) {
            $this->error['warning'] = $this->language->get('error_email');
        } elseif (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
            $this->error['warning'] = $this->language->get('error_email');
        }

        $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

        if ($customer_info && !$customer_info['approved']) {
            $this->error['warning'] = $this->language->get('error_approved');
        }

        return !$this->error;
    }

    public function getSmsRandom() {
        $mobile = trim($this->request->get['mobile']);

        if (is_mobile($mobile) == false) {
            output_error("电话号码必须11位数");
        }

        $this->load->helper("sms");
        $code = strtolower(token(6));
        $this->session->data['forgotten_code'] = $code;
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

    public function doForgotten() {
        unset($this->session->data['forgotten_code']);
    }
}
