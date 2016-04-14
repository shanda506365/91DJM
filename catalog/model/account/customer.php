<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data) {
		$this->event->trigger('pre.customer.add', $data);

		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

        $salt = token(9);
        $customer = array(
            'customer_group_id' => (int)$customer_group_id,
            'store_id' => (int)$this->config->get('config_store_id'),
            'mobile' => $data['mobile'],
            'nick_name' => '',
            'picture' => '',
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'telephone' => '',
            'fax' => '',
            'custom_field' => '',
            'salt' => $salt,
            'password' => md5($data['password'] . $salt),
            'newsletter' => 0,
            'ip' => $this->request->server['REMOTE_ADDR'],
            'status' => 1,
            'approved' => (int)!$customer_group_info['approval'],
            'date_added' => date('Y-m-d')
        );
        $this->db_ci->insert('customer', $customer);

        $customer_id = $this->db_ci->insert_id();

		$this->event->trigger('post.customer.add', $customer_id);

		return $customer_id;
	}

	public function editCustomer($data) {
		$this->event->trigger('pre.customer.edit', $data);

		$customer_id = $this->customer->getId();

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$this->event->trigger('post.customer.edit', $customer_id);
	}

	public function editPassword($email, $password) {
		$this->event->trigger('pre.customer.edit.password');

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		$this->event->trigger('post.customer.edit.password');
	}

	public function editNewsletter($newsletter) {
		$this->event->trigger('pre.customer.edit.newsletter');

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		$this->event->trigger('post.customer.edit.newsletter');
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

		return $query->row;
	}

	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}

    public function getTotalCustomersByTelephone($telephone) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(telephone) = '" . $this->db->escape(utf8_strtolower($telephone)) . "'");

        return $query->row['total'];
    }

    public function getTotalCustomersByMobile($mobile) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(mobile) = '" . $this->db->escape(utf8_strtolower($mobile)) . "'");

        return $query->row['total'];
    }

	public function getRewardTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row['total'];
	}

	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->rows;
	}

//	public function addLoginAttempt($email) {
//		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
//
//		if (!$query->num_rows) {
//			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
//		} else {
//			$this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
//		}
//	}
//
//	public function getLoginAttempts($email) {
//		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
//
//		return $query->row;
//	}
//
//	public function deleteLoginAttempts($email) {
//		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
//	}
    public function addLoginAttempt($mobile) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE mobile = '" . $this->db->escape(utf8_strtolower((string)$mobile)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

        if (!$query->num_rows) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET mobile = '" . $this->db->escape(utf8_strtolower((string)$mobile)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
        }
    }

    public function getLoginAttempts($mobile) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE mobile = '" . $this->db->escape(utf8_strtolower($mobile)) . "'");

        return $query->row;
    }

    public function deleteLoginAttempts($mobile) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE mobile = '" . $this->db->escape(utf8_strtolower($mobile)) . "'");
    }

    public function getCustomerDesigner($customer_id) {
        $this->db_ci->where('customer_id', $customer_id);
        $query = $this->db_ci->get('customer_designer');
        return $query->first_row();
    }

    public function getCustomerCompany($customer_id) {
        $this->db_ci->where('customer_id', $customer_id);
        $query = $this->db_ci->get('customer_company');
        return $query->first_row();
    }

    public function getCustomerDesignersByIds($ids = array()) {
        if (empty($ids)) {
            return array();
        }
        $this->db_ci->select('a.*, b.designer_name');
        $this->db_ci->from('customer a');
        $this->db_ci->join('customer_designer b', 'a.customer_id = b.customer_id');
        $this->db_ci->where_in('a.customer_id', $ids);
        $query = $this->db_ci->get();
        return $query->result_array();
    }
}
