<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/6
 * Time: 15:36
 */
class ControllerFactoryFactory extends Controller {
    public function index() {

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

        echo json_encode($result);
        exit;
    }
}