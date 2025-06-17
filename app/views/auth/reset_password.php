<?php
    include_once __DIR__ . '/../../../config/globalConfig.php';
    $error = '';
    $success = '';
    $token_valid = false;
    $token = '';

    if (isset($_GET['token'])) {
        $token = htmlspecialchars($_GET['token']);
        $tokenHash = hash('sha256', $token);
        require_once __DIR__ . '/../../models/users.php';
        require_once __DIR__ . '/../../models/password_reset_token.php';

        $prt = PasswordResetTokens::query()
            ->select('user_email', 'expires_at')
            ->where('token_hash', $tokenHash)
            ->first();

        $currentDateTime = date('Y-m-d H:i:s');
        if($prt['expires_at'] > $currentDateTime){
            $token_valid = true;
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $email = $prt['user_email'];
                
                if ($password !== $confirm_password) {
                    $error = 'Passwords do not match';
                } elseif (strlen($password) < 6) {
                    $error = 'Password must be at least 6 characters long';
                } else {
                    // Update password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $user = User::update(['email' => $email], ['password_hash' => $hashed_password]);
                    
                    // Delete the used token
                    $prt = PasswordResetTokens::delete(['token_hash' => $tokenHash]);
                    
                    $success = 'Password reset successfully! You can now log in with your new password.';
                    $token_valid = false; // Hide the form
                }
            }
        } else {
            $error = 'Invalid or expired reset token.';
        }
    } else {
        $error = 'No reset token provided.';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My App</title>
        <link rel="stylesheet" href="<?= BASE_PATH ?>css/style.css">
        <link rel="stylesheet" href="<?= BASE_PATH ?>css/custom.css">     
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest/dist/lucide.min.js"></script>
    </head>
    <body class="">
        <?php if(!isset($_GET['token'])): ?>
            <?php include_once __DIR__ . "/confirmation.php" ?>
        <?php else: ?>
            <div class="min-h-screen flex items-center justify-center">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            Reset Your Password
                        </h2>
                    </div>
                    
                    <?php if ($token_valid): ?>
                        <form class="mt-8 space-y-6" method="POST">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div>
                                    <input name="password" type="password" required 
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                                        placeholder="New Password">
                                </div>
                                <div>
                                    <input name="confirm_password" type="password" required 
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                                        placeholder="Confirm New Password">
                                </div>
                            </div>

                            <?php if ($error): ?>
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <div>
                                <button 
                                    type="submit" 
                                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="mt-8">
                            <?php if ($error): ?>
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                    <div class="flex items-center">
                                        <i data-lucide="x-circle" class="h-5 w-5 mr-2"></i>
                                        <?php echo htmlspecialchars($error); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($success): ?>
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                    <div class="flex items-center">
                                        <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
                                        <?php echo htmlspecialchars($success); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="text-center">
                        <a href="<?= BASE_PATH ?>auth/login" class="font-medium text-blue-600 hover:text-blue-500">
                            Back to Login
                        </a>
                    </div>
                    
                    <div class="text-center">
                        <a href="<?= BASE_PATH ?>" class="font-medium text-gray-600 hover:text-gray-500">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        <?php endif ?>
        
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
