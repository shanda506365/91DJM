<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/26
 * Time: 16:43
 */
class ModelOrderOrderProcessing extends Model
{
    public function addOrderProcessing($data)
    {
        $order_processing = array(
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description'],
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('order_processing', $order_processing);
        $order_processing_id = $this->db_ci->insert_id();
        return $order_processing_id;
    }

    public function updateOrderProcessing($order_processing_id, $data) {
        $order_processing = array(
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description']
        );
        $this->db_ci->where('order_processing_id', $order_processing_id);
        return $this->db_ci->update('order_processing', $order_processing);
    }

    public function deleteOrderProcessing($order_processing_id) {
        $this->db_ci->where('order_processing_id', $order_processing_id);
        return $this->db_ci->delete('order_processing');
    }

    public function getOrderProcessing($order_processing_id) {
        $this->db_ci->where('order_processing_id', $order_processing_id);
        $query = $this->db_ci->get('order_processing');
        return $query->first_row();
    }

    public function getOrderProcessingByOrderId($order_id) {
        $this->db_ci->where('order_id', $order_id);
        $this->db_ci->order_by('date_added', 'ASC');
        $query = $this->db_ci->get('order_processing');
        $rows = $query->result_array();
        return $rows;
    }
}