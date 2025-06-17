
<?php
    include_once __DIR__ . '/../../../config/globalConfig.php';
    $message = '';
    $success = false;

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $providedHash = hash('sha256', $token);

        require_once __DIR__ . '/../../models/users.php';

        try {
            $user = User::query()
                ->select('id', 'username', 'email', 'email_verified', 'email_verification_expires')
                ->where('email_verification_token', $providedHash)
                ->first();

            if(!empty($user)){
                $currentDateTime = date('Y-m-d H:i:s');
                if ($user['email_verified'] == 1) {
                    $message = 'Your email has already been verified. You can now log in.';
                    $success = true;
                }elseif($user['email_verification_expires'] < $currentDateTime){
                    $message = 'Invalid or expired verification token.';
                }else{
                    $email = $user['email'];
                    User::update(['email' => $email], ['email_verified' => 1, 'email_verification_token' => '', 'email_verification_expires' => NULL]);
                    $message = 'Email verified successfully! You can now log in to your account.';
                    $success = true;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        $message = 'No verification token provided.';
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
                    <div class="text-center">
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                            Email Verification
                        </h2>
                    </div>
                    
                    <div class="mt-8">
                        <div class="<?php echo $success ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'; ?> border px-4 py-3 rounded">
                            <?php if ($success): ?>
                                <div class="flex items-center">
                                    <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
                                    <?php echo htmlspecialchars($message); ?>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center">
                                    <i data-lucide="x-circle" class="h-5 w-5 mr-2"></i>
                                    <?php echo htmlspecialchars($message); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="<?= BASE_PATH ?>auth/login" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 inline-block">
                                Go to Login
                            </a>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="<?= BASE_PATH ?>" class="text-gray-600 hover:text-gray-800">
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
