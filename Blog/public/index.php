<?php 
define("ROOT", 'http://localhost:8888/AdditionalProjects/Blog/public');

$url = $_GET['url'] ?? 'home';
$url = explode("/", $url);

$page_name = trim($url[0]);
$filename = "../app/pages/".$page_name.".php";

if(file_exists($filename)){
    require_once $filename;
} else {
    require_once "../app/pages/404.php";
}



