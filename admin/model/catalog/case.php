<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/24
 * Time: 15:00
 */
class ModelCatalogCase extends Model
{
    public function addCase($data)
    {
        $this->event->trigger('pre.admin.case.add', $data);

        $case = array(
            'case_name' => $data['case_name'],
            'case_date' => $data['case_date'],
            'image' => $data['image'],
            'description' => $data['description'],
            'sort_order' => $data['sort_order'],
            'date_added' => date('Y-m-d')
        );
        $this->db_ci->insert('case', $case);

        $case_id = $this->db_ci->insert_id();

        $this->event->trigger('post.admin.case.add', $case_id);

        return $case_id;
    }

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

    function deleteCase($case_id)
    {
        $this->event->trigger('pre.admin.case.delete', $case_id);

        $this->db_ci->where('case_id', $case_id);

        return $this->db_ci->delete('case');
    }

    public function getCase($case_id) {
        $this->db_ci->where('case_id', $case_id);
        $query = $this->db_ci->get('case');
        return $query->first_row();
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
                $data['limit'] = 20;
            }
        }

        $this->db_ci->order_by($data['sort'], $data['order']);
        $this->db_ci->limit($data['limit'], (int)($data['start']));
        $query = $this->db_ci->get('case');
        $rows = $query->result_array();
        return $rows;
    }


}