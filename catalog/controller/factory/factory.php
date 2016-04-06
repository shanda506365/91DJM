<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/6
 * Time: 15:36
 */
class ControllerFactoryFactory extends Controller {
    public function index() {

        $this->load->language('factory/factory');

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
            $result[][$factory["province_code"]] = array(
                "area_name" => $factory["area_name"],
                "factory_name" => $factory["factory_name"]
            );
        }

        $data['meta_title'] = $this->language->get('meta_title');
        $data['meta_description'] = $this->language->get('meta_description');
        $data['meta_keyword'] = $this->language->get('meta_keyword');

        $data["data_province"] = json_encode($result);
//        echo json_encode($result);
//        exit;
        $this->response->setOutput($this->load->view('jdfactory.html', $data));
    }
}