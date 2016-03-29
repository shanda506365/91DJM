<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/15
 * Time: 9:30
 */
class ModelCatalogFactory extends Model
{
    public function add($data)
    {
        $this->event->trigger('pre.admin.factory.add', $data);

        $factory = array(
            'factory_name' => $data['factory_name'],
            'province_code' => $data['province_code'],
            'china_area_id' => $data['china_area_id'],
            'sort_order'    => $data['sort_order']
        );
        $this->db_ci->insert('factory', $factory);

        $factory_id = $this->db_ci->insert_id();

        $this->event->trigger('post.admin.factory.add', $factory_id);

        return $factory_id;
    }

    function update($factory_id, $data) {
        $factory = array(
            'factory_name' => $data['factory_name'],
            'province_code' => $data['province_code'],
            'china_area_id' => $data['china_area_id'],
            'sort_order'    => $data['sort_order']
        );
        $this->db_ci->where('factory_id', $factory_id);
        return $this->db_ci->update('factory', $factory);
    }

    function delete($factory_id) {
        $this->db_ci->where('factory_id', $factory_id);

        return $this->db_ci->delete('factory');
    }

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

    public function getFactories($data) {
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