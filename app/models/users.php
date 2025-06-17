<?php 
    require_once __DIR__ .'/../../config/models.php';

    class User extends Model {
        protected static $table = 'users';

        protected static $rules = [
            'firstname' => 'string|required',
            'lastname' => 'string|required',
            'username' => 'string|required|unique:techusers,username',
            'email' => 'string|required|unique:techusers,email', 
            'date_of_birth' => 'date|required',
            'country' => 'string|required',
            'gender' => 'string|required',
            'password_hash' => 'string|required',
            // 'role' => 'enum:admin,editor,user',
            'profileImg' => 'string',
            'email_verification_token' => 'string',
            'email_verification_expires' => 'date',
        ];
    }
?>