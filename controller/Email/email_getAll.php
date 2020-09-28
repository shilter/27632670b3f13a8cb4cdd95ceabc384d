<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");

 include_once '../../config/connection.php';
 include_once '../../models/model_email.php';
 
 $database = new Connection();
 $db = $database->openConnection();
 
 $email_model = new Model_Email($db);
 
 $stmt = $email_model->get_all_email();
 $count_email = $stmt->rowCount();
 
 echo json_encode($count_email);
 
 
 if ($count_email > 0) {
      $emailArr = array();
      $emailArr['body'] = array();
      $emailArr['emailCount'] = $count_email;
      
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $e = array(
            'id'=> $email_model->id,
            'email' => $email_model->email,
            'description' => $email_model->description,
            'status' => $email_model->status,
            'ip_client' => $email_model->ip_client,
            'location' => $email_model->location,
          );
          array_push($emailArr['body'], $e);
      }
      $database->closeConnection();
      echo json_encode($emailArr);
      
 } else {
     http_response_code(404);
     $database->closeConnection();
     echo json_encode(
             array(
                 'message' => 'No Record Found'
             ));
 }