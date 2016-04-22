<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/19
 * Time: 9:45
 */
class ControllerOrderOrder extends Controller {
    //登录验证
    protected function init() {
        $cur_url = get_url();

        //未登录跳转到登录页面
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $cur_url;

            $this->response->redirect($this->url->link('account/login', 'redirect='. urlencode($cur_url), 'SSL'));
        }

        $this->load->model('catalog/product');
        $this->load->model('order/order');
        $this->load->model('order/order_product');
        $this->load->model('order/order_file');
        $this->load->model('order/order_history');
        $this->load->model('order/order_status');

    }
    //第一步订金表单
    public function depositForm() {
        $this->init();

        $data['meta_title'] = '提交订单 - ' . $this->config->get('config_name');

        $product_id = (int)$this->request->get['product_id'];

        $product_info = $this->model_catalog_product->getProduct($product_id);

        //根据商品类型查询定金
        $deposit = $this->model_catalog_product->getDepositByCategory($product_info['master_category_id']);

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $order_no = initOrderNo(11);

            $order = array(
                'order_no'   => $order_no,
                'order_name' => $product_info['name'],
                'order_status_id' => $this->model_order_order_status->getOrderStatusByKey('no_deposit'),//1表示待付项目预付款
                'customer_id' => $this->customer->getId(),
                'customer_group_id' => $this->customer->getGroupId(),
                'invoice_prefix'    => $this->config->get('config_invoice_prefix'),
                'store_id'           => $this->config->get('config_store_id'),
                'store_name'        => $this->config->get('config_name'),
                'store_url'         => $this->config->get('config_url'),
                'exhibition_area_code' => $this->request->post['exhibition_area_code'],
                'exhibition_address' => '',
                'designer_id' => $product_info['customer_id'],
                'contact_name'  => $this->request->post['contact_name'],
                'contact_mobile' => $this->request->post['contact_mobile'],
                'contact_qq' => $this->request->post['contact_qq'],
                'main_product_id' => $product_id,
                'payment_method' => '银行转账',//支付没通，先默认这2个
                'payment_code' => 'bank_transfer',//支付没通，先默认这2个
                'language_id' => 2,//中文
                'currency_id' => 2,//人民币
                'currency_code' => $this->config->get('config_currency'),
                'deposit' => $deposit,
                'total' => 0,//0表示价格待定
                'date_added' => date('Y-m-d H:i:s'),
                'date_modified' => date('Y-m-d H:i:s')
            );

            $order_id = $this->model_order_order->addOrderStep1($order);

            $order_product = array(
                'order_id' => $order_id,
                'product_id' => $product_info['product_id'],
                'name' => $product_info['name'],
                'model' => $product_info['model'],
                'quantity' => 1,
                'price' => 0,//没有实际金额
                'total' => 0
            );

            $this->model_order_order_product->addOrderProduct($order_product);

            //echo '添加订单成功';exit;
            //$this->session->data['order_no']

            //记录订单历史
            $order_history = array(
                'order_id' => $order_id,
                'user_id' => 0,//0表示，客户自己
                'order_status_id' => $this->model_order_order_status->getOrderStatusByKey('no_deposit'),
                'title'         => '下单成功',
                'date_added'   => date('Y-m-d H:i:s')
            );
            $this->model_order_order_history->addOrderHistory($order_history);

            $json = array(
                'suc' => true,
                'msg' => '订单创建成功',
                'data' => str_replace('&amp;', '&', $this->url->link('order/order/depositPay', 'order_no='. $order_no, 'SSL'))
            );

            echo json_encode($json, JSON_UNESCAPED_SLASHES);exit;

            //$this->response->redirect($this->url->link('order/order/depositPay', 'order_no='. $order_no, 'SSL'));
        }

        $this->load->model('tool/image');

        $data_product_info[] = array(
            'product_id' => $product_info['product_id'],
            'product_name' => $product_info['name'],
            'price' => $deposit,//$product_info['price'],
            'image' => $this->model_tool_image->resize($product_info['image'], 190, 110),
        );

        $data['product_info'] = json_encode($data_product_info, JSON_UNESCAPED_SLASHES);

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
        $data['url_ajax_submit'] = $this->url->link('order/order/depositForm', 'product_id='. $product_id, 'SSL');

        //广告加载
        $this->load->model('design/banner');
        $data['data_banner'] = $this->model_design_banner->banner_to_json(16);

        $this->response->setOutput($this->load->view('submit.html', $data));
    }
    //第二步订金表单，必须要已支付完订金才能进入该页面
    public function depositPay() {
        $this->init();

        $order_no = $this->request->get['order_no'];

        $data['meta_title'] = '项目预付款 - ' . $this->config->get('config_name');

        $order_info = $this->model_order_order->getOrderByNo($order_no);

        if (empty($order_info)) {
            output_error("该订单号不存在");
        }

        $product_id = $order_info['main_product_id'];

        $url = $this->url->link('order/order/depositForm', 'product_id='. $product_id, 'SSL');
        $url = str_replace('&amp;', '&', $url);

        //未登录跳转到登录页面
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $url;

            $this->response->redirect($this->url->link('account/login', 'redirect='. urlencode($url), 'SSL'));
        }

        $product_info = $this->model_catalog_product->getProduct($product_id);

        //根据商品类型查询定金
        $deposit = $this->model_catalog_product->getDepositByCategory($product_info['master_category_id']);

        $breadcrumbs = $this->model_catalog_product->getBreadcrumbs($product_id);

        $breadcrumbs[] = array(
            'name' => '付定金',
            'link' => 'javascript:void(0)'
        );

        $data['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);

        //广告加载
        $this->load->model('design/banner');
        $data['data_banner'] = $this->model_design_banner->banner_to_json(16);


        $info = array(
            'order_name' => $order_info['order_name'],
            'order_no' => $order_info['order_no'],
            'deposit_price' => $deposit,
            'payment_method' => '支付宝即时到帐',
            'payment_code' => 'alipay_direct',
            'alipay_seller_email' => '123@123.com'
        );

        $data['info'] = json_encode($info, JSON_UNESCAPED_SLASHES);
        //{"order_name":"xxx","order_no":"xxxxxxx","deposit_price":"1000","payment_mothod":"zhifubao","payment_code":"11111","alipay_seller_email":"234234234"}

        $this->response->setOutput($this->load->view('pay.html', $data));
    }
    //3、第三步订单详细表单填写
    public function orderForm() {
        $this->init();

        $order_no = $this->request->get['order_no'];

        $this->load->model('order/order');
        $this->load->model('order/order_file');
        $this->load->model('order/order_history');

        $order_info = $this->model_order_order->getOrderByNo($order_no);

        if (empty($order_info)) {
            echo "订单号不存在";exit;
        }

        //订单状态必须是已经付了订金的才能进行该操作
        if ($order_info['order_status_id'] != $this->model_order_order_status->getOrderStatusByKey('deposit_no_form')) {
            echo "订单状态不能执行当前操作";exit;
        }

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->orderFormValidate()) {

            $order_form = array(
                'order_status_id' => $this->model_order_order_status->getOrderStatusByKey('validating'),//表单填写完成，沟通确认需求
                'exhibition_subject'    => $this->request->post['exhibition_subject'],
                'length'                  => (int)$this->request->post['length'],
                'width'                   => (int)$this->request->post['width'],
                'height'                  => (int)$this->request->post['height'],
                'area'                    => (int)$this->request->post['area'],
                'is_squareness'         => (int)$this->request->post['is_squareness'],
                'exhibition_verify_date' => $this->request->post['exhibition_verify_date'],
                'exhibition_enter_date'  => $this->request->post['exhibition_enter_date'],
                'exhibition_begin_date'  => $this->request->post['exhibition_begin_date'],
                'exhibition_leave_date'  => $this->request->post['exhibition_leave_date'],
                'remark'                    => $this->request->post['remark']
            );

            $this->model_order_order->completeOrder($order_form, $order_no);

            //记录订单历史
            $order_history = array(
                'order_id' => $order_info['order_id'],
                'user_id' => 0,//0表示，客户自己
                'order_status_id' => $this->model_order_order_status->getOrderStatusByKey('validating'),//表单填写完成，沟通确认需求
                'title'         => '下单成功',
                'date_added'   => date('Y-m-d H:i:s')
            );
            $this->model_order_order_history->addOrderHistory($order_history);

            $json = array(
                'suc' => true,
                'msg' => '订单：' . $order_no . '保存成功',
                'data' => str_replace('&amp;', '&', $this->url->link('order/order/orderInfo', 'order_no='. $order_no, 'SSL'))
            );

            echo json_encode($json, JSON_UNESCAPED_SLASHES);exit;
        }

        $data['meta_title'] = '完善订单信息 - ' . $this->config->get('config_name');

        $order_form = array(
            'exhibition_subject'    => strval($order_info['exhibition_subject']),
            'length'                  => $order_info['length'] == 0 ? "" : $order_info['length'],
            'width'                   => $order_info['width'] == 0 ? "" : $order_info['width'],
            'height'                  => $order_info['height'] == 0 ? "" : $order_info['height'],
            'area'                    => $order_info['area'] == 0 ? "" : $order_info['area'],
            'is_squareness'         => intval($order_info['is_squareness']),
            'exhibition_verify_date' => strval($order_info['exhibition_verify_date']),
            'exhibition_enter_date'  => strval($order_info['exhibition_enter_date']),
            'exhibition_begin_date'  => strval($order_info['exhibition_begin_date']),
            'exhibition_leave_date'  => strval($order_info['exhibition_leave_date']),
            'remark'                    => strval($order_info['remark']),
            'files' => array()
        );

        $files = $this->model_order_order_file->getOrderFiles($order_info['order_id']);
        foreach($files as $file) {
            $order_form['files'][] = array(
                'file_id' => $file['upload_id'],
                'file_name' => $file['name'],
                'size'  => format_bytes($file['size']),
                'delete_url' => $this->url->link_simple('order/order_file/delete', 'upload_id=' . $file['upload_id'], ''),
                'url' => ''
            );
        }

        $data['order'] = json_encode($order_form, JSON_UNESCAPED_SLASHES);

        //上传地址
        $data['url_upload'] = $this->url->link('order/order_file/upload', 'order_id='. $order_info['order_id'], 'SSL');

        //提交订单
        $data['url_ajax_submit'] = $this->url->link('order/order/orderForm', 'order_no='. $order_no, 'SSL');

        $this->response->setOutput($this->load->view('writepayform.html', $data));
    }

    protected function orderFormValidate() {
        $order_no = $this->request->get['order_no'];

        $order_info = $this->model_order_order->getOrderByNo($order_no);

        if (empty($order_info)) {
            echo "订单号不存在";exit;
        }

        //订单状态必须是已经付了订金的才能进行该操作
        if ($order_info['order_status_id'] != $this->model_order_order_status->getOrderStatusByKey('deposit_no_form')) {
            echo "订单状态不能执行当前操作";exit;
        }

        $order_form = array(
            'exhibition_subject' => $this->request->post['exhibition_subject'],
            'length' => (int)$this->request->post['length'],
            'width' => (int)$this->request->post['width'],
            'height' => (int)$this->request->post['height'],
            'area' => (int)$this->request->post['area'],
            'is_squareness' => (int)$this->request->post['is_squareness'],
            'exhibition_verify_date' => $this->request->post['exhibition_verify_date'],
            'exhibition_enter_date' => $this->request->post['exhibition_enter_date'],
            'exhibition_begin_date' => $this->request->post['exhibition_begin_date'],
            'exhibition_leave_date' => $this->request->post['exhibition_leave_date'],
            'remark' => $this->request->post['remark']
        );

        if (strlen($order_form['exhibition_subject']) < 3) {
            output_error('展会主题太短');
        }
        if (!is_numeric($order_form['length'])) {
            output_error('长度只能为数字');
        }
        if (!is_numeric($order_form['width'])) {
            output_error('宽度只能为数字');
        }
        if (!is_numeric($order_form['height'])) {
            output_error('高度只能为数字');
        }
        if (!is_numeric($order_form['area'])) {
            output_error('面积只能为数字');
        }
        if (!is_date($order_form['exhibition_verify_date'])) {
            output_error('日期格式不对');
        }
        if (!is_date($order_form['exhibition_enter_date'])) {
            output_error('日期格式不对');
        }
        if (!is_date($order_form['exhibition_begin_date'])) {
            output_error('日期格式不对');
        }
        if (!is_date($order_form['exhibition_leave_date'])) {
            output_error('日期格式不对');
        }
        return true;
    }
    //4、确认订单
    public function orderInfo() {
        $order_no = $this->request->get['order_no'];

        $order_info = $this->model_order_order->getOrderByNo($order_no);

        if (empty($order_info)) {
            echo "订单号不存在";exit;
        }

        //订单状态必须是已经付了订金的才能进行该操作
        if ($order_info['order_status_id'] != $this->model_order_order_status->getOrderStatusByKey('deposit_no_form')) {
            echo "订单状态不能执行当前操作";exit;
        }

        $data['meta_title'] = '确认订单信息 - ' . $this->config->get('config_name');

        //echo '<pre>';print_r($order_info);exit;

        $order_form = array(
            'exhibition_subject'    => $order_info['exhibition_subject'],
            'length'                  => $order_info['length'] == 0 ? "" : $order_info['length'],
            'width'                   => $order_info['width'] == 0 ? "" : $order_info['width'],
            'height'                  => $order_info['height'] == 0 ? "" : $order_info['height'],
            'area'                    => $order_info['area'] == 0 ? "" : $order_info['area'],
            'is_squareness'         => $order_info['is_squareness'],
            'is_squareness_name'     => radioName($order_info['is_squareness']),
            'exhibition_verify_date' => $order_info['exhibition_verify_date'],
            'exhibition_enter_date'  => $order_info['exhibition_enter_date'],
            'exhibition_begin_date'  => $order_info['exhibition_begin_date'],
            'exhibition_leave_date'  => $order_info['exhibition_leave_date'],
            'remark'                    => $order_info['remark'],
            'files' => array()
        );

        $files = $this->model_order_order_file->getOrderFiles($order_info['order_id']);
        foreach($files as $file) {
            $order_form['files'][] = array(
                'file_id' => $file['upload_id'],
                'file_name' => $file['name'],
                'size'  => format_bytes($file['size'])
            );
        }

        $data['order'] = json_encode($order_form, JSON_UNESCAPED_SLASHES);

        //返回修改
        //$data['url_back'] = str_replace('&amp;', '&', $this->url->link('order/order/orderForm', 'order_no='. $order_no, 'SSL'));
        $data['url_back'] = $this->url->link('order/order/orderForm', 'order_no='. $order_no, 'SSL');

        $this->response->setOutput($this->load->view('makesureOrder.html', $data));
    }
}