<?php

define('__CONFIG__', true);

require_once "../../inc/config.php";

header('Content-Type: application/json');

$allowedMethods = array('PUT');
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
    $request = (array)json_decode(file_get_contents('php://input'));
    Request::validate($request, ['user_id', 'login', 'password']);

    $users = new User();
    $response['data']=$users->find($request['user_id'],['id','login','created_at','updated_at']);

    if (!isset($users->id)){
        header("Not Found",true,404);
        throw new Exception('Requested user not found');
    }
} catch (Exception $e) {
    $response['result_code'] = -1;
    $response['result_text'] = $e->getMessage();
}

print json_encode($response, JSON_PRETTY_PRINT);
exit();