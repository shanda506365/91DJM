<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/26
 * Time: 9:49
 */
class ControllerSaleOrderDesign extends Controller {
    private $error = array();

    public function index() {
        $order_id = (int)$this->request->get['order_id'];
        $order_design_id = (int)$this->request->get['order_design_id'];




        $this->getForm();
    }

    public function add() {
        $order_id = (int)$this->request->get['order_id'];

        $this->document->setTitle('添加设计方案');

        $this->load->model('sale/order_design');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $order_design = array(
                'order_id' => $this->request->get['order_id'],
                'title' => $this->request->post['title'],
                'description'  => $this->request->post['description'],
                'date_added' => date('Y-m-d H:i:s')
            );

            $this->model_sale_order_design->addOrderDesign($order_design);

            $this->session->data['success'] = '添加成功';

            $url = '&order_id=' . $order_id;

            $this->response->redirect($this->url->link('sale/order_design', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit() {

        $order_id = (int)$this->request->get['order_id'];
        $order_design_id = (int)$this->request->get['order_design_id'];

        $this->document->setTitle('编辑设计方案');

        $this->load->model('order/order_design');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $order_design = array(
                'order_id' => $this->request->get['order_id'],
                'title' => $this->request->post['title'],
                'description'  => $this->request->post['description']
            );

            $this->model_order_order_design->updateOrderDesign($order_design_id, $order_design);

            $this->session->data['success'] = '修改成功';

            $url = '&order_id=' . $order_id;

            $this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {

        $order_id = (int)$this->request->get['order_id'];
        $order_design_id = (int)$this->request->get['order_design_id'];

        $this->document->setTitle('删除设计方案');

        $this->load->model('sale/order');
        $this->load->model('sale/order_design');
        $this->load->model('sale/order_design_picture');

        if ($this->validateDelete()) {
            $odp = $this->model_sale_order_design_picture->getOrderDesignPictureByOrderDesign($order_design_id);
            //遍历并依次删除
            foreach($odp as $order_design_picture) {
                $this->model_sale_order_design_picture->deleteOrderDesignPicture($order_design_picture['order_design_picture_id']);
            }
        }

        $url = '&order_id=' . $order_id;

        $this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    protected function getForm() {

        $order_id = (int)$this->request->get['order_id'];
        $order_design_id = (int)$this->request->get['order_design_id'];

        $data['heading_title'] = '查看设计方案';

        $url = '';

        if (isset($this->request->get['order_id'])) {
            $url .= '&order_id=' . $this->request->get['order_id'];
        }

        if (isset($this->request->get['order_design_id'])) {
            $url .= '&order_design_id=' . $this->request->get['order_design_id'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => '首页',
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => '订单管理',
            'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => '订单详情',
            'href' => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['order_design_id'])) {
            $data['action'] = $this->url->link('sale/order_design/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('sale/order_design/edit', 'token=' . $this->session->data['token'] . '&order_design_id=' . $this->request->get['order_design_id'] . $url, 'SSL');
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['cancel'] = 'javascript:history.back()';

        if (isset($this->request->get['order_design_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $order_designer = $this->model_order_order_design->getOrderDesign($this->request->get['order_design_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif (!empty($order_designer)) {
            $data['title'] = $order_designer['title'];
        } else {
            $data['title'] = '';
        }

        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } elseif (!empty($order_designer)) {
            $data['description'] = $order_designer['description'];
        } else {
            $data['description'] = '';
        }

        if (!empty($order_designer)) {
            $data['date_added'] = $order_designer['date_added'];
        } else {
            $data['date_added'] = date('Y-m-d H:i:s');
        }

        $this->load->model('order/order_design_picture');
        $order_design_pictures = $this->model_order_order_design_picture->getOrderDesignPictureByOrderDesign($order_design_id);


/*
        $this->load->model('tool/image');

        if (isset($this->request->post['option_value'])) {
            $option_values = $this->request->post['option_value'];
        } elseif (isset($this->request->get['option_id'])) {
            $option_values = $this->model_catalog_option->getOptionValueDescriptions($this->request->get['option_id']);
        } else {
            $option_values = array();
        }

        $this->load->model('tool/image');

        $data['option_values'] = array();

        foreach ($option_values as $option_value) {
            if (is_file(DIR_IMAGE . $option_value['image'])) {
                $image = $option_value['image'];
                $thumb = $option_value['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['option_values'][] = array(
                'option_value_id'          => $option_value['option_value_id'],
                'option_value_description' => $option_value['option_value_description'],
                'image'                    => $image,
                'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order'               => $option_value['sort_order']
            );
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
*/
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sale/order_design_form.tpl', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'sale/order_design')) {
            $this->error['warning'] = '没有权限';
        }

        if ($this->request->post['title'] == '') {
            $this->error['title'] = '标题不能为空';
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'sale/order_design')) {
            $this->error['warning'] = '没有权限';
        }

        $this->load->model('sale/order');

        $order_id = (int)$this->request->get['order_id'];
        $order_design_id = (int)$this->request->get['order_design_id'];

        $order_info = $this->model_sale_order->getOrder($order_id);
        if ($order_info) {
            if ($order_info['order_design_id'] == $order_design_id) {//该设计方案已经确认过了，不能修改了
                $this->error['warning'] = '该设计方案已经确认过了，不能修改了';
            }
        }

        return !$this->error;
    }
}