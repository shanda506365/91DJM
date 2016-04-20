<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/20
 * Time: 15:54
 */
class ControllerOrderOrderFile extends Controller {
    public function upload() {

        $order_id = $this->request->post['order_id'];

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
            //$file = $filename . '.' . token(32);
            $file = token(32).'.'.$this->request->files['file']['type'];

            //加上年月目录
            if (!is_dir(DIR_UPLOAD . date('Ym'))) {
                mkdir(DIR_UPLOAD . date('Ym'));
            }

            $real_path = DIR_UPLOAD . date('Ym') .'\\' . $file;

            move_uploaded_file($this->request->files['file']['tmp_name'], $real_path);

            $file_size = filesize($real_path);

            // Hide the uploaded file name so people can not link to it directly.
            $this->load->model('tool/upload');

            $upload_id = $this->model_tool_upload->addUpload($filename, $file, $file_size);

            $this->load->model('order/order_file');

            $this->model_order_order_file->addOrderFile($order_id, $upload_id);

            //$json['suc'] = $this->language->get('text_upload');

            $json = array(
                'suc' => true,
                'msg' => '上传成功',
                'data' => array(
                    'file_id' => $upload_id,
                    'file_name' => $filename,
                    'size'  => $file_size,
                    'delete_url' => $this->url->link('order/order_file/delete', 'file_id=' . $upload_id, '')
                )
            );

            echo json_encode($json, JSON_UNESCAPED_SLASHES);exit;
        }

//        $this->response->addHeader('Content-Type: application/json');
//        $this->response->setOutput(json_encode($json));


    }

    //删除文件
    public function delete() {
        $file_id = (int)$this->request->get['file_id'];

        $this->load->model('tool/upload');
        $this->load->model('order/order_file');

        $file_info = $this->model_tool_upload->getUpload($file_id);

        $this->model_tool_upload->deleteUpload($file_id);
        $this->model_order_order_file->deleteOrderFile($file_id);

        @unlink(DIR_UPLOAD . 'order/'. date('Ym', strtotime($file_info['date_added'])) . '/' . $file_info['filename']);

        output_success("文件删除成功");
    }
}