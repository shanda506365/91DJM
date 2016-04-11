<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/8
 * Time: 16:37
 */
class ControllerProductList extends Controller {
    public function index() {
        $this->load->language('product/search');

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
            $filter = json_decode($filter);
            $temp_arr = array();
            foreach($filter as $attr) {
                $temp_arr[] = $attr->fid;
            }
            $filter = implode(',', $temp_arr);
        } else {
            $filter = '';
        }

        if (isset($this->request->post['category_id'])) {
            $category_id = $this->request->post['category_id'];
        } else {
            $category_id = 1;//定制化
        }

        if (isset($this->request->post['sort'])) {
            $sort = $this->request->post['sort'];
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

        $data['meta_title'] = '案例展示 - ' . $this->config->get('config_name');

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

            if ((float)$result['special']) {
                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $special = false;
            }

            if ($this->config->get('config_tax')) {
                $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
            } else {
                $tax = false;
            }

            if ($this->config->get('config_review_status')) {
                $rating = (int)$result['rating'];
            } else {
                $rating = false;
            }

            $data['products'][] = array(
                'product_id'  => $result['product_id'],
                'thumb'       => $image,
                'name'        => $result['name'],
                'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                'price'       => $price,
                'special'     => $special,
                'tax'         => $tax,
                'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                'rating'      => $result['rating'],
                'href'        => $this->url->link_static('product/'. $result['product_id'] . '.html')
            );

            $data['products'][] = array(
                'product_id'  => $result['product_id'],
                'thumb'       => $image,
                'name'        => $result['name'],
                'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                'price'       => $price,
                'special'     => $special,
                'tax'         => $tax,
                'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                'rating'      => $result['rating'],
                'href'        => $this->url->link_static('product/'. $result['product_id'] . '.html')
            );
        }

        $data['search'] = $search;
        $data['category_id'] = $category_id;

        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['limit'] = $limit;

        $data['meta_title'] = '效果图展示 - ' . $this->config->get('config_name');

        $filters = $this->model_catalog_category->getCategoryFilters(1);
        $data['filters'] = json_encode($filters, JSON_UNESCAPED_SLASHES);

        //广告加载
        $this->load->model('design/banner');
        $data['data_img'] = $this->model_design_banner->banner_to_json(7);

        //获取短信验证码的网址
        $data['url_register'] = $this->url->link('account/register/doRegister', '', 'SSL');

        $this->response->setOutput($this->load->view('effect.html', $data));
    }
}
