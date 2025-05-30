<?php
    $dir = realpath(__DIR__);
    $role_hierarchy = [
        'super_admin' => 4,
        'admin'       => 3,
        'editor'      => 2,
        'user'        => 1,
    ];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $role = test_input($_POST['role']);
        $username = test_input($_POST['username']);

        $allowed_roles = ['admin', 'editor', 'user'];
        if (!in_array($role, $allowed_roles)) {
            die("Invalid role selected.");
        }

        require($dir.'/../middleware/protected.php');
        if(isset($_SESSION["user"])){
            $user = $_SESSION["user"];
            include($dir.'/../models/users.php');
            if($result->num_rows > 0){
                $current_user_role = $_SESSION["role"]; // or from DB
                
                if (
                    isset($role_hierarchy[$current_user_role], $role_hierarchy[$role]) &&
                    $role_hierarchy[$current_user_role] >= $role_hierarchy[$role]
                ) {
                    $sql = "UPDATE $users_table SET role = ? WHERE username = ?";
                    $result = $conn->prepare($sql);
                    $result -> bind_param("ss", $role, $username);
                    if ($result->execute()) {
                        echo "New record updated successfully";
                        header("Location: ../pages/home.php");
                        $conn->close();
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                        $conn->close();
                    }
                } else {
                    die("You do not have permission to assign this role.");
                }
            }
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>