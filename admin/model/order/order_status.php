<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/26
 * Time: 15:21
 */
class ModelOrderOrderStatus extends Model
{
    public function getOrderStatusByKey($name)
    {
        $key = array(
            'no_deposit' => 1,      //待付项目预付款
            'deposit_no_form' => 2,//已付项目预付款，待填写表单
            'validating' => 3,     //沟通确认需求
            'designing' => 4,       //设计图设计中
            'design_over_not_pass' => 5,//设计图交付，待确认
            'design_pass_offering' => 6,//设计图已确认，报价中
            'offer_pass_not_pay' => 7,//报价完成，待付尾款
            'payed_in_production' => 8,         //已付尾款，材料施工中
            'building' => 9,                    //进场搭建中
            'build_over' => 10                   //搭建完成
        );
        if (array_key_exists($name, $key)) {
            return $key[$name];
        }
        return 0;
    }

    public function getOrderStatusById($order_status_id) {
        $this->db_ci->where('order_status_id', $order_status_id);
        $this->db_ci->where('language_id', (int)$this->config->get('config_language_id'));
        $query = $this->db_ci->get('order_status');
        return $query->first_row();
    }
}