<?php 

    $dir = realpath(__DIR__);
    include($dir.'/../config/dbConfig.php');
    include($dir.'/../models/users.php');
    include($dir.'/../data.php');
    $errors = [];
    
    $user = isset($user) ? $user : $_GET['user'];
    if(!$user){
        header('Location: ../views/home.php');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($type) && $type == "edit"){
            $sql = "SELECT * FROM $users_table WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $username = $row['username'];
            $email = $row['email'];
            $country = $row['country'];
            $gender = $row['gender'];
            $dob = $row['date_of_birth'];
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_GET['type']) && $_GET['type'] == "edit"){
            $firstname = test_input($_POST["firstname"]);
            $lastname = test_input($_POST["lastname"]);
            $username = test_input($_POST["username"]);
            $email = test_input($_POST["email"]);
            $country = test_input($_POST["country"]);
            $gender = test_input($_POST["gender"]);
            $dateOfBirth = test_input($_POST["dob"]);

            validate_form($firstname, $lastname, $username, $email, $country, $gender, $dateOfBirth);

            if (empty($errors)) {
                include('../models/users.php');

                $sql = "UPDATE $users_table SET firstname = ?, lastname = ?, username = ?, email = ?, country = ?, gender = ?, date_of_birth = ? WHERE ID = ?";
                $result = $conn->prepare($sql);
                $result -> bind_param("sssssssi", $firstname, $lastname, $username, $email, $country, $gender, $dateOfBirth, $userId);
                if ($result->execute()) {
                    echo "New record updated successfully";
                    echo($_SERVER['HTTP_REFERER']);
                    if(isset($_SERVER['HTTP_REFERER'])){
                        echo($_SERVER['HTTP_REFERER']);
                        header('Location: ../views/home.php');
                    }   
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                // print_r($errors); // to debug
            }
        }
        if(isset($_GET['type']) && $_GET['type'] == "delete"){
            $sql = "DELETE FROM $users_table WHERE id = ?";
            $result = $conn->prepare($sql);
            $result->bind_param("i", $userId);
            if($result->execute()){
                echo "New record deleted successfully";
                header('Location: ../views/home.php');
            }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_form($firstname, $lastname, $username, $email, $country, $gender, $dateOfBirth) {
        global $errors;

        if (empty($firstname)) {
            $errors["firstname"] = "First Name is required";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
            $errors["firstname"] = "Only letters and white space allowed";
        }
        if (empty($lastname)) {
            $errors["lastname"] = "Last Name is required";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
            $errors["lastname"] = "Only letters and white space allowed";
        }
        if (empty($username)) {
            $errors["username"] = "Username is required";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
            $errors["username"] = "Only letters and white space allowed";
        }

        if (empty($email)) {
            $errors["email"] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format";
        }

        if (empty($country)) {
            $errors["country"] = "Country is required";
        }

        if (empty($gender)) {
            $errors["gender"] = "Gender is required";
        }
        if (empty($dateOfBirth)) {
            $errors["dob"] = "Date of Birth is required";
        }
    }

?>