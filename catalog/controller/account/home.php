<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/21
 * Time: 9:48
 */
class ControllerAccountHome extends Controller
{
    //登录验证
    protected function check_login() {
        $cur_url = get_url();

        //未登录跳转到登录页面
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $cur_url;

            $this->response->redirect($this->url->link('account/login', 'redirect='. urlencode($cur_url), 'SSL'));
        }
    }

    public function index()
    {
        $this->check_login();

        $data['meta_title'] = '账户中心 - ' . $this->config->get('config_name');

        //开始生成面包屑
        $breadcrumbs[] = array(
            'name' => '首页',
            'link' => $this->config->get('config_url')
        );
        $breadcrumbs[] = array(
            'name' => '账户中心',
            'link' => $this->url->link_static('account/home')
        );

        $data['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);


        //广告加载
        $this->load->model('design/banner');
        $data['data_banner'] = $this->model_design_banner->banner_to_json(18);

        $this->response->setOutput($this->load->view('customer_home.html', $data));
    }
}