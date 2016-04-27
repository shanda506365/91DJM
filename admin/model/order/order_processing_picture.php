<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/26
 * Time: 16:46
 */
class ModelOrderOrderProcessingPicture extends Model
{
    public function addOrderProcessingPicture($data)
    {
        $order_processing_picture = array(
            'order_design_id' => $data['order_design_id'],
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description'],
            'picture'    => $data['picture'],
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('order_processing_picture', $order_processing_picture);
        $order_processing_picture_id = $this->db_ci->insert_id();
        return $order_processing_picture_id;
    }

    public function updateOrderProcessingPicture($order_processing_picture_id, $data) {
        $order_processing_picture = array(
            'order_design_id' => $data['order_design_id'],
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description'],
            'picture'    => $data['picture'],
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->where('order_processing_picture_id', $order_processing_picture_id);
        return $this->db_ci->update('order_processing_picture', $order_processing_picture);
    }

    public function deleteOrderProcessingPicture($order_processing_picture_id) {
        $this->db_ci->where('order_processing_picture_id', $order_processing_picture_id);
        return $this->db_ci->delete('order_processing_picture');
    }

    public function getOrderProcessingPicture($order_processing_picture_id) {
        $this->db_ci->where('order_processing_picture_id', $order_processing_picture_id);
        $query = $this->db_ci->get('order_processing_picture');
        return $query->first_row();
    }

    public function getOrderProcessingPictureByOrderProcessing($order_design_id) {
        $this->db_ci->where('order_design_id', $order_design_id);
        $this->db_ci->order_by('date_added', 'ASC');
        $query = $this->db_ci->get('order_processing_picture');
        $rows = $query->result_array();
        return $rows;
    }

    public function getOrderProcessingPictureByOrderId($order_id) {
        $this->db_ci->where('order_id', $order_id);
        $this->db_ci->order_by('date_added', 'ASC');
        $query = $this->db_ci->get('order_processing_picture');
        $rows = $query->result_array();
        return $rows;
    }
}