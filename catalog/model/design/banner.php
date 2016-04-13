<?php
class ModelDesignBanner extends Model {
	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image bi LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bi.banner_id = '" . (int)$banner_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");

		return $query->rows;
	}

    //区分系统本身的
    public function getBannerInfo($banner_id) {
        $this->db_ci->where('banner_id', $banner_id);
        $query = $this->db_ci->get('banner');
        return $query->first_row();
    }

    /*
     * 带title和description的广告
     * */
    function banner_with_description($banner_id) {
        $this->load->model('design/banner');
        $this->load->model('tool/image');

        $banner_info = $this->model_design_banner->getBannerInfo($banner_id);

        $banner_images = $this->model_design_banner->getBanner($banner_id);

        $array_json = array();
        if (count($banner_images) > 0) {
            foreach($banner_images as $banner_image) {
                $array_json[] = array(
                    'title' => $banner_image['title'],
                    'description' => $banner_image['description'],
                    'image' => $this->model_tool_image->resize($banner_image['image'], $banner_info['image_width'], $banner_info['image_height']),
                    'link' => $banner_image['link']
                );
            }
        }
        return json_encode($array_json, JSON_UNESCAPED_SLASHES);
    }

    /*
     * 广告管理数组转json
     * */
    function banner_to_json($banner_id) {
        $this->load->model('design/banner');
        $this->load->model('tool/image');

        $banner_info = $this->model_design_banner->getBannerInfo($banner_id);

        $banner_images = $this->model_design_banner->getBanner($banner_id);

        $array_json = array();
        if (count($banner_images) > 0) {
            foreach($banner_images as $banner_image) {
                $array_json[] = array(
                    'src' => $this->model_tool_image->resize($banner_image['image'], $banner_info['image_width'], $banner_info['image_height']),
                    'des' => $banner_image['title'],
                    'link' => $banner_image['link']
                );
            }
        }
        return json_encode($array_json, JSON_UNESCAPED_SLASHES);
    }
}