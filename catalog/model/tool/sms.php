<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/6
 * Time: 16:13
 */
class ModelToolSms extends Model {
    public function addSmsHistory($data) {
        $sms_history = array(
            'mobile' => $data['mobile'],
            'model' => $data['model'],
            'tpl_name' => $data['tpl_name'],
            'pars' => $data['pars'],
            'date_added_timestamp' => time()
        );
        $this->db_ci->insert('sms_history', $sms_history);

        $id = $this->db_ci->insert_id();

        return $id;
    }
}
