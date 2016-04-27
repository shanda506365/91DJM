<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/27
 * Time: 10:12
 */
class ModelCustomerCustomerDesigner extends Model
{
    public function getCustomerDesigner($customer_id)
    {
        $this->db_ci->where('customer_id', $customer_id);
        $query = $this->db_ci->get('customer_designer');
        return $query->first_row();
    }
}