<?php
    $dir = realpath(__DIR__);
    include($dir.'/../config/dbConfig.php');
    include($dir.'/../models/users.php');
    $sql = "SELECT * FROM $users_table";
    $result = $conn -> query($sql);
    $count = 1; // Initial count
?>