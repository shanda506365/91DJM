<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/25
 * Time: 14:40
 */
class ModelOrderOrderDesign extends Model
{
    public function addOrderDesign($data)
    {
        $this->event->trigger('pre.order.design.add', $data);

        $order_design = array(
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description'],
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('order_design', $order_design);
        $order_design_id = $this->db_ci->insert_id();
        return $order_design_id;
    }

    public function updateOrderDesign($order_design_id, $data) {
        $order_design = array(
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description'],
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->where('order_design_id', $order_design_id);
        return $this->db_ci->update('order_design', $order_design);
    }

    public function deleteOrderDesign($order_design_id) {
        $this->db_ci->where('order_design_id', $order_design_id);
        return $this->db_ci->delete('order_design');
    }

    public function getOrderDesign($order_design_id) {
        $this->db_ci->where('order_design_id', $order_design_id);
        $query = $this->db_ci->get('order_design');
        return $query->first_row();
    }

    public function getOrderDesignByOrderId($order_id) {
        $this->db_ci->where('order_id', $order_id);
        $this->db_ci->order_by('date_added', 'ASC');
        $query = $this->db_ci->get('order_design');
        $rows = $query->result_array();
        return $rows;
    }
}