<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/15
 * Time: 12:00
 */
class ControllerApiArea extends Controller
{
    public function index()
    {
        $area_code = $this->request->post['area_code'];

        $this->load->model('tool/area');

        $areas = $this->model_tool_area->getAreasByParentCode($area_code);

        $data = array();

        foreach($areas as $area) {
            $data[] = array(
                'area_code' => $area['area_code'],
                'area_name' => $area['area_name']
            );
        }

        $json = array(
            'suc' => true,
            'msg' => '',
            'data' => $data
        );

        echo json_encode($json, JSON_UNESCAPED_SLASHES);
        exit;
    }
}