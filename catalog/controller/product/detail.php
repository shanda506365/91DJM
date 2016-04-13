<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/13
 * Time: 10:03
 */
class ControllerProductDetail extends Controller
{
    public function index()
    {
        $data['meta_title'] = '展台产品详情 - ' . $this->config->get('config_name');

        $product_id = (int)$this->request->get['product_id'];

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);


        //广告加载
        $this->load->model('design/banner');
        $data['data_img'] = $this->model_design_banner->banner_to_json(7);

        //分页的网址
//        $data['url_ajax_page'] = $this->url->link('product/list/ajax_url', '', '');
//        $data['url_ajax_collect'] = $this->url->link('api/collect', '', '');

        $this->response->setOutput($this->load->view('standard_detail.html', $data));
    }
}