<?php
    class Database {
        private $host = getenv('DB_HOST');
        private $db_name = getenv('DB_NAME');
        private $username = getenv('DB_USER');
        private $password = getenv('DB_PASSWORD');
        // private $host = 'localhost';
        // private $db_name = 'myDB';
        // private $username = 'root';
        // private $password = '';
        // public $conn;

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


