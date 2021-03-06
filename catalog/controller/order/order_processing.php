<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2016/4/26
 * Time: 16:18
 */
class ControllerOrderOrderProcessing extends Controller {

    private $dir_upload = 'order_processing';

    //登录验证
    protected function check_login() {
        //未登录跳转到登录页面
        if (!$this->user->isLogged()) {
            output_error('未登录不能执行该操作');
        }
    }

    public function upload() {

        $this->check_login();

        $order_id = (int)$this->request->get['order_id'];

        $this->load->language('tool/upload');

        $json = array();

        if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
            // Sanitize the filename
            //$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['files']['name'][0], ENT_QUOTES, 'UTF-8')));
            $filename = $this->request->files['file']['name'];

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
                $msg = '文件后缀不对';
            }
//前期只判断后缀，后面再加上安全的文件类型验证
//            // Allowed file mime types
//            $allowed = array();
//
//            $mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));
//
//            $filetypes = explode("\n", $mime_allowed);
//
//            foreach ($filetypes as $filetype) {
//                $allowed[] = trim($filetype);
//            }
//
//            if (!in_array($this->request->files['files']['type'][0], $allowed)) {
//                $msg = '文件类型不对';
//            }

            // Check to see if any PHP files are trying to be uploaded
            $content = file_get_contents($this->request->files['file']['tmp_name']);

            if (preg_match('/\<\?php/i', $content)) {
                $msg = $this->language->get('error_filetype');
            }

            // Return any upload error
            if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
                $msg = $this->language->get('error_upload_' . $this->request->files['file']['error']);
            }
            if (isset($msg)) {
                output_error($msg);
            }
        } else {
            $msg = $this->language->get('error_upload');
            output_error($msg);
        }

        if (!$json) {
            $file = $filename . '.' . token(32);
            //$suffix = get_extension($this->request->files['files']['name'][0]);
            //$file = token(32).'.'.$suffix;

            //加上年月目录
            if (!is_dir(DIR_UPLOAD . $this->dir_upload . '\\' . date('Ym'))) {
                mkdir(DIR_UPLOAD . $this->dir_upload . '\\' . date('Ym'));
            }

            $real_path = DIR_UPLOAD . $this->dir_upload . '\\' . date('Ym') .'\\' . $file;

            move_uploaded_file($this->request->files['files']['tmp_name'][0], $real_path);

            $file_size = filesize($real_path);

            // Hide the uploaded file name so people can not link to it directly.
            $this->load->model('tool/upload');

            $upload_id = $this->model_tool_upload->addUpload($filename, $this->dir_upload,  $file, $file_size);

            $this->load->model('order/order_file');

            $this->model_order_order_file->addOrderFile($order_id, $upload_id);

            //$json['suc'] = $this->language->get('text_upload');

            $json = array(
                'suc' => true,
                'msg' => '上传成功',
                'data' => array(
                    0 => array(
                        'file_id' => $upload_id,
                        'file_name' => $filename,
                        'size'  => format_bytes($file_size),
                        'delete_url' => $this->url->link_simple('order/order_file/delete', 'upload_id=' . $upload_id, ''),
                        'url' => ''
                    )
                )
            );

            echo json_encode($json, JSON_UNESCAPED_SLASHES);exit;
        }

//        $this->response->addHeader('Content-Type: application/json');
//        $this->response->setOutput(json_encode($json));


    }

    //删除文件
    public function delete() {
        $this->check_login();

        $upload_id = (int)$this->request->get['upload_id'];

        $this->load->model('tool/upload');
        $this->load->model('order/order_file');

        $file_info = $this->model_tool_upload->getUpload($upload_id);

        $this->model_tool_upload->deleteUpload($upload_id);
        $this->model_order_order_file->deleteOrderFile($upload_id);

        @unlink(DIR_UPLOAD . 'order/'. date('Ym', strtotime($file_info['date_added'])) . '/' . $file_info['filename']);

        output_success("文件删除成功");
    }
}