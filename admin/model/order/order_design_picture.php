<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/25
 * Time: 15:26
 */
class ModelOrderOrderDesignPicture extends Model
{
    public function addOrderDesignPicture($data)
    {
        $this->event->trigger('pre.order.design.picture.add', $data);

        $order_design_picture = array(
            'order_design_id' => $data['order_design_id'],
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description'],
            'picture'    => $data['picture'],
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('order_design_picture', $order_design_picture);
        $order_design_picture_id = $this->db_ci->insert_id();
        return $order_design_picture_id;
    }

    public function updateOrderDesignPicture($order_design_picture_id, $data) {
        $order_design_picture = array(
            'order_design_id' => $data['order_design_id'],
            'order_id' => $data['order_id'],
            'title' => $data['title'],
            'description'  => $data['description'],
            'picture'    => $data['picture'],
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->where('order_design_picture_id', $order_design_picture_id);
        return $this->db_ci->update('order_design_picture', $order_design_picture);
    }

    public function deleteOrderDesignPicture($order_design_picture_id) {
        $this->db_ci->where('order_design_picture_id', $order_design_picture_id);
        return $this->db_ci->delete('order_design_picture');
    }

    public function getOrderDesignPicture($order_design_picture_id) {
        $this->db_ci->where('order_design_picture_id', $order_design_picture_id);
        $query = $this->db_ci->get('order_design_picture');
        return $query->first_row();
    }

    public function getOrderDesignPictureByOrderDesign($order_design_id) {
        $this->db_ci->where('order_design_id', $order_design_id);
        $this->db_ci->order_by('date_added', 'ASC');
        $query = $this->db_ci->get('order_design_picture');
        $rows = $query->result_array();
        return $rows;
    }

    public function getOrderDesignPictureByOrderId($order_id) {
        $this->db_ci->where('order_id', $order_id);
        $this->db_ci->order_by('date_added', 'ASC');
        $query = $this->db_ci->get('order_design_picture');
        $rows = $query->result_array();
        return $rows;
    }
}