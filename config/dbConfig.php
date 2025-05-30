<?php
    // $servername = "localhost";
    // $sqlusername = "root";
    // $sqlpassword = "";
    // $dbname= "myDB";
    // $connected = false;

    // Create connection
    // $conn = new mysqli($servername, $sqlusername, $sqlpassword, $dbname);

    // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    // $connected = true;

    $host = getenv('DB_HOST');
    $db   = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Optional: set charset
    $conn->set_charset("utf8mb4");
?>
