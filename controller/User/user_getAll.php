<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");

 include_once '../../config/connection.php';
 include_once '../../models/model_users.php';
 
 $database = new Connection();
 $db = $database->openConnection();
 
 $user_model = new Model_Users($db);
 
 $stmt = $user_model->get_all_user();
 $count_users = $stmt->rowCount();
 
 echo json_encode($count_users);
 
 if ($count_users > 0) {
      $userArr = array();
      $userArr['body'] = array();
      $userArr['userCount'] = $count_users;
      
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $e = array(
            'id'=> $user_model->id,
            'email' => $user_model->email,
            'password' => $user_model->password,
            'token' => $user_model->token,
          );
          array_push($userArr['body'], $e);
      }
      $database->closeConnection();
      echo json_encode($userArr);
      
 } else {
     http_response_code(404);
     $database->closeConnection();
     echo json_encode(
             array(
                 'message' => 'No Record Found'
    ));
 }