<?php
    include_once __DIR__ . '/../../config/globalConfig.php';
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
            try{
                $user = User::query()
                    ->select('username', 'email', 'password_hash', 'email_verified', 'role')
                    ->where('email', $userInfo)
                    ->orWhere('username', $userInfo)
                    ->first();
                if(!empty($user)){
                    if($user['email_verified'] === 1){
                        $username = $user['username'];
                        $email = $user['email'];
                        $passwordHash = $user['password_hash'];
                        $role = $user['role'];

                        $verify = password_verify($password, $passwordHash);
                        if($verify){
                            require_once __DIR__ . '/../../config/sessionConfig.php';
                            $_SESSION['user'] = $username;
                            $_SESSION['email'] = $email;
                            $_SESSION['role'] = $role;
                            $_SESSION['toast'] = [
                                'message' => 'Logged in successfully!',
                                'type' => 'success' // success | error | info
                            ];

                            // redirect to homepage
                            header("Location: " .BASE_PATH ."dashboard");
                            exit();
                        }else{
                            $errors['error'] = 'invalid credentials';
                        }
                    }else{
                        $rawToken = bin2hex(random_bytes(32)); // 64 characters (256 bits)
                        $tokenHash = hash('sha256', $rawToken);
                        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
                        $email = $user['email'];

                        User::update(['email' => $email], ['email_verification_token' => $tokenHash, 'email_verification_expires' => $expires_at]);
                        header('Location: '. BASE_PATH .'auth/verify-email?token='. urlencode($rawToken));
                        exit();
                    }
                }
                $errors['error'] = 'invalid credentials';
                $_SESSION['toast'] = [
                    'message' => 'invalid credentials!',
                    'type' => 'success' // success | error | info
                ];
            }catch(Exception $e){
                echo $e->getMessage();
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
