<?php 
    $dir = realpath(__DIR__);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET") {
   
        require($dir.'/../../config/sessionConfig.php');
        session_unset();
        session_destroy();

        header("Location: /apps/public/");
        exit();
    }
?>
