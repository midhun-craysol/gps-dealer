<?php


define("UPLOAD_PATH", __DIR__ . "/../uploads/");

define("MODEL_BASE_PATH", PROJECT_ROOT_PATH."/models/base/");
define("MODEL_PATH", PROJECT_ROOT_PATH."/models/");


$site_end = strpos($_SERVER['SCRIPT_NAME'], '/site') +8;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $site_end);

define("WWW_ROOT", $doc_root);
$url      = "http://" . $_SERVER['HTTP_HOST'] . WWW_ROOT;
$validURL = str_replace("&", "&amp", $url);
$validURL = "http://localhost/dealer_app/";
define("BASE_URL", $validURL);


?>