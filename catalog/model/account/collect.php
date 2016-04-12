<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/12
 * Time: 14:55
 */
class ModelAccountCollect extends Model {
    public function addCollect($designer_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_collect_designer WHERE customer_id = '" . (int)$this->customer->getId() . "' AND designer_id = '" . (int)$designer_id . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_collect_designer SET customer_id = '" . (int)$this->customer->getId() . "', designer_id = '" . (int)$designer_id . "', date_added = NOW()");

        //查询设计师收藏总数
        $this->db_ci->where('designer_id', $designer_id);
        $this->db_ci->from('customer_collect_designer');
        $collect_num = $this->db_ci->count_all_results();

        //更新设计师收藏总数
        $data = array(
            'collect_num' => $collect_num
        );
        $this->db_ci->where('customer_id', $designer_id);
        $this->db_ci->update('customer', $data);
        return $collect_num;
    }

    public function deleteCollect($designer_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_collect_designer WHERE customer_id = '" . (int)$this->customer->getId() . "' AND designer_id = '" . (int)$designer_id . "'");

        //查询设计师收藏总数
        $this->db_ci->where('designer_id', $designer_id);
        $this->db_ci->from('customer_collect_designer');
        $collect_num = $this->db_ci->count_all_results();

        //更新设计师收藏总数
        $data = array(
            'collect_num' => $collect_num
        );
        $this->db_ci->where('customer_id', $designer_id);
        $this->db_ci->update('customer', $data);
        return $collect_num;
    }

    public function getCollect() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_collect_designer WHERE customer_id = '" . (int)$this->customer->getId() . "'");

        return $query->rows;
    }

    public function getTotalCollect() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_collect_designer WHERE customer_id = '" . (int)$this->customer->getId() . "'");

        return $query->row['total'];
    }
}
