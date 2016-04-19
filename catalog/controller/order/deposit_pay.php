<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/18
 * Time: 13:58
 */
class ControllerOrderDepositPay extends Controller
{
    public function index()
    {
        $data['meta_title'] = '付定金 - ' . $this->config->get('config_name');

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

        $breadcrumbs = $this->model_catalog_product->getBreadcrumbs($product_id);

        $breadcrumbs[] = array(
            'name' => '付定金',
            'link' => 'javascript:void(0)'
        );

        $data['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);


        $this->response->setOutput($this->load->view('pay.html', $data));
    }
}