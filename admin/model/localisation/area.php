<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/15
 * Time: 9:41
 */
class ModelLocalisationArea extends Model {

    public function getArea($area_code) {
        $this->db_ci->where('area_code', $area_code);
        $query = $this->db_ci->get('area');
        return $query->first_row();
    }

    public function getAreas($parent_code) {
        $this->db_ci->where('parent_code', $parent_code);
        //$this->db_ci->order_by('sort_order', 'ASC');
        $this->db_ci->order_by('spell_simple', 'ASC');
        $query = $this->db_ci->get('area');
        $rows = $query->result_array();
        return $rows;
    }

//    public function getChinaArea($china_area_id) {
//        $this->db_ci->where('china_area_id', $china_area_id);
//        $this->db_ci->order_by('sort_order', 'ASC');
//        $query = $this->db_ci->get('china_area');
//        return $query->first_row();
//    }
//
//    public function getChinaAreas() {
//        $this->db_ci->order_by('sort_order', 'ASC');
//        $query = $this->db_ci->get('china_area');
//        $rows = $query->result_array();
//        return $rows;
//    }

    //通过area_code得到全称
    public function getAreaNameByCode($area_code) {
        $data = array();
        $area = $this->getArea($area_code);
        $data[] = $area['area_name'];
        $area_code = $area['parent_code'];
        while(!empty($area['parent_code'])) {
            $area = $this->getArea($area_code);
            $data[] = $area['area_name'];
            $area_code = $area['parent_code'];
        }
        $data = array_reverse($data);
        return implode('', $data);
    }
}