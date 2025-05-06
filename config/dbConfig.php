<?php
    $servername = "localhost";
    $sqlusername = "root";
    $sqlpassword = "";
    $dbname= "myDB";
    $connected = false;

    // Create connection
    $conn = new mysqli($servername, $sqlusername, $sqlpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $connected = true;
?>
