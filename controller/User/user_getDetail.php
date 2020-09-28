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

$users = new Model_Users($db);

$users->id = isset($_GET['id']) ? $_GET['id'] : null;

$users->get_detail_user();

if ($users->email != null) {
    $user_arr = array(
        'id' => $users->id,
        'email' => $users->email,
        'password' => $users->password,
        'token' => $users->token,
    );
    http_response_code(200);
    $database->closeConnection();
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    $database->closeConnection();
    echo json_encode(array(
       'message' => 'No Record Found'
    ));
}