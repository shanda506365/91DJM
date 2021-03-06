<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/8
 * Time: 16:37
 */
class ControllerProductList extends Controller {
    public function index() {

        $category_id = (int)$this->request->get['category_id'];

        $data['meta_title'] = '案例展示 - ' . $this->config->get('config_name');

        //{"suc":"true","data":[{"product_id":"1","src":"images/A15.jpg","product_name":"111","link":"连接1","designer_id":"1","designer_name":"赵晓配","collect_num":"48","designer_link":"###"}……],"code":"111","msg":"tt","total":"13"}

//        $data['search'] = $search;
//        $data['category_id'] = $category_id;
//
//        $data['sort'] = $sort;
//        $data['order'] = $order;
//        $data['limit'] = $limit;

        $data['meta_title'] = '效果图展示 - ' . $this->config->get('config_name');

        $this->load->model('catalog/category');

        $filters = $this->model_catalog_category->getCategoryFilters($category_id);
        $data['filters'] = json_encode($filters, JSON_UNESCAPED_SLASHES);

        //广告加载
        $this->load->model('design/banner');
        $data['data_img'] = $this->model_design_banner->banner_to_json(7);

        $data['data_imglist'] = $this->do_filter();

        //分页的网址
        $data['url_ajax_page'] = $this->url->link('product/list/ajax_url', '', '');
        $data['url_ajax_collect'] = $this->url->link('account/wishlist/add', '', '');

        $this->response->setOutput($this->load->view('effect.html', $data));
    }

    public function ajax_url() {
        $data['data_imglist'] = $this->do_filter();
        echo $data['data_imglist'];exit;
    }

    protected function do_filter() {

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $page_size = $limit = 12;

        if (isset($this->request->post['search'])) {
            $search = $this->request->post['search'];
        } else {
            $search = '';
        }

        if (isset($this->request->post['filter'])) {
            $filter = $this->request->post['filter'];
        } else {
            $filter = '';
        }

        if (isset($this->request->get['category_id'])) {
            $category_id = (int)$this->request->get['category_id'];
        } elseif (isset($this->request->post['category_id'])) {
            $category_id = (int)$this->request->post['category_id'];
        } else {
            $category_id = 1;//定制化
        }

        if (isset($this->request->post['sort'])) {
            $sort = $this->request->post['sort'];
            if ($sort == '1') {
                $sort = 'p.date_added';
            } elseif($sort == '2') {
                $sort = 'p.viewed';
            }
        } else {
            $sort = 'p.date_added';
        }

        if (isset($this->request->post['order'])) {
            $order = $this->request->post['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->post['page'])) {
            $page = $this->request->post['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->post['limit'])) {
            $limit = (int)$this->request->post['limit'];
        } else {
            $limit = 12;
        }

        $this->load->model('account/customer');

        $this->load->model('catalog/category');

        $data['products'] = array();

        $filter_data = array(
            'filter_name'         => $search,
            'filter_category_id'  => $category_id,
            'filter_filter'      => $filter,
            'sort'                => $sort,
            'order'               => $order,
            'start'               => ($page - 1) * $limit,
            'limit'               => $limit
        );

        $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

        $results = $this->model_catalog_product->getProducts($filter_data);

        $all_designer_ids = array();

        $all_products = array();

        foreach ($results as $result) {
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], 365, 250);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', 365, 250);
            }

            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $price = false;
            }

            $all_products[] = array(
                'product_id'  => $result['product_id'],
                'product_name'        => $result['name'],
                'src' => $image,
                'link'        => $this->url->link_static('product/'. $result['product_id'] . '.html'),
                'price'       => $price,
                'customer_id' => $result['customer_id'],
                'collect_num' => $result['collect_num']
            );

            $all_designer_ids[] = $result['customer_id'];

        }
//print_r($all_products);exit;
        $all_designers = $this->model_account_customer->getCustomerDesignersByIds($all_designer_ids);
        foreach($all_designers as $designer) {
            $all_designers_info[$designer['customer_id']] = array(
                'designer_id' => $designer['customer_id'],
                'designer_name' => $designer['designer_name'],
                'collect_num' => $designer['collect_num'],
                'designer_link' => $this->url->link_static('designer/'. $result['customer_id'] . '.html')
            );
        }

        foreach($all_products as $key => $product) {
            //补充设计师数据
            $temp = $product;
            $temp['designer_id'] = $product['customer_id'];
            $temp['designer_name'] = $all_designers_info[$product['customer_id']]['designer_name'];
            $temp['designer_link'] =  $all_designers_info[$product['customer_id']]['designer_link'];
            $all_products_info[] = $temp;
        }

        $data_imglist = array(
            "suc" => true,
            "data" => empty($all_products_info) ? array() : $all_products_info,
            "code" => 1,
            "msg" => '',
            "total" => $product_total
        );

        $data['data_imglist'] = json_encode($data_imglist, JSON_UNESCAPED_SLASHES);
//echo '<pre>';print_r($data['data_imglist']);exit;


        //wishlist地址： index.php?route=account/wishlist/add

        //{"name":"首页","link":"/"},{"name":"标准化套餐","link":"###"},{"name":"A套餐详情","link":"###"}

        return $data['data_imglist'];
    }
}
