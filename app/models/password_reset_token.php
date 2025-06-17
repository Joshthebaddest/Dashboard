<?php 
    require_once __DIR__ .'/../../config/models.php';

    class PasswordResetTokens extends Model {
        protected static $table = 'password_reset_tokens';

        protected static $rules = [
            'user_email' => 'string|required',
            'token_hash' => 'string|required',
            'expires_at' => 'date|required',
        ];
    }
?>