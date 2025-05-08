<?php
    $dir = realpath(__DIR__);
    include($dir.'/../data.php');
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userInfo = test_input($_POST["userInfo"]);
        $password = test_input($_POST["password"]);

        include($dir.'/../models/users.php');
        if(empty($_POST["userInfo"] || empty($_POST["password"]))){
            $error = "please enter a valid field";
        }else{
            $sql = "SELECT username, email, password_hash, role FROM $users_table WHERE email = ? or username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $userInfo, $userInfo);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if($result->num_rows > 0){
                $username = $row['username'];
                $email = $row['email'];
                $passwordHash = $row['password_hash'];
                $role = $row['role'];

                $verify = password_verify($password, $passwordHash);
                if($verify){
                    require('../config/sessionConfig.php');
                    $_SESSION['user'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    // redirect to homepage
                    header("Location: ../pages/home.php");
                    $conn->close();
                    exit();
                }else{
                    $errors['error'] = 'invalid credentials';
                    $conn->close();
                }
            }
            $errors['error'] = 'invalid credentials';
            $conn->close();
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
