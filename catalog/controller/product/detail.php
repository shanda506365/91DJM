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
        $data['data_banner'] = $this->model_design_banner->banner_to_json(16);

        $page_data['title'] = $product_info['name'];
        $page_data['summary'] = $product_info['meta_description'];
        $page_data['description'] = htmlspecialchars_decode($product_info['description']);

        $this->load->model('tool/image');
        $page_data['image'] = $this->model_tool_image->resize($product_info['image'], 800, 540);

        $attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);
        //echo '<pre>';print_r($attribute_groups);exit;
        foreach($attribute_groups[0]['attribute'] as $attr) {
            $attribute[] = array(
                'attribute_name' => $attr['name'],
                'attribute_value' => $attr['text']
            );
        }
        $page_data['attribute'] = $attribute;


        $page_data['images'] = array();

        $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
        //echo '<pre>';print_r($results);exit;
        foreach($results as $image) {
            //$page_data['images'][] = $this->model_tool_image->resize($image['image'], 1200, 860);//优先考虑width缩放，高度无所谓
            $page_data['images'][] = $this->model_tool_image->origin($image['image']);
        }

        $this->load->model('account/customer');

        $customer = $this->model_account_customer->getCustomer($product_info['customer_id']);

        //print_r(DIR_UPLOAD . "photo/" . $customer['picture']);exit;

        $designer = $this->model_account_customer->getCustomerDesigner($product_info['customer_id']);
        $page_data['designer_id'] = $product_info['customer_id'];
        $page_data['designer_name'] = $designer['designer_name'];
        $page_data['designer_image'] = $this->model_tool_image->resize($customer['picture'], 58, 58);
        $page_data['designer_description'] = $designer['designer_description'];

        $data['data_detail'] = json_encode($page_data, JSON_UNESCAPED_SLASHES);

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

        $data['breadcrumbs'] = json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES);

        //我要下单
        $data['url_order'] = $this->url->link('order/order/depositForm', 'product_id='. $product_id, 'SSL');

        $this->response->setOutput($this->load->view('standard_detail.html', $data));
    }
}