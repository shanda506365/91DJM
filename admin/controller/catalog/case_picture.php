<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/25
 * Time: 10:34
 */
class ControllerCatalogCasePicture extends Controller
{
    private $error = array();

    public function index() {
        $this->language->load('catalog/case_picture');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/case');
        $this->load->model('catalog/case_picture');

        $this->getList();
    }

    public function add() {
        $this->language->load('catalog/case_picture');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/case_picture');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_catalog_case_picture->addCasePicture($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '&case_id=' . $this->request->get['case_id'];

            $this->response->redirect($this->url->link('catalog/case_picture', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit() {
        $this->language->load('catalog/case_picture');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/case_picture');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_catalog_case_picture->updateCasePicture($this->request->get['case_picture_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '&case_id=' . $this->request->get['case_id'];

            $this->response->redirect($this->url->link('catalog/case_picture', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->language->load('catalog/case_picture');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/case_picture');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $case_picture_id) {
                $this->model_catalog_case_picture->deleteCasePicture($case_picture_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '&case_id=' . $this->request->get['case_id'];

            $this->response->redirect($this->url->link('catalog/case_picture', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList() {
        $case_id = $this->request->get['case_id'];
        $url = '&case_id=' . $case_id;

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/case', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $case_info = $this->model_catalog_case->getCase($case_id);

        $data['breadcrumbs'][] = array(
            'text' => $case_info['case_name'],
            'href' => $this->url->link('catalog/case_picture', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['add'] = $this->url->link('catalog/case_picture/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/case_picture/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['token'] = $this->session->data['token'];

        $results = $this->model_catalog_case_picture->getCasePictures($case_id);

        $data['case_pictures'] = array();

        foreach ($results as $result) {
            $data['case_pictures'][] = array(
                'case_id' => $result['case_id'],
                'case_picture_id'   => $result['case_picture_id'],
                'image'          => $result['image'],
                'title'          => $result['title'],
                'description'   => $result['description'],
                'sort_order'    => $result['sort_order'],
                'edit'           => $this->url->link('catalog/case_picture/edit', 'token=' . $this->session->data['token'] . '&case_picture_id=' . $result['case_picture_id'] . $url, 'SSL')
            );
        }

        $this->load->model('tool/image');

        foreach ($data['case_pictures'] as $k => $case) {
            if (is_file(DIR_IMAGE . $case['image'])) {
                $image = $case['image'];
                $thumb = $case['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['case_pictures'][$k]['thumb'] = $this->model_tool_image->resize($thumb, 100, 100);
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_title'] = $this->language->get('column_title');
        $data['column_sort_order'] = $this->language->get('column_sort_order');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/case_picture_list.tpl', $data));
    }

    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['case_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_keyword'] = $this->language->get('entry_keyword');
        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_bottom'] = $this->language->get('entry_bottom');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_layout'] = $this->language->get('entry_layout');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data'] = $this->language->get('tab_data');
        $data['tab_design'] = $this->language->get('tab_design');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = '';
        }

        if (isset($this->error['sort_order'])) {
            $data['error_sort_order'] = $this->error['sort_order'];
        } else {
            $data['error_sort_order'] = '';
        }

        $data['case_id']  = $this->request->get['case_id'];

        $url = '&case_id=' . $this->request->get['case_id'];

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/case', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['case_picture_id'])) {
            $data['action'] = $this->url->link('catalog/case_picture/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/case_picture/edit', 'token=' . $this->session->data['token'] . '&case_picture_id=' . $this->request->get['case_picture_id'] . $url, 'SSL');
        }

        //$data['cancel'] = $this->url->link('catalog/case', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['cancel'] = "javascript:history.go(-1)";

        if (isset($this->request->get['case_picture_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $case_picture_info = $this->model_catalog_case_picture->getCasePicture($this->request->get['case_picture_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif (!empty($case_picture_info)) {
            $data['title'] = $case_picture_info['title'];
        } else {
            $data['title'] = '';
        }

        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } elseif (!empty($case_picture_info)) {
            $data['description'] = $case_picture_info['description'];
        } else {
            $data['description'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($case_picture_info) && is_file(DIR_IMAGE . $case_picture_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($case_picture_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($case_picture_info)) {
            $data['image'] = $case_picture_info['image'];
        } else {
            $data['image'] = '';
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($case_picture_info)) {
            $data['sort_order'] = $case_picture_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        $this->load->model('design/layout');

        $data['layouts'] = $this->model_design_layout->getLayouts();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/case_picture_form.tpl', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/case')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (utf8_strlen($this->request->post['title']) < 2) {
            $this->error['title'] = sprintf($this->language->get('error_title'));
        }

        if (!is_numeric($this->request->post['sort_order'])) {
            $this->error['sort_order'] = $this->language->get('error_sort_order');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/case_picture')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('catalog/case_picture');

        foreach ($this->request->post['selected'] as $case_picture_id) {

            $this->model_catalog_case_picture->deleteCasePicture($case_picture_id);
        }

        return !$this->error;
    }
}