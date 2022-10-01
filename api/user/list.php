<?php

define('__CONFIG__', true);

require_once "../../inc/config.php";

header('Content-Type: application/json');

$allowedMethods = array('GET');
$requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

if (!in_array($requestMethod, $allowedMethods)) {
    header("405 Method Not Allowed", true, 405);
    exit("Method not allowed");
}

$response = [];
$response['result_code'] = 0;
$response['result_text'] = 'Success';
$response['data'] = null;

try {
    $users = new User();
    $response['data'] = $users->select('id', 'login', 'created_at', 'updated_at')->all();
} catch (Exception $e) {
    $response['result_code'] = -1;
    $response['result_text'] = $e->getMessage();
}

print json_encode($response, JSON_PRETTY_PRINT);
exit();