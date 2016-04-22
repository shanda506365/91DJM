<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/22
 * Time: 11:12
 */
class ModelOrderOrderTotal extends Model
{
    public function addOrderProduct($order_id, $data)
    {
        $order_product = array(
            'order_id' => $order_id,
            'product_id' => $data['product_id'],
            'name' => $data['name'],
            'model' => $data['model'],
            'quantity' => 1,
            'price' => $data['price'],
            'total' => $data['total']
        );

        return $this->db_ci->insert('order_product', $order_product);
    }
}