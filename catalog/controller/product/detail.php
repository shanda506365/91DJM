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

        echo $this->request->get['product_id'];exit;

    }
}