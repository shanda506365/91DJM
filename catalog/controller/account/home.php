<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/21
 * Time: 9:48
 */
class ControllerAccountHome extends Controller
{
    public function index()
    {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $data['meta_title'] = '账户中心 - ' . $this->config->get('config_name');
    }
}