<?php
    require_once __DIR__ . '/../models/users.php';
    try{
        $users = User::query()
            ->select('*')
            ->get();
        $count = 1; // Initial count
    }catch(Exception $e){
        echo $e->getMessage();
    }
?>