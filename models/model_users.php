<?php

class Model_Users {

    // con
    private $con;
    // Table
    private $table = 'user_email';
    // Columns
    public $id;
    public $email;
    public $password;
    public $token;
    
    protected $hash_token;

    public function __construct($db) {
        $this->con = $db;
    }

    public function get_all_user() {
        $query = 'SELECT id, email, password_user, token FROM ' . $this->table;
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create_user() {
        $query = 'INSERT INTO ' . $this->table . 'SET '
                . 'email = :email, '
                . 'password_user = :password_user, '
                . 'token = :token';
        $stmt = $this->con->prepare($query);

        //sanitize 
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->token = htmlspecialchars(strip_tags($this->token));

        // bind data
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password_user', $this->password);
        $stmt->bindParam(':token', $this->token);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function get_detail_user() {
        $query = 'SELECT id, email, password_user, token FROM ' . $this->table . ' WHERE id = :id LIMIT 0,1';
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $data_row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->email = $data_row['email'];
        $this->password = $data_row['password_user'];
        $this->token = $data_row['token'];
    }

    public function update_user() {
        $query = 'UPDATE ' . $this->table . ' SET '
                . ' email = :email, '
                . ' password_user = :password,'
                . ' token = :token '
                . 'WHERE '
                . ' id = :id';
        $stmt = $this->con->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->token = htmlspecialchars(strip_tags($this->token));

        // bind data
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':token', $this->token);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete_user() {
        $query = 'DELETE FROM '.$this->table.' WHERE id= :id';
        
        $stmt = $this->con->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    public function uniqidReal($lenght = 13) {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
            
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}
