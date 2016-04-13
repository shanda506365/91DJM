<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/13
 * Time: 11:26
 */
class ControllerCheckoutOrderFile extends Controller {
    public function index() {

        $order_id = (int)$this->request->post['file_id'];

        $this->load->language('tool/upload');

        $json = array();

        if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
            // Sanitize the filename
            $filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

            // Validate the filename length
            if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
                $json['error'] = $this->language->get('error_filename');
            }

            // Allowed file extension types
            $allowed = array();

            $extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

            $filetypes = explode("\n", $extension_allowed);

            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }

            if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
                $json['error'] = $this->language->get('error_filetype');
            }

            // Allowed file mime types
            $allowed = array();

            $mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

            $filetypes = explode("\n", $mime_allowed);

            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }

            if (!in_array($this->request->files['file']['type'], $allowed)) {
                $json['error'] = $this->language->get('error_filetype');
            }

            // Check to see if any PHP files are trying to be uploaded
            $content = file_get_contents($this->request->files['file']['tmp_name']);

            if (preg_match('/\<\?php/i', $content)) {
                $json['error'] = $this->language->get('error_filetype');
            }

            // Return any upload error
            if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
                $json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
            }
        } else {
            $json['error'] = $this->language->get('error_upload');
        }

        if (!$json) {
            $file = $filename . '.' . token(32);

            $size = filesize(DIR_UPLOAD . $file);

            move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file);

            // Hide the uploaded file name so people can not link to it directly.
            $this->load->model('tool/upload');

            //$json['code'] = $this->model_tool_upload->addUpload($filename, $file, $size);

            //$json['success'] = $this->language->get('text_upload');

            $file_id = $this->model_tool_upload->addUpload($filename, $file, $size);

            $this->load->model('checkout/order');
            $this->model_checkout_order->addOrderFile($order_id, $file_id);

            $data = array(
                'file_id' => $file_id,
                'file_name' => $filename,
                'size' => format_bytes($size)
            );

            $json = array(
                'suc' => true,
                'data' => $data,
                'msg' => ''
            );
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function delete($file_id) {
        $this->load->model('checkout/order');
        $this->model_checkout_order->deleteOrderFile($file_id);

        $this->load->model('tool/upload');

        $file_info = $this->model_tool_upload->getUpload($file_id);

        $this->model_tool_upload->deleteUpload($file_id);


    }
}