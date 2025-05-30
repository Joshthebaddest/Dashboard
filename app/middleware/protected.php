<?php
   $dir = realpath(__DIR__);
    require($dir.'/sessionTimeout.php');
    if(isset($_SESSION["user"])) {
        include($dir.'/../models/users.php');
        $user = $_SESSION["user"];
        $sql = "SELECT username, role, profileImg FROM $users_table WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(empty($row)) header("Location: /apps/public/");
        $_SESSION["role"] = $row["role"];
    } else {
        header("Location: /apps/public/");
        exit();
    }
?>