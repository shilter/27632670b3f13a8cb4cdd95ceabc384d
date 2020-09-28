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

$email->id = isset($_GET['id']) ? $_GET['id'] : null;

$email->get_detail_email();

if ($email->email != null) {
    $email_arr = array(
        'id' => $email->id,
        'email' => $email->email,
        'description' => $email->description,
        'ip_client' => $email->ip_client,
        'location' => $email->location,
        'status' => $email->status
    );
    http_response_code(200);
    $database->closeConnection();
    echo json_encode($email_arr);
} else {
    http_response_code(404);
    $database->closeConnection();
    echo json_encode(array(
                 'message' => 'No Record Found'
             ));
}