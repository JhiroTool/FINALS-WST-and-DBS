<?php

class Database {
    private $host = "localhost";
    private $db_name = "guest_accommodation_system";
    private $username = "root";
    private $password = ""; // Change if your MySQL has a password
    public $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->db_name
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Optional: Get the connection
    public function getConnection() {
        return $this->conn;
    }
}
?>