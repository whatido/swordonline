<?php

date_default_timezone_set("asia/ho_chi_minh");
$root = realpath(dirname(__FILE__));
$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
if ($domain === "onering.ga" || $domain === "neverdie.tk") {
    $url = "https://";
} else {
    $url = "http://";
}

$root = str_replace("\\", '/', $root);
$url .= $domain;
define('BASE_URL', $url . '/');
define('BASE_ADMIN_URL', BASE_URL."admin/");
define('MEDIA_NAME',"public/media/"); //Tên đường dẫn lưu media
define('MEDIA_PATH',$root . DIRECTORY_SEPARATOR . MEDIA_NAME); //Đường dẫn lưu media
define('MEDIA_URL', BASE_URL . MEDIA_NAME);

if ($domain === "onering.ga" || $domain === "neverdie.tk") {
    define('DB_DEFAULT_HOST', 'localhost'); //DB HOST
    define('DB_DEFAULT_USER', 'neverdie_users'); //DB USER
    define('DB_DEFAULT_PASSWORD', 'neverdie_users'); //DB PASSWORD
    define('DB_DEFAULT_NAME', 'neverdie_data'); //DB NAME
} else {
    define('DB_DEFAULT_HOST', 'localhost'); //DB HOST
    define('DB_DEFAULT_USER', 'root'); //DB USER
    define('DB_DEFAULT_PASSWORD', ''); //DB PASSWORD
    define('DB_DEFAULT_NAME', 'swordonline'); //DB NAME
}

define('login_max_attempts', '10'); //Bảo trì
define('MAINTAIN_MODE', FALSE); //Bảo trì
define('DEBUG_MODE', $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $domain === "swordonline.test" ? true : false);
//Cache manager
define('CACHE_MODE', TRUE);
define('CACHE_ADAPTER', (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') ? 'memcached' : 'file');
define('CACHE_PREFIX_NAME', 'MY_');