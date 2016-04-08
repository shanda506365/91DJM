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

        $this->load->model('catalog/case');

        $data['meta_title'] = "案例展示 - " . $this->config->get('config_name');

        $data["cases"] = $this->ajaxPage();

        $data['url_ajax'] = $this->url->link('example/example/ajaxPage', '', 'SSL');

        //广告加载
        $this->load->model('design/banner');
        $data['data_img'] = $this->model_design_banner->banner_to_json(7);

        $this->response->setOutput($this->load->view('example.html', $data));
    }

    public function ajaxPage() {
        $this->load->model('catalog/case');

        $page = $this->request->get['page'];
        if (!is_numeric($page)) {
            $page = 0;
        }

        $page_size = 12;

        $data = array(
            "start" => $page * $page_size,
            "limit" => $page_size,
            "sort" => "sort_order",
            "order" => "ASC"
        );

        $total_cases = $this->model_catalog_case->getTotalCases($data);

        $cases = $this->model_catalog_case->getCases($data);

        $result = array();
        $this->load->model('tool/image');
        foreach($cases as $case) {
            $result[] = array(
                'case_id' => $case['case_id'],
                'src' => $this->model_tool_image->resize($case['image'], 365, 250),
                'case_name' => $case['case_name'],
                'link' => '/example/' . $case['case_id'] . '.html'
            );
        }

        //{"suc":"true","data":[{"case_id":"1","src":"images/A15.jpg","case_name":"111","link":"连接1"},……],"code":"111","msg":"tt","total":"13"

        $body = array(
            'suc' => true,
            'data' => $result,
            'code' => 1,
            'msg' => 'success',
            'total' => $total_cases
        );

        return json_encode($body, JSON_UNESCAPED_SLASHES);
    }
}