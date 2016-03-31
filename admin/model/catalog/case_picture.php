<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/25
 * Time: 10:35
 */
class ModelCatalogCasePicture extends Model
{
    public function addCasePicture($data)
    {
        $this->event->trigger('pre.admin.case_picture.add', $data);

        $case_picture = array(
            'case_id' => $data['case_id'],
            'image' => $data['image'],
            'title' => $data['title'],
            'description' => $data['description'],
            'sort_order' => $data['sort_order']
        );
        $this->db_ci->insert('case_picture', $case_picture);

        $case_picture_id = $this->db_ci->insert_id();

        $this->event->trigger('post.admin.case_picture.add', $case_picture_id);

        return $case_picture_id;
    }

    function updateCasePicture($case_picture_id, $data)
    {
        $this->event->trigger('pre.admin.case.edit', $data);

        $case_picture = array(
            'case_id' => $data['case_id'],
            'image' => $data['image'],
            'title' => $data['title'],
            'description' => $data['description'],
            'sort_order' => $data['sort_order']
        );
        $this->db_ci->where('case_picture_id', $case_picture_id);
        return $this->db_ci->update('case_picture', $case_picture);
    }

    function deleteCasePicture($case_picture_id)
    {
        $this->event->trigger('pre.admin.case_picture.delete', $case_picture_id);

        $this->db_ci->where('case_picture_id', $case_picture_id);

        return $this->db_ci->delete('case_picture');
    }

    function deleteCasePictureByCaseId($case_id)
    {
        $this->event->trigger('pre.admin.case_picture_by_case_id.delete', $case_id);

        $this->db_ci->where('case_id', $case_id);

        return $this->db_ci->delete('case_picture');
    }

    public function getCasePicture($case_picture_id) {
        $this->db_ci->where('case_picture_id', $case_picture_id);
        $this->db_ci->order_by('sort_order', 'ASC');
        $query = $this->db_ci->get('case_picture');
        return $query->first_row();
    }

    public function getCasePictures($case_id) {
        $this->db_ci->where('case_id', $case_id);
        $query = $this->db_ci->get('case_picture');
        return $query->result_array();
    }
}