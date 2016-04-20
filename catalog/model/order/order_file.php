<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/19
 * Time: 15:25
 */
class ModelOrderOrderFile extends Model
{
    public function addOrderFile($order_id, $file_id) {
        $this->event->trigger('pre.order_file.add', $file_id);

        $data = array(
            'order_id' => $order_id,
            'file_id' => $file_id,
            'date_added' => date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('order_file', $data);

        $this->event->trigger('post.order_file.add', $order_id);
    }

    public function deleteOrderFile($file_id) {
        $this->event->trigger('pre.order_file.delete', $file_id);

        $this->db_ci->where('file_id', $file_id);

        return $this->db_ci->delete('order_file');
    }

    public function getOrderFiles($order_id) {
        $this->db_ci->where('order_id', $order_id);
        $query = $this->db_ci->get('order_file');
        $rows = $query->result_array();

        $temp_file_ids = array();
        foreach($rows as $row) {
            $temp_file_ids[] = $row['file_id'];
        }
        if (empty($temp_file_ids)) {
            return [];
        }
        $this->db_ci->select('');
        $this->db_ci->where_in('file_id', $temp_file_ids);
        $query = $this->db_ci->get('upload');
        return $query->result_array();
    }
}