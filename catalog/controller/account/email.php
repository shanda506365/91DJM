<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/21
 * Time: 14:49
 */
class ControllerAccountEmail extends Controller {
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

        $data_page['meta_title'] = '绑定邮箱 - ' . $this->config->get('config_name');

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
            $email = $this->request->post['email'];
            $data['email'] = $email;

            $this->model_account_customer->editCustomer($data);
            output_success("邮箱绑定成功");
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
            'name' => '绑定邮箱',
            'link' => $this->url->link_static('account/email')
        );

        $data_page['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);


        //广告加载
        $this->load->model('design/banner');
        //顶部广告
        $data_page['data_banner'] = $this->model_design_banner->banner_to_json(18);

        //提交修改
        $data_page['url_submit'] = $this->url->link_simple('account/email');

        $this->response->setOutput($this->load->view('customer_bindMail.html', $data_page));
    }
}