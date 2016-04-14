<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/31
 * Time: 8:12
 */
class ControllerCommonTest extends Controller
{
    public function index()
    {
        //$this->response->setOutput($this->load->view('index.html', array()));
//        $this->load->helper("sms");
//        $pars = array(
//            "code" => "123456",
//            "product" => "搭积木"
//        );
//        $result = send_sms("18048505035", $pars, "SMS_7225793", date("Y-m-d"));
//        echo '<pre>';
//        print_r($result);

//产品过滤测试
//        $this->load->model('catalog/product');
//
//        $filter_data = array(
//            'filter_category_id'  => 1,
//            'filter_filter'      => '2,18',
//            'sort' => 'p.product_id'
//        );
//        $temp = $this->model_catalog_product->getProducts($filter_data);
//        echo '<pre>';
//        print_r($temp);
//
//        echo $this->model_catalog_product->getTotalProducts($filter_data);

        //echo format_bytes(filesize("E:\\djm\\image\\upload\\11.png.FHThrdSjioRvCxN7frdegG3hVef2xL6F"));exit;

        echo get_extension("E:\\djm\\image\\upload\\201604\\FHThrdSjioRvCxN7frdegG3hVef2xL6F.png");
        exit;


        //2016-04-13 10:51:29

        $date = '2016-04-13 10:51:29';
        echo date('Ym', strtotime($date));exit;

        $this->response->setOutput($this->load->view('djm/template/common/test.tpl', array()));
    }
}