<?php
class ModelToolUpload extends Model {
	public function addUpload($name, $filename, $size = 0) {
		$code = sha1(uniqid(mt_rand(), true));

		//$this->db->query("INSERT INTO `" . DB_PREFIX . "upload` SET `name` = '" . $this->db->escape($name) . "', `filename` = '" . $this->db->escape($filename) . "', `code` = '" . $this->db->escape($code) . "', `date_added` = NOW()");

        $data = array(
            'name' => $name,
            'filename' => $filename,
            'size' => $size,
            'code' => $code,
            'date_added' => date('Y-m-d H:i:s')
        );
        $this->db_ci->insert('upload', $data);

        $upload_id = $this->db_ci->insert_id();

		return $upload_id;
	}

	public function getUploadByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upload` WHERE code = '" . $this->db->escape($code) . "'");

		return $query->row;
	}

    public function getUpload($upload_id) {
        $this->db_ci->where('upload_id', $upload_id);
        $query = $this->db_ci->get('upload');
        return $query->first_row();
    }

    public function deleteUpload($upload_id) {
        $this->db_ci->where('upload_id', $upload_id);

        return $this->db_ci->delete('upload');
    }
}