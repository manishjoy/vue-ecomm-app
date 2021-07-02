<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
    header("Access-Control-Max-Age", "3600");
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    header("Access-Control-Allow-Credentials", "true");
    $db = mysqli_connect("localhost","root","Java@123","ecomm") or die("Connetction Error");
    include_once('helper.php');

?>