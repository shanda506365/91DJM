<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/15
 * Time: 15:20
 */
class ModelOrderOrder extends Model
{
    //step1添加订单
    public function addOrderStep1($data)
    {
        $step1 = array(
            'order_no'  => $data['order_no'],
            'order_name' => $data['product_name'],
            'exhibition_area_code' => $data['exhibition_area_code'],
            'contact_name'  => $data['contact_name'],
            'contact_mobile' => $data['contact_mobile'],
            'contact_qq' => $data['contact_qq'],
            'order_status_id' => $data['order_status_id']
        );

        $this->db_ci->insert('order', $step1);

        $order_id = $this->db_ci->insert_id();

        $order_product = array(
            'order_id' => $order_id,
            'product_id' => $data['product_id'],
            'name' => $data['product_name'],
            'model' => $data['product_model'],
            'quantity' => 1,
            'price' => $data['price'],
            'total' => $data['total']
        );

        $this->db_ci->insert('order_product', $order_product);

        return $order_id;
    }
}