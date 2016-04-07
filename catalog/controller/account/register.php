<?php
class ControllerAccountRegister extends Controller {
	private $error = array();

	public function index() {
		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', 'SSL'));
		}

		$this->load->language('account/register');

		//$this->document->setTitle($this->language->get('heading_title'));
        $data['meta_title'] = $this->language->get('heading_title');

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$customer_id = $this->model_account_customer->addCustomer($this->request->post);

			// Clear any previous login attempts for unregistered accounts.
			$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);

			$this->customer->login($this->request->post['email'], $this->request->post['password']);

			unset($this->session->data['guest']);

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $customer_id,
				'name'        => $this->request->post['firstname'] . ' ' . $this->request->post['lastname']
			);

			$this->model_account_activity->addActivity('register', $activity_data);

			$this->response->redirect($this->url->link('account/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_register'),
			'href' => $this->url->link('account/register', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

        if (isset($this->error['exist'])) {
            $json = array(
                'success' => false,
                'msg' => $this->error['exist'],
                'code' => 99
            );
            output_json($json);
        }

        if (isset($this->error['telephone'])) {
            $json = array(
                'success' => false,
                'msg' => $this->error['telephone'],
                'code' => 99
            );
            output_json($json);
        }

        if (isset($this->error['password'])) {
            $json = array(
                'success' => false,
                'msg' => $this->error['password'],
                'code' => 99
            );
            output_json($json);
        }

        if (isset($this->error['confirm'])) {
            $json = array(
                'success' => false,
                'msg' => $this->error['confirm'],
                'code' => 99
            );
            output_json($json);
        }

		$data['action'] = $this->url->link('account/register', '', 'SSL');

		$data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$data['customer_groups'][] = $customer_group;
				}
			}
		}

		if (isset($this->request->post['customer_group_id'])) {
			$data['customer_group_id'] = $this->request->post['customer_group_id'];
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		if (isset($this->request->post['newsletter'])) {
			$data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$data['newsletter'] = '';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}

//		$data['column_left'] = $this->load->controller('common/column_left');
//		$data['column_right'] = $this->load->controller('common/column_right');
//		$data['content_top'] = $this->load->controller('common/content_top');
//		$data['content_bottom'] = $this->load->controller('common/content_bottom');
//		$data['footer'] = $this->load->controller('common/footer');
//		$data['header'] = $this->load->controller('common/header');

        $this->load->view('register.html', $data);
	}

	private function validate() {
//		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
//			$this->error['email'] = $this->language->get('error_email');
//		}

		if ($this->model_account_customer->getTotalCustomersByTelephone($this->request->post['mobile'])) {
			$this->error['exist'] = '该手机号已被注册！';
		}

		if ((utf8_strlen($this->request->post['mobile']) != 11)) {
			$this->error['mobile'] = '手机号码必须为11位数字！';
		}

		// Customer Group
		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		// Custom field validation
		$this->load->model('account/custom_field');

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
				$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
			}
		}

		if ((utf8_strlen($this->request->post['password']) < 6) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = '密码必须是 6 至 20 字符之间！';
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = '两次输入的密码不同！';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		// Agree to terms
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}

		return !$this->error;
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    public function getSmsRandom() {
        $mobile = trim($this->request->get['mobile']);

        if (is_mobile($mobile) == false) {
            output_error("电话号码必须11位数");
        }

        $this->load->helper("sms");
        $code = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
        $this->session->data['register_code'] = $code;
        $pars = array(
            "code" => $code,
            "product" => "搭积木"
        );
        $result = send_sms($mobile, $pars, SMS_TPL_REGISTER, date("Y-m-d H:i:s"));
        if ($result) {
            if ($result->success) {

            }
        }
        //$this->session->data['payment_address'] =
    }

    public function doRegister() {

        $this->load->model('account/customer');

        $mobile = trim($this->request->get['mobile']);

        if (is_mobile($mobile) == false) {
            output_error("电话号码必须11位数！");
        }

        if ($this->model_account_customer->getTotalCustomersByMobile($this->request->post['mobile'])) {
            output_error("该手机号已被注册！");
        }

        // Customer Group
        if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $this->request->post['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $password = trim($this->request->post['password']);
        if ((utf8_strlen($password) < 6) || (utf8_strlen($password) > 20)) {
            output_error('密码必须是 6 至 20 字符之间！');
        }

        $confirm = trim($this->request->post['confirm']);
        if ($confirm != $password) {
            output_error('两次输入的密码不同！');
        }

        $random = trim($this->request->post['random']);
        if ($this->session->data['register_code'] != $random) {
            output_error('短信验证码错误！');
        }

        $data = array(
            'customer_group_id' => $customer_group_id,
            'mobile'    => $mobile,
            'password' => $password
        );

        $customer_id = $this->model_account_customer->addCustomer($data);

        if (!$this->customer->login($mobile, $this->request->post['password'])) {

            $this->model_account_customer->addLoginAttempt($mobile);

            output_error("帐号密码有误！");

        } else {
            $this->model_account_customer->deleteLoginAttempts($mobile);
        }

        // Add to activity log
        $this->load->model('account/activity');

        $activity_data = array(
            'customer_id' => $this->customer->getId(),
            'name'        => $this->customer->getMobile()
        );

        $this->model_account_activity->addActivity('login', $activity_data);

        output_success("注册成功！");
    }
}
