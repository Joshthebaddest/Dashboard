<?php 
    $dir = realpath(__DIR__);
     require_once __DIR__ .'/../../config/globalConfig.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET") {
   
        require($dir.'/../../config/sessionConfig.php');
        session_unset();
        session_destroy();

        header("Location: ". BASE_PATH);
        exit();
    }
?>
