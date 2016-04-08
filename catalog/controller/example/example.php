<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/8
 * Time: 10:06
 */
class ControllerExampleExample extends Controller {
    public function index() {

        $this->load->language('example/example');

        $this->load->model('catalog/factory');

        $data = array(
            "start" => 0,
            "limit" => 50,
            "sort" => "sort_order",
            "order" => "ASC"
        );
        $factories = $this->model_catalog_factory->getFactories($data);

        $result = array();
        foreach($factories as $factory) {
            $result[$factory["province_code"]][] = array(
                "area_name" => $factory["area_name"],
                "factory_name" => $factory["factory_name"]
            );
        }

        $data['meta_title'] = $this->language->get('meta_title');
        $data['meta_description'] = $this->language->get('meta_description');
        $data['meta_keyword'] = $this->language->get('meta_keyword');

        $data["data_province"] = json_encode($result);

        //广告加载
        $this->load->model('design/banner');
        $data['data_img'] = $this->model_design_banner->banner_to_json(7);
//        echo json_encode($result);
//        exit;
        $this->response->setOutput($this->load->view('jmfactory.html', $data));
    }
}