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

if ($user->delete_user()) {
    $database->closeConnection();
    http_response_code(200);
    echo json_encode(array('message' => 'Success Delete User')); 
} else {
    $database->closeConnection();
    http_response_code(404);
    echo json_encode(array('message' => 'Failed Delete User')); 
}