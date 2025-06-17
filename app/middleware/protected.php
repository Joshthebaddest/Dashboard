<?php
   $dir = realpath(__DIR__);
    require_once __DIR__ .'/../../config/globalConfig.php';
    require($dir.'/sessionTimeout.php');
    if(isset($_SESSION["user"])) {
        require_once __DIR__ . '/../models/users.php';
        try{
            $user = $_SESSION["user"];
            $user = User::query()
                ->select('username', 'role', 'profileImg')
                ->where('username', $user)
                ->first();
            if(empty($user)) header("Location: ". BASE_PATH . "auth/login");
            $_SESSION["role"] = $user["role"];
            $_SESSION["profile_img"] = $user["profileImg"];
        }catch(Exception $e){
            echo $e->getMessage();
        }
    } else {
        header("Location: ". BASE_PATH ."auth/login");
        exit();
    }
?>