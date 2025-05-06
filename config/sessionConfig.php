<?php
    if(session_status() === 1){
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_strict_mode', 1);
        ini_set('session.gc_maxlifetime', 1800);

        session_set_cookie_params([
            'lifetime' => 0,
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Strict',
        ]);
        session_start();
    }
?>