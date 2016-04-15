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

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        $this->load->model('tool/image');

        $data_product_info = array(
            'product_id' => $product_info['product_id'],
            'product_name' => $product_info['product_name'],
            'price' => $product_info['price'],
            'image' => $this->model_tool_image->resize($product_info['image'], 58, 58),
        );

        $data['product_info'][] = json_encode($data_product_info, JSON_UNESCAPED_SLASHES);

        //开始生成面包屑
        $breadcrumbs[] = array(
            'name' => '首页',
            'link' => '/'
        );

        $master_category_id = $product_info['master_category_id'];

        $this->load->model('catalog/category');

        $master_category = $this->model_catalog_category->getCategory($master_category_id);

        $breadcrumbs[] = array(
            'name' => $master_category['name'],
            'link' => '/product/list/' . $master_category_id
        );

        $breadcrumbs[] = array(
            'name' => $product_info['name'],
            'link' => '/product/' . $product_info['product_id'] . '.html'
        );

        $breadcrumbs[] = array(
            'name' => '提交订单',
            'link' => 'javascript:void(0)'
        );

        $data['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);

        //我要下单
        $data['url_area'] = $this->url->link('api/area', '', 'SSL');

        $this->load->model('tool/area');

        $areas = $this->model_tool_area->getAreasByParentCode('510000');//四川省

        $data = array();

        foreach($areas as $area) {
            $data[] = array(
                'area_code' => $area['area_code'],
                'area_name' => $area['area_name']
            );
        }

        $json = array(
            'suc' => true,
            'msg' => '',
            'data' => $data,
            'code' => ''
        );

        $data['data_default_city'] = json_encode($json, JSON_UNESCAPED_SLASHES);

        //加入收藏夹
        $data['url_ajax_collect'] = $this->url->link('account/wishlist/add', '', '');

        $this->response->setOutput($this->load->view('submit.html', $data));
    }
}