<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/connection.php';
include_once '../../models/model_users.php';

$database = new Connection();
$db = $database->openConnection();

$user = new Model_Users($db);

$data = json_decode(file_get_contents('php://input'));

$user->id = $data->id;

$user->email = $data->email;
$user->password = md5($data->password);
$user->token = $user->uniqidReal();

if($user->update_user()) {
    http_response_code(200);
    $database->closeConnection();
    echo json_encode(array('message' => 'Success Edit User'));    
} else {
    http_response_code(404);
    $database->closeConnection();
    echo json_encode(array('message' => 'Failed Edit User'));    
}