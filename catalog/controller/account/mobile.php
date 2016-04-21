<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/21
 * Time: 15:23
 */
class ControllerAccountMobile extends Controller {
    //登录验证
    protected function init() {
        $cur_url = get_url();

        //未登录跳转到登录页面
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $cur_url;

            $this->response->redirect($this->url->link('account/login', 'redirect='. urlencode($cur_url), 'SSL'));
        }
    }
    public function index() {
        $this->init();

        $data_page['meta_title'] = '重新绑定手机号 - ' . $this->config->get('config_name');

        //个人资料
        $this->load->model('account/customer');
        $data = $this->model_account_customer->getCustomer($this->customer->getId());
        $customer = array(
            'nick_name' => $data['nick_name'],
            'level' => $this->model_account_customer->getLevel($data),
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'picture' => HTTP_SERVER . 'upload/'. $data['picture']
        );
        $data_page['customer'] = json_encode($customer, JSON_UNESCAPED_SLASHES);

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $random = trim($this->request->post['random']);
            if ($this->session->data['code_change'] != $random) {
                output_error('短信验证码错误！');
            }

            $mobile = $this->request->post['mobile'];
            $customer['mobile'] = $mobile;
            if (empty($data['nick_name'])) {
                $customer['nick_name'] = cover_telephone($mobile);
            }

            $this->model_account_customer->editCustomer($customer);
            unset($this->session->data['code_change']);
            output_success("修改成功");
        }

        //开始生成面包屑
        $breadcrumbs[] = array(
            'name' => '首页',
            'link' => $this->config->get('config_url')
        );
        $breadcrumbs[] = array(
            'name' => '账户中心',
            'link' => $this->url->link_static('account/home')
        );
        $breadcrumbs[] = array(
            'name' => '重新绑定手机号',
            'link' => $this->url->link_static('account/mobile')
        );

        $data_page['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);


        //广告加载
        $this->load->model('design/banner');
        //顶部广告
        $data_page['data_banner'] = $this->model_design_banner->banner_to_json(18);

        //绑定网址
        $data_page['url_sms_random'] = $this->url->link('account/register/getSmsRandom', '', '');;
        $data_page['url_submit'] = $this->url->link_simple('account/mobile');

        $this->response->setOutput($this->load->view('customer_bindMobile.html', $data_page));
    }

    //发送短信
    public function getSmsRandom() {
        $mobile = trim($this->request->get['mobile']);

        if (is_mobile($mobile) == false) {
            output_error("电话号码必须11位数");
        }

        $this->load->helper("sms");
        $code = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
        $this->session->data['code_change'] = $code;
        $pars = array(
            "code" => $code,
            "product" => $this->config->get('config_name')
        );
        $result = send_sms($mobile, $pars, SMS_TPL_CHANGE_MOBILE, date("Y-m-d H:i:s"));
        if ($result) {
            if ($result->success) {

            }
        }
        output_success("验证码发送成功！");
        //$this->session->data['payment_address'] =
    }
}