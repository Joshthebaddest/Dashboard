<?php 
    $dir = realpath(__DIR__);
    require_once __DIR__ . '/../models/users.php';
    include($dir.'/../data.php');
    $errors = [];
    
    $user = isset($user) ? $user : $_GET['user'];
    if(!$user){
        header('Location: ../pages/home.php');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($type) && $type == "edit"){
            try{
                $user = User::query()
                    ->select('*')
                    ->where('username', $user)
                    ->first();

                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $username = $user['username'];
                $email = $user['email'];
                $country = $user['country'];
                $gender = $user['gender'];
                $dob = $user['date_of_birth'];
            }catch(Exception $e){
                echo $e->getMessage();
            }
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
                try{
                    User::update(['id' => $userId], [
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'email' => $email,
                        'country' => $country,
                        'gender' => $gender,
                        'date_of_birth' => $dateOfBirth
                    ])
        
                    echo($_SERVER['HTTP_REFERER']);
                    if(isset($_SERVER['HTTP_REFERER'])){
                        echo($_SERVER['HTTP_REFERER']);
                        header('Location: ../pages/home.php');
                    }   
                    exit();
               }catch(Exception $e){
                    echo $e->getMessage();
                }
            }
        }
        if(isset($_GET['type']) && $_GET['type'] == "delete"){
            try{
                User::delete(['id' => $userId]);
                echo "New record deleted successfully";
            }catch(Exception $e){
                echo $e->getMessage()
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