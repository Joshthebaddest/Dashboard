<?php
    class Database {
        private $host = 'localhost';
        private $db_name = 'myDB';
        private $username = 'root';
        private $password = '';
        public $conn;

        public function connect() {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }

            return $this->conn;
        }
    }

    // $host = getenv('DB_HOST');
    // $db   = getenv('DB_NAME');
    // $user = getenv('DB_USER');
    // $pass = getenv('DB_PASSWORD');

    // // Create connection
    // $conn = new mysqli($host, $user, $pass, $db);

    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    // // Optional: set charset
    // $conn->set_charset("utf8mb4");
?>


