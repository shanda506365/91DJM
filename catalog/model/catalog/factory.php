<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/6
 * Time: 15:37
 */
class ModelCatalogFactory extends Model
{
    public function getFactory($factory_id) {
        $this->db_ci->where('factory_id', $factory_id);
        $query = $this->db_ci->get('factory');
        return $query->first_row();
    }

    private function getWhere($data) {
        if (!empty($data['filter_factory_name'])) {
            $this->db_ci->like('factory_name', $data['filter_factory_name']);
        }
        if (!empty($data['filter_province_code'])) {
            $this->db_ci->where('province_code', $data['filter_province_code']);
        }
        if (!empty($data['filter_china_area_id'])) {
            $this->db_ci->where('china_area_id', $data['filter_china_area_id']);
        }
    }

    public function getTotalFactories($data) {
        $this->getWhere($data);
        return $this->db_ci->count_all_results('factory');
    }

    public function getFactories($data = array()) {
        $this->getWhere($data);

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
        }

        $this->db_ci->order_by($data['sort'], $data['order']);
        $this->db_ci->limit($data['limit'], (int)($data['start']));
        $query = $this->db_ci->get('factory');
        $rows = $query->result_array();
        return $rows;
    }

}