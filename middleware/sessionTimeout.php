<?php
    $dir = realpath(__DIR__);
    require($dir.'/../config/sessionConfig.php');
    //set session timeout duration 
    // $timeout_duration = 1800; //30 min

    // //check if session is still valid based on last activity
    // if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration){
    //     include($dir."/../controllers/logoutController.php");
    // }

    // //update last activity timestamp
    // $_SESSION['last_activity'] = time(); //update last activity time to current time
?>