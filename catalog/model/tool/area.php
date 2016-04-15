<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/15
 * Time: 12:02
 */
class ModelToolArea extends Model
{
    public function getAreasByParentCode($parent_code)
    {
        $this->db_ci->where('parent_code', $parent_code);
        $this->db_ci->order_by('sort_order', 'ASC');
        $query = $this->db_ci->get('area');
        $rows = $query->result_array();
        return $rows;
    }
}