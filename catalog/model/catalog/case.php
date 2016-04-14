<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/8
 * Time: 15:32
 */
class ModelCatalogCase extends Model
{
    function updateCase($case_id, $data)
    {
        $this->event->trigger('pre.admin.case.edit', $data);

        $case = array(
            'case_name' => $data['case_name'],
            'case_date' => $data['case_date'],
            'image' => $data['image'],
            'description' => $data['description'],
            'sort_order' => $data['sort_order']
        );
        $this->db_ci->where('case_id', $case_id);
        return $this->db_ci->update('case', $case);
    }

    public function getCaseWhere($data) {
        if (!empty($data['filter_case_name'])) {
            $this->db_ci->like('case_name', $data['filter_case_name']);
        }
    }

    public function getTotalCases($data) {
        $this->getCaseWhere($data);
        return $this->db_ci->count_all_results('case');
    }

    public function getCases($data) {
        $this->getCaseWhere($data);

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 12;
            }
        }

        if (!isset($data['sort'])) {
            $data['sort'] = 'sort_order';
        }

        if (!isset($data['order'])) {
            $data['order'] = 'ASC';
        }

        $this->db_ci->order_by($data['sort'], $data['order']);
        $this->db_ci->limit($data['limit'], (int)($data['start']));
        $query = $this->db_ci->get('case');
        $rows = $query->result_array();
        return $rows;
    }


}