<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/19
 * Time: 15:25
 */
class ModelOrderOrderFile extends Model
{
    public function addOrderFile($order_id, $upload_id) {
        $this->event->trigger('pre.order_file.add', $upload_id);

        $data = array(
            'order_id' => $order_id,
            'upload_id' => $upload_id,
            'date_added' => date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('order_file', $data);

        $this->event->trigger('post.order_file.add', $order_id);
    }

    public function deleteOrderFile($upload_id) {
        $this->event->trigger('pre.order_file.delete', $upload_id);

        $this->db_ci->where('upload_id', $upload_id);

        return $this->db_ci->delete('order_file');
    }

    public function getOrderFiles($order_id) {
        $this->db_ci->where('order_id', $order_id);
        $query = $this->db_ci->get('order_file');
        $rows = $query->result_array();

        $temp_file_ids = array();
        foreach($rows as $row) {
            $temp_file_ids[] = $row['upload_id'];
        }
        if (empty($temp_file_ids)) {
            return [];
        }
        $this->db_ci->select('');
        $this->db_ci->where_in('upload_id', $temp_file_ids);
        $this->db_ci->order_by('date_added', 'DESC');
        $query = $this->db_ci->get('upload');
        return $query->result_array();
    }
}