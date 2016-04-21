<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/20
 * Time: 14:04
 */
class ModelOrderOrderHistory extends Model
{
    //$order_id, $user_id = 0, $order_status_id,$notify = 0, $title = '', $comment = '', $date_added = date('Y-m-d H:i:s')
    public function addOrderHistory($data)
    {
        $this->event->trigger('pre.order.history.add', $data);

        $order_history = array(
            'order_id' => $data['order_id'],
            'user_id' => $data['user_id'],
            'order_status_id' => $data['order_status_id'],
            'notify'        => isset($data['notify']) ? $data['notify'] : 0,
            'title'         => $data['title'],
            'comment'       => isset($data['comment']) ? $data['comment'] : '',
            'date_added' => isset($data['date_added']) ? $data['date_added'] : date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('order_history', $order_history);
    }
}