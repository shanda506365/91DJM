<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/19
 * Time: 9:31
 */
class ControllerOrderOrderForm extends Controller
{
    public function index()
    {
        $order_no = (int)$this->request->get['order_no'];


        $data['meta_title'] = '提交订单 - ' . $this->config->get('config_name');

        //提交订单
        $data['url_ajax_submit'] = $this->url->link('order/depositForm', 'product_id='. $product_id, 'SSL');

        $this->response->setOutput($this->load->view('submit.html', $data));
    }
}