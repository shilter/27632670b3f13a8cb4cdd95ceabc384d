<?php

class Connection {

    private $server = 'localhost';
    private $user = 'emailuser';
    private $pass = 'emailsend';
    private $databases = 'email_send';
    private $port = 5432;
    protected $con;
    protected $dsn;

    public function openConnection() {
        try {
            $this->dsn = 'pgsql:host='.$this->server.';port='.$this->port.';dbname='.$this->databases.';user='.$this->user.';password='.$this->pass;
            $this->con = new PDO($this->dsn);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->con;
        } catch (PDOException $exc) {
            echo "Error. ".$exc->getMessage();
        }
    }

    public function closeConnection() {
        $this->con = null;
        $this->dsn = null;
    }

}
