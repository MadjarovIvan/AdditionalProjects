<?php 
session_start();
require "../app/core/init.php";
// echo "<pre>";
// print_r($_SERVER);

$url = $_GET['url'] ?? 'home';
$str = strtolower($url);
$url = explode("/", $url);

$page_name = trim($url[0]);
$filename = "../app/pages/".$page_name.".php";

if(file_exists($filename)){
    require $filename;
} else {
    require_once "../app/pages/404.php";
}



