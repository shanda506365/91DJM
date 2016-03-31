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
        $this->response->setOutput($this->load->view('index.html', array()));
    }
}