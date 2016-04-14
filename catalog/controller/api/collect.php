<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/12
 * Time: 14:39
 */
class ControllerApiCollect extends Controller
{
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $data = array(
                "suc" => false,
                "msg" => "登陆后才能收藏设计师！"
            );
            echo json_encode($data);
            exit;
        }

        $designer_id = (int)$this->request->post['designer_id'];

        $this->load->model('account/collect');

        $collect_num = $this->model_account_collect->addCollect($designer_id);

        $data = array(
            "suc" => true,
            "data" => $collect_num,
            "msg" => "收藏成功！"
        );
        echo json_encode($data);
        exit;
    }
}