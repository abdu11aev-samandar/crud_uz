<?php

define('__CONFIG__', true);

require_once "../../inc/config.php";

header('Content-Type: application/json');

$allowedMethods = array('DELETE');
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
    Request::validate($request, ['user_id']);

    $user = new User();

    $found_user = $user->find($request['user_id']);
    if (!isset($found_user->id)) {
        header("User Not Found", true, 404);
        throw new Exception('User Not Found');
    }

    $delete_user = $response['data'] = $user->delete($request['user_id']);
    if (!$delete_user) {
        throw new Exception('User delete error');
    }

    $response['data'] = $delete_user;
} catch (Exception $e) {
    $response['result_code'] = -1;
    $response['result_text'] = $e->getMessage();
}

print json_encode($response, JSON_PRETTY_PRINT);
exit();