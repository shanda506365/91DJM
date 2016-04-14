<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/11
 * Time: 14:20
 */
class ControllerCommonTest extends Controller
{

    public function index()
    {
        $this->load->model('customer/customer');
        $temp = $this->model_customer_customer->getCustomersByGroupId(2);
        echo '<pre>';
        print_r($temp);exit;
    }
}
