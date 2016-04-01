<?php
// HTTP
define('HTTP_SERVER', 'http://djm.com/admin/');
define('HTTP_CATALOG', 'http://djm.com/');

// HTTPS
define('HTTPS_SERVER', 'http://djm.com/admin/');
define('HTTPS_CATALOG', 'http://djm.com/');

// DIR
//define('DIR_ROOT', 'E:/djm/');
define('DIR_ROOT', dirname(__FILE__) . '/../');
define('DIR_FRONT', 'catalog');

define('DIR_APPLICATION',  DIR_ROOT . 'admin/');
define('DIR_SYSTEM',        DIR_ROOT . 'system/');
define('DIR_LANGUAGE',      DIR_ROOT . 'admin/language/');
define('DIR_TEMPLATE',      DIR_ROOT . 'admin/view/template/');
define('DIR_CONFIG',        DIR_ROOT . 'system/config/');
define('DIR_IMAGE',         'E:/djm/image/');
define('DIR_CACHE',         DIR_ROOT . 'system/storage/cache/');
define('DIR_DOWNLOAD',      DIR_ROOT . 'system/storage/download/');
define('DIR_LOGS',          DIR_ROOT . 'system/storage/logs/');
define('DIR_MODIFICATION', DIR_ROOT . 'system/storage/modification/');
define('DIR_UPLOAD',        DIR_ROOT . 'system/storage/upload/');
define('DIR_CATALOG',       DIR_ROOT . DIR_FRONT . '/');

// DB
require_once(DIR_ROOT . 'config_db.php');
