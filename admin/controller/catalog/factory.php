<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/3/15
 * Time: 9:29
 */
class ControllerCatalogFactory extends Controller {
    private $error = array();

    public function index() {

        $this->language->load('catalog/factory');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/factory');
        $this->load->model('localisation/area');

        $this->getList();
    }

    public function add() {
        $this->language->load('catalog/factory');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/factory');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_factory->add($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit() {
        $this->language->load('catalog/factory');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/factory');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_catalog_factory->update($this->request->get['factory_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->language->load('catalog/factory');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/factory');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $factory_id) {
                $this->model_catalog_factory->delete($factory_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['filter_factory_name'])) {
            $filter_factory_name = $this->request->get['filter_factory_name'];
        } else {
            $filter_factory_name = null;
        }

        if (isset($this->request->get['filter_province_code'])) {
            $filter_province_code = $this->request->get['filter_province_code'];
        } else {
            $filter_province_code = null;
        }

        if (isset($this->request->get['filter_china_area_id'])) {
            $filter_china_area_id = $this->request->get['filter_china_area_id'];
        } else {
            $filter_china_area_id = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'factory_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['add'] = $this->url->link('catalog/factory/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/factory/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['token'] = $this->session->data['token'];

        $data['factories'] = array();

        $filter_data = array(
            'filter_factory_name' => $filter_factory_name,
            'filter_province_code' => $filter_province_code,
            'filter_china_area_id' => $filter_china_area_id,
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $factory_total = $this->model_catalog_factory->getTotalFactories($filter_data);

        $results = $this->model_catalog_factory->getFactories($filter_data);

        foreach ($results as $result) {
            $area = $this->model_localisation_area->getArea($result['province_code']);
            $china_area = $this->model_localisation_area->getChinaArea($result['china_area_id']);

            $data['factories'][] = array(
                'factory_id' => $result['factory_id'],
                'factory_name'          => $result['factory_name'],
                'area_name'             => $area['area_name'],
                'china_area_name'      => $china_area['china_area_name'],
                'sort_order'     => $result['sort_order'],
                'edit'           => $this->url->link('catalog/factory/edit', 'token=' . $this->session->data['token'] . '&factory_id=' . $result['factory_id'] . $url, 'SSL')
            );
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

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_title'] = $this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $factory_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($factory_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($factory_total - $this->config->get('config_limit_admin'))) ? $factory_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $factory_total, ceil($factory_total / $this->config->get('config_limit_admin')));

        $data['filter_factory_name'] = $filter_factory_name;
        $data['filter_province_code'] = $filter_province_code;
        $data['filter_china_area_id'] = $filter_china_area_id;

        $data['sort'] = $sort;
        $data['order'] = $order;

        $this->load->model('localisation/area');
        $areas = $this->model_localisation_area->getAreas('100000');
        $china_areas = $this->model_localisation_area->getChinaAreas();
        $data['areas'] = $areas;
        $data['china_areas'] = $china_areas;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/factory_list.tpl', $data));
    }

    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['factory_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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

        $data['help_keyword'] = $this->language->get('help_keyword');
        $data['help_bottom'] = $this->language->get('help_bottom');

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

        if (isset($this->error['factory_name'])) {
            $data['error_factory_name'] = $this->error['factory_name'];
        } else {
            $data['error_factory_name'] = '';
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['factory_id'])) {
            $data['action'] = $this->url->link('catalog/factory/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/factory/edit', 'token=' . $this->session->data['token'] . '&factory_id=' . $this->request->get['factory_id'] . $url, 'SSL');
        }

        //$data['cancel'] = $this->url->link('catalog/factory', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['cancel'] = "javascript:history.go(-1)";

        if (isset($this->request->get['factory_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $factory_info = $this->model_catalog_factory->getFactory($this->request->get['factory_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['factory_name'])) {
            $data['factory_name'] = $this->request->post['factory_name'];
        } elseif (!empty($factory_info)) {
            $data['factory_name'] = $factory_info['factory_name'];
        } else {
            $data['factory_name'] = '';
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($factory_info)) {
            $data['sort_order'] = $factory_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if (isset($this->request->post['province_code'])) {
            $data['province_code'] = $this->request->post['province_code'];
        } elseif (!empty($factory_info)) {
            $data['province_code'] = $factory_info['province_code'];
        } else {
            $data['province_code'] = '510000';
        }

        if (isset($this->request->post['china_area_id'])) {
            $data['china_area_id'] = $this->request->post['china_area_id'];
        } elseif (!empty($factory_info)) {
            $data['china_area_id'] = $factory_info['china_area_id'];
        } else {
            $data['china_area_id'] = '1';
        }

        $this->load->model('localisation/area');
        $areas = $this->model_localisation_area->getAreas('100000');
        $china_areas = $this->model_localisation_area->getChinaAreas();
        $data['areas'] = $areas;
        $data['china_areas'] = $china_areas;

        $this->load->model('design/layout');

        $data['layouts'] = $this->model_design_layout->getLayouts();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/factory_form.tpl', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/factory')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (utf8_strlen($this->request->post['factory_name']) < 3) {
            $this->error['factory_name'] = sprintf($this->language->get('error_factory_name'));
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
        if (!$this->user->hasPermission('modify', 'catalog/factory')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('setting/store');

        foreach ($this->request->post['selected'] as $factory_id) {

            $this->model_catalog_factory->delete($factory_id);
        }

        return !$this->error;
    }
}