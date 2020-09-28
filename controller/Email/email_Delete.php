<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../config/connection.php';
include_once '../../models/model_email.php';

$database = new Connection();
$db = $database->openConnection();

$email = new Model_Email($db);

$data = json_decode(file_get_contents('php://input'));

$email->id = $data->id;

if ($email->delete_email()) {
    $database->closeConnection();
    http_response_code(200);
    echo json_encode(array('message' => 'Success Delete Email')); 
} else {
    $database->closeConnection();
    http_response_code(404);
    echo json_encode(array('message' => 'Failed Delete Email')); 
}