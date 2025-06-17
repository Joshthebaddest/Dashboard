<?php
    class Database {
        private $host;
        private $db_name;
        private $username;
        private $password;
        public $conn;

        public function __construct() {
            $host = $_SERVER['HTTP_HOST'] ?? 'cli';

            if ($host === 'localhost') {
                // Development (local)
                $this->host = 'localhost';
                $this->db_name = 'myDB';
                $this->username = 'root';
                $this->password = '';
            } else {
                // Production (Render, etc.)
                $this->host = getenv('DB_HOST');
                $this->db_name = getenv('DB_NAME');
                $this->username = getenv('DB_USER');
                $this->password = getenv('DB_PASSWORD');
            }
        }

        public function connect() {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            $this -> conn->set_charset("utf8mb4");
            return $this->conn;
        }
    }
?>


