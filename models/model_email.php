<?php

class Model_Email {

    // con
    private $con;
    // Table
    private $table = 'sending_email';
    // Columns
    public $id;
    public $email;
    public $description;
    public $status;
    public $ip_client;
    public $location;

    public function __construct($db) {
        $this->con = $db;
    }

    public function get_all_email() {
        $query = 'SELECT id, email, description, status, ip_client, location FROM ' . $this->table;
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create_email() {
        $query = 'INSERT INTO ' . $this->table . 'SET '
                . 'email = :email, '
                . 'description = :description, '
                . 'status = :status, '
                . 'ip_client = :ip_client, '
                . 'location = :location';
        $stmt = $this->con->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->ip_client = htmlspecialchars(strip_tags($this->ip_client));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // bind data

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':ip_client', $this->ip_client);
        $stmt->bindParam(':location', $this->location);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function get_detail_email() {
        $query = 'SELECT id, email, description, status, ip_client, location FROM ' . $this->table . ' WHERE id = :id LIMIT 0,1';
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $data_row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->email = $data_row['email'];
        $this->ip_client = $data_row['ip_client'];
        $this->description = $data_row['description'];
        $this->status = $data_row['status'];
        $this->location = $data_row['location'];
        
    }

    public function update_email() {
        $query = 'UPDATE ' . $this->table . ' SET '
                . 'email = :email, '
                . 'description = :description, '
                . 'status = :status, '
                . 'ip_client = :ip_client, '
                . 'location = :location'
                . 'WHERE '
                . ' id = :id';
        $stmt = $this->con->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->ip_client = htmlspecialchars(strip_tags($this->ip_client));
        $this->location = htmlspecialchars(strip_tags($this->location));

        // bind data
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':ip_client', $this->ip_client);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':id', $this->id);

        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete_email() {
        $query = 'DELETE FROM '.$this->table.' WHERE id= :id';
        
        $stmt = $this->con->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

}
