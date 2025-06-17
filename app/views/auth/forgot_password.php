<?php
    include_once __DIR__ . '/../../../config/globalConfig.php';

    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = htmlspecialchars($_POST['email']);
        require_once __DIR__ . '/../../models/users.php';
        try{
            $user = User::query()
                ->select('id', 'username', 'email_verified')
                ->where('email', $email)
                ->first();

            print_r($user['username']);
            if (!empty($user)) {
                if ($user['email_verified'] == 1) {
                    // Generate reset token
                    $rawToken = bin2hex(random_bytes(32)); // 64 characters (256 bits)
                    $tokenHash = hash('sha256', $rawToken);
                    $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    require_once __DIR__ . '/../../models/password_reset_token.php';

                    PasswordResetTokens::delete(['user_email' => $email]);
                    
                    // Insert new reset token
                    PasswordResetTokens::create([
                        'user_email' => $email,
                        'token_hash' => $tokenHash,
                        'expires_at' => $expires_at
                    ]);

                    echo($rawToken);
            //             // Send reset email
            //             if ($emailService->sendPasswordResetEmail($email, $user['username'], $reset_token)) {
            //                 $success = 'Password reset instructions have been sent to your email address.';
            //             } else {
            //                 $error = 'Failed to send reset email. Please try again.';
            //             }
                } else {
                    $error = 'Please verify your email address first before resetting your password.';
                }
            } else {
                // Don't reveal if email exists or not for security
                $success = 'If an account with that email exists, password reset instructions have been sent.';
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
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
    </head>

    <body class="">
        <div class="min-h-screen flex items-center justify-center">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Reset Your Password
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Enter your email address and we'll send you a link to reset your password.
                    </p>
                </div>
                <form class="mt-8 space-y-6" method="POST">
                    <div>
                        <input name="email" type="email" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                            placeholder="Email address">
                    </div>

                    <?php if ($error): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <button 
                            type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Send Reset Link
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="<?= BASE_PATH ?>auth/login" class="font-medium text-blue-600 hover:text-indigo-500">
                            Back to Login
                        </a>
                    </div>

                    <div class="text-center">
                        <a href="<?= BASE_PATH ?>" class="font-medium text-gray-600 hover:text-gray-500">
                            Back to Home
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>