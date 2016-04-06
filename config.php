<?php
// HTTP
define('HTTP_SERVER', 'http://djm.com/');

// HTTPS
define('HTTPS_SERVER', 'http://djm.com/');

define('DIR_FRONT', 'catalog');

// DIR
//define('DIR_ROOT', 'E:/djm/');
define('DIR_ROOT', dirname(__FILE__) . '/');

define('DIR_APPLICATION',   DIR_ROOT . DIR_FRONT . '/');
define('DIR_SYSTEM',        DIR_ROOT . 'system/');
define('DIR_LANGUAGE',      DIR_ROOT . DIR_FRONT . '/language/');
//define('DIR_TEMPLATE',      DIR_ROOT . DIR_FRONT . '/view/theme/');
define('DIR_TEMPLATE',      DIR_ROOT . 'dist/');
define('DIR_CONFIG',        DIR_ROOT . 'system/config/');
//define('DIR_IMAGE',         'E:/djm/image/');
define('DIR_IMAGE',         dirname(__FILE__) . '/image/');

define('DIR_CACHE',         DIR_ROOT . 'system/storage/cache/');
define('DIR_DOWNLOAD',      DIR_ROOT . 'system/storage/download/');
define('DIR_LOGS',          DIR_ROOT . 'system/storage/logs/');
define('DIR_MODIFICATION', DIR_ROOT . 'system/storage/modification/');
define('DIR_UPLOAD',        DIR_ROOT . 'system/storage/upload/');

// DB
require_once(DIR_ROOT . 'config_common.php');
