<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/15
 * Time: 13:36
 */
class ControllerOrderStep1 extends Controller {
    public function index() {

        $data['meta_title'] = '提交订单 - ' . $this->config->get('config_name');

        $product_id = (int)$this->request->get['product_id'];

        $url = $this->url->link('order/step1', 'product_id='. $product_id, 'SSL');

        //未登录跳转到登录页面
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $url;

            $this->response->redirect($this->url->link('account/login', 'redirect='. urlencode($url), 'SSL'));
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        //根据商品类型查询定金
        $deposit = $this->model_catalog_product->getDepositByCategory($product_info['master_category_id']);

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('order/order');

            $order_no = initOrderNo(11);

            $data = array(
                'order_name' => $product_info['name'],
                'order_no'   => $order_no,
                'order_status_id' => 1,//1表示未付订金
                'customer_id' => $this->customer->getId(),
                'customer_group_id' => $this->customer->getGroupId(),
                'invoice_prefix'    => $this->config->get('config_invoice_prefix'),
                'store_id'           => $this->config->get('config_store_id'),
                'store_name'        => $this->config->get('config_name'),
                'store_url'         => $this->config->get('config_url'),
                'exhibition_area_code' => $this->request->post['exhibition_area_code'],
                'contact_name'  => $this->request->post['contact_name'],
                'contact_mobile' => $this->request->post['contact_mobile'],
                'contact_qq' => $this->request->post['contact_qq'],
                'product_id' => $product_id,
                'product_name' => $product_info['name'],
                'product_model' => $product_info['model'],
                'quantity' => 1,
                'price' => $deposit,
                'total' => $deposit
            );

            $this->model_order_order->addOrderStep1($data);

            //echo '添加订单成功';exit;
            //$this->session->data['order_no']

            $this->response->redirect($this->url->link('order/step2', 'order_no='. $order_no, 'SSL'));
        }

        $this->load->model('tool/image');

        $data_product_info[] = array(
            'product_id' => $product_info['product_id'],
            'product_name' => $product_info['name'],
            'price' => $deposit,//$product_info['price'],
            'image' => $this->model_tool_image->resize($product_info['image'], 190, 110),
        );

        $data['product_info'] = json_encode($data_product_info, JSON_UNESCAPED_SLASHES);

        //开始生成面包屑
//        $breadcrumbs[] = array(
//            'name' => '首页',
//            'link' => '/'
//        );
//
//        $master_category_id = $product_info['master_category_id'];
//
//        $this->load->model('catalog/category');
//
//        $master_category = $this->model_catalog_category->getCategory($master_category_id);
//
//        $breadcrumbs[] = array(
//            'name' => $master_category['name'],
//            'link' => '/product/list/' . $master_category_id
//        );
//
//        $breadcrumbs[] = array(
//            'name' => $product_info['name'],
//            'link' => '/product/' . $product_info['product_id'] . '.html'
//        );
        $breadcrumbs = $this->model_catalog_product->getBreadcrumbs($product_id);

        $breadcrumbs[] = array(
            'name' => '提交订单',
            'link' => 'javascript:void(0)'
        );

        $data['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);

        //我要下单
        $data['url_area'] = $this->url->link('api/area', '', 'SSL');

        $this->load->model('tool/area');

        $areas = $this->model_tool_area->getAreasByParentCode('510000');//四川省

        $temp = array();

        foreach($areas as $area) {
            $temp[] = array(
                'area_code' => $area['area_code'],
                'area_name' => $area['area_name']
            );
        }

        $json = array(
            'suc' => true,
            'msg' => '',
            'data' => $temp,
            'code' => ''
        );

        $data['data_default_city'] = json_encode($json, JSON_UNESCAPED_SLASHES);

        //加入收藏夹
        $data['url_ajax_collect'] = $this->url->link('account/wishlist/add', '', '');
        //提交订单
        $data['url_ajax_submit'] = $this->url->link('order/step1', 'product_id='. $product_id, 'SSL');

        $this->response->setOutput($this->load->view('submit.html', $data));
    }
}