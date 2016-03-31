<?php
class ControllerCommonHome extends Controller {
	public function index() {
//		$this->document->setTitle($this->config->get('config_meta_title'));
//		$this->document->setDescription($this->config->get('config_meta_description'));
//		$this->document->setKeywords($this->config->get('config_meta_keyword'));

        $data['meta_title'] = $this->config->get('config_meta_title');
        $data['meta_description'] = $this->config->get('config_meta_description');
        $data['meta_keyword'] = $this->config->get('config_meta_keyword');


		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

//		$data['column_left'] = $this->load->controller('common/column_left');
//		$data['column_right'] = $this->load->controller('common/column_right');
//		$data['content_top'] = $this->load->controller('common/content_top');
//		$data['content_bottom'] = $this->load->controller('common/content_bottom');
//		$data['footer'] = $this->load->controller('common/footer');
//		$data['header'] = $this->load->controller('common/header');

        //广告加载
        $this->load->model('design/banner');
        $data['data_img'] = $this->model_design_banner->banner_to_json(7);

        $data['data_thumbview'] = $this->model_design_banner->banner_to_json(13);

        $this->response->setOutput($this->load->view('index.html', $data));
	}
}