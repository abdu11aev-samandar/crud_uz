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

    $user = new User();
    $updated_user = $response['data'] = $user->update($request['user_id'], [
        'login' => $request['login'],
        'password' => $request['password']
    ]);

    if (!$updated_user) {
        throw new Exception('User update error');
    }
} catch (Exception $e) {
    $response['result_code'] = -1;
    $response['result_text'] = $e->getMessage();
}

print json_encode($response, JSON_PRETTY_PRINT);
exit();