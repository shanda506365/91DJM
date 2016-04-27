<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/22
 * Time: 10:35
 */
class ModelOrderOrderProduct extends Model
{
    public function addOrderProduct($data)
    {
        $order_product = array(
            'order_id' => $data['order_id'],
            'product_id' => $data['product_id'],
            'name' => $data['name'],
            'model' => $data['model'],
            'quantity' => 1,
            'price' => $data['price'],
            'total' => $data['total'],
            'customer_id' => $data['customer_id']
        );

        return $this->db_ci->insert('order_product', $order_product);
    }
}