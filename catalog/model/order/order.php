<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/15
 * Time: 15:20
 */
class ModelOrderOrder extends Model
{
/*
    public function getOrderStatus($name) {
        $key = array(
            'no_deposit' => 1,      //待付项目预付款
            'deposit_no_form' => 2,//已付项目预付款，待填写表单
            'validating'  => 3,     //沟通确认需求
            'designing' => 4,       //设计图设计中
            'design_over_not_pass' => 5,//设计图交付，待确认
            'design_pass_no_final_pay' => 6,//设计图已确认，待付尾款
            'payed_in_production' => 7,         //已付尾款，材料施工中
            'building' => 8,                    //进场搭建中
            'build_over' => 9                   //搭建完成
        );
        if (array_key_exists($name, $key)) {
            return $key[$name];
        }
        return 0;
    }
*/
    //step1添加订单，主要填写联系人信息，和支付订金
    public function addOrderStep1($data)
    {
        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($data['product_id']);

        $step1 = array(
            'order_no'  => $data['order_no'],
            'order_name' => $product_info['name'],
            'customer_id' => $data['customer_id'],
            'customer_group_id' => $data['customer_group_id'],
            'invoice_prefix'    => $data['invoice_prefix'],
            'store_id'          => $data['store_id'],
            'store_name'          => $data['store_name'],
            'store_url'             => $data['store_url'],
            'exhibition_area_code' => $data['exhibition_area_code'],
            'exhibition_address' => $data['exhibition_address'],
            'contact_name'  => $data['contact_name'],
            'contact_mobile' => $data['contact_mobile'],
            'contact_qq' => $data['contact_qq'],
            'designer_id' => $product_info['customer_id'],
            'main_product_id' => $data['product_id'],
            'order_status_id' => $data['order_status_id'],
            'total'             => $data['total'],
            'date_added'      => $data['date_added'],
            'date_modified'  => $data['date_modified']
        );

        $this->db_ci->insert('order', $step1);

        $order_id = $this->db_ci->insert_id();

        $order_product = array(
            'order_id' => $order_id,
            'product_id' => $data['product_id'],
            'name' => $product_info['name'],
            'model' => $product_info['model'],
            'quantity' => 1,
            'price' => $data['price'],
            'total' => $data['total']
        );

        $this->db_ci->insert('order_product', $order_product);

        //return $data['order_no'];
        return $order_id;
    }

    //填写详细的订单表单信息
    public function completeOrder($data, $order_no) {
        $order = array(
            'exhibition_subject'    => $data['exhibition_subject'],
            'length'                  => $data['length'],
            'width'                   => $data['width'],
            'height'                  => $data['height'],
            'area'                    => $data['area'],
            'is_squareness'         => $data['is_squareness'],
            'exhibition_verify_date' => $data['exhibition_verify_date'],
            'exhibition_enter_date'  => $data['exhibition_enter_date'],
            'exhibition_begin_date'  => $data['exhibition_begin_date'],
            'exhibition_leave_date'  => $data['exhibition_leave_date'],
            'remark'                    => $data['remark']
        );
        $this->db_ci->where('order_no', $order_no);
        $this->db_ci->update('order', $order);
        return $order_no;
    }

    //通过order_id得到订单信息
    public function getOrderById($order_id) {
        $this->db_ci->where('order_id', $order_id);
        $query = $this->db_ci->get('order');
        return $query->first_row();
    }

    //通过order_id得到订单信息
    public function getOrderByNo($order_no) {
        $this->db_ci->where('order_no', $order_no);
        $query = $this->db_ci->get('order');
        return $query->first_row();
    }
}