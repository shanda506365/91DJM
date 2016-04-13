<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/13
 * Time: 9:30
 */
class ControllerProductStandard extends Controller
{
    public function index()
    {

        $data['meta_title'] = '标准套餐 - ' . $this->config->get('config_name');

        //广告加载
        $this->load->model('design/banner');
        $data['data_img'] = $this->model_design_banner->banner_to_json(7);

        $data['data_floor'] = $this->model_design_banner->banner_with_description(15);

        $this->response->setOutput($this->load->view('standard.html', $data));
    }
}