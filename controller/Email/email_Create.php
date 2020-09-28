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

$data  = json_decode(file_get_contents('php://input'));

$email->email =  $data->email;
$email->description = $data->description;
$email->ip_client = $data->ip_client;
$email->location = $data->location;
$email->status = $data->status;

if ($email->create_email()) {
    http_response_code(200);
    $database->closeConnection();
    echo json_encode(array('message' => 'Success Create Email'));
} else {
    http_response_code(404);
    $database->closeConnection();
    echo json_encode(array('message' => 'Failed Create Email'));
}
