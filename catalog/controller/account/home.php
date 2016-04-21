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
    protected function init() {
        $cur_url = get_url();

        //未登录跳转到登录页面
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $cur_url;

            $this->response->redirect($this->url->link('account/login', 'redirect='. urlencode($cur_url), 'SSL'));
        }
    }

    public function index()
    {
        $this->init();

        $data_page['meta_title'] = '账户中心 - ' . $this->config->get('config_name');

        //个人资料
        $this->load->model('account/customer');
        $data = $this->model_account_customer->getCustomer($this->customer->getId());
        $customer = array(
            'nick_name' => $data['nick_name'],
            'level' => $this->model_account_customer->getLevel($data),
            'mobile' => $data['mobile'],
            'mail' => $data['email'],
            'picture' => HTTP_SERVER . 'upload/'. $data['picture']
        );
        $data_page['customer'] = json_encode($customer, JSON_UNESCAPED_SLASHES);

        //最近订单
        $this->load->model('account/order');
        $this->load->model('order/order_status');
        //最近3条
        $data = $this->model_account_order->getOrders(0, 3);

        $orders = array();
        foreach ($data as $order) {
            //{"order_no":"1111","order_name":"标准化套餐A方案","price":"待定","order_status":"代付定金"

            $order_status = $this->model_order_order_status->getOrderStatusById($order['order_status_id']);

            $orders[] = array(
                'order_id' => $order['order_id'],
                'order_no' => $order['order_no'],
                'order_name' => $order['order_name'],
                'price' => $order['total'],
                'order_status' => $order_status['name'],
                'date_added' => $order['date_added']
            );
        }

        $data_page['orders'] = json_encode($orders, JSON_UNESCAPED_SLASHES);


        //开始生成面包屑
        $breadcrumbs[] = array(
            'name' => '首页',
            'link' => $this->config->get('config_url')
        );
        $breadcrumbs[] = array(
            'name' => '账户中心',
            'link' => $this->url->link_static('account/home')
        );

        $data_page['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);


        //广告加载
        $this->load->model('design/banner');
        //顶部广告
        $data_page['data_banner'] = $this->model_design_banner->banner_to_json(18);
        //中间广告
        $data_page['data_floor'] = $this->model_design_banner->banner_to_json(19);

        $this->response->setOutput($this->load->view('customer_home.html', $data_page));
    }
}