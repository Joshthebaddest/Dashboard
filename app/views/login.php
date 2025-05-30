<?php
    require_once __DIR__  .'/../controllers/loginController.php';
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My App</title>
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/custom.css">
    </head>

    <body class="">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-indigo-100">
                        <Lock class="h-6 w-6 text-indigo-600" />
                    </div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Sign in to your account
                    </h2>

                    <div class="text-center pt-2 font-semibold">
                        <?php if (!empty($errors)): ?>
                            <span class="text-red-600 text-xs">invalid credentials</span>
                        <?php endif; ?>
                    </div>
                </div>

                <form class="mt-8 space-y-6" action=<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?> method="post" id="signupform">
                    <div class="rounded-md shadow-sm space-y-4">
                        <div>
                            <label htmlFor="userInfo" class="block text-sm font-medium text-gray-700">
                                Email or Username:
                            </label>
                            <input 
                                class="border w-full rounded-lg outline-none p-2" 
                                type="text" 
                                name="userInfo" 
                                id="userInfo" 
                            />
                        </div>

                        <div>
                            <label htmlFor="password" class="block text-sm font-medium text-gray-700">
                                Password:
                            </label>
                            <input 
                                class="border rounded-lg w-full outline-none p-2" 
                                type="password" 
                                name="password" 
                                id="password"
                            />
                        </div>
                    </div>

                    <div class="p-5 px-2 w-full">
                        <button type="submit" class="font-medium w-full rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 px-4 py-2 text-base">
                            Submit
                        </button>
                    </div>
                    
                    <p class="text-center">Don't have an account? <a href="./signup" class="text-blue-600">Signup now</a></p>
                </form>
            </div>
        </div>
    </body>
</html>