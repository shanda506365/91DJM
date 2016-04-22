<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/15
 * Time: 15:20
 */
class ModelOrderOrder extends Model
{
    //step1添加订单，主要填写联系人信息，和支付订金
    public function addOrderStep1($data)
    {
        $order = array(
            'order_no'  => $data['order_no'],
            'order_name' => $data['order_name'],
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
            'designer_id' => $data['customer_id'],
            'main_product_id' => $data['main_product_id'],
            'order_status_id' => $data['order_status_id'],
            'payment_method' => $data['payment_method'],
            'payment_code' => $data['payment_code'],
            'deposit'             => $data['deposit'],
            'total'             => $data['total'],
            'date_added'      => $data['date_added'],
            'date_modified'  => $data['date_modified'],
            'language_id' => $data['language_id'],
            'currency_id' => $data['currency_id'],
            'currency_code' => $data['currency_code'],
            'currency_value' => $data['currency_value'],
            'ip' => $data['ip'],
            'forwarded_ip' => $data['forwarded_ip'],
            'user_agent' => $data['user_agent'],
            'accept_language' => $data['accept_language']
        );

        $this->db_ci->insert('order', $order);

        $order_id = $this->db_ci->insert_id();

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