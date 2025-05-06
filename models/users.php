<?php 
    $dir = realpath(__DIR__);
    include($dir.'/../config/dbConfig.php');
    $users_table = "TechUsers";

    $sql = "CREATE TABLE IF NOT EXISTS $users_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(225) NOT NULL,
        lastname VARCHAR(225) NOT NULL,
        username VARCHAR(225) NOT NULL UNIQUE,
        email VARCHAR(50) NOT NULL UNIQUE, 
        date_of_birth DATE NOT NULL,
        country VARCHAR(100) NOT NULL,
        gender VARCHAR(100) NOT NULL,
        password_hash VARCHAR(225) NOT NULL,
        role ENUM('admin', 'editor', 'user') NOT NULL DEFAULT 'user',
        profileImg VARCHAR(225),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE){
        // echo("Table $users_table created sucessfully");
    }else{
        echo("error creating table".$conn->error);
        $conn->close();
    }
?>