<?php
    require_once __DIR__ . '/../controllers/signupController.php';
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
                        Sign up for an account
                    </h2>
                </div>

                <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?> method="post" class="" id="signupform">
                    <div class="p-2 w-full space-y-2">

                <form class="mt-8 space-y-6" action=<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?> method="post" id="signupform">
                    <div class="rounded-md shadow-sm space-y-4">
                        <div>
                            <label htmlFor="username" class="block text-sm font-medium text-gray-700">
                                Firstname:
                            </label>

                            <input 
                                class="border w-full rounded-lg outline-none p-2" 
                                type="text" t
                                name="firstname"
                                id="firstname"
                            />
                            <!-- <span class="error-message">Must be a valid username<span> -->
                            <?php if (!empty($errors["firstname"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["firstname"]) ?></span>
                            <?php endif; ?>
                        </div>
                    

                        <div>
                            <label htmlFor="lastname" class="block text-sm font-medium text-gray-700">
                                Lastname:
                            </label>
                            <input 
                                class="border w-full rounded-lg outline-none p-2" 
                                type="text" 
                                name="lastname"
                                id="lastname"
                            />
                            <!-- <span class="error-message">Must be a valid username<span> -->
                            <?php if (!empty($errors["lastname"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["lastname"]) ?></span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label htmlFor="username" class="block text-sm font-medium text-gray-700">
                                Username:
                            </label>
                            <input 
                                class="border w-full rounded-lg outline-none p-2" 
                                type="text" 
                                name="username"
                                id="username"
                            />
                            <!-- <span class="error-message">Must be a valid username<span> -->
                            <?php if (!empty($errors["username"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["username"]) ?></span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label htmlFor="email" class="block text-sm font-medium text-gray-700">
                                Email:
                            </label>
                            <input 
                                class="border w-full rounded-lg outline-none p-2" 
                                type="email" 
                                name="email" 
                                id="email" 
                            />
                            <!-- <span class="error-message">Must be a valid email<span> -->
                            <?php if (!empty($errors["email"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["email"]) ?></span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label htmlFor="country" class="block text-sm font-medium text-gray-700">
                                Country:
                            </label>
                            <select class="border rounded-lg w-full outline-none p-2" id="country" name="country" >
                                <option value="" selected>Select your country</option>
                                <option value="nigeria">Nigeria</option>
                                <option value="ghana">Ghana</option>
                                <option value="others">Others</option>
                            </select>
                            <!-- <span class="error-message">Please select a country<span> -->
                            <?php if (!empty($errors["country"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["country"]) ?></span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label htmlFor="username" class="block text-sm font-medium text-gray-700">
                                Gender:
                            </label>
                            <select class="border rounded-lg w-full outline-none p-2" id="gender" name="gender">
                                <option value="" selected>Select your Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>
                            <!-- <span class="error-message">Please specify your gender <span> -->
                            <?php if (!empty($errors["gender"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["gender"]) ?></span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label htmlFor="username" class="block text-sm font-medium text-gray-700">
                                Date Of Birth:
                            </label>
                            <input 
                                class="border w-full rounded-lg outline-none p-2" 
                                type="date" 
                                name="dob" 
                                id="dob" 
                            />
                            <!-- <span class="error-message">Must be a valid Date<span> -->
                            <?php if (!empty($errors["dob"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["dob"]) ?></span>
                            <?php endif; ?>
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
                            <!-- <span class="error-message">Must have at least one uppercase, one Lowercase, one number, and one special character.<span> -->
                            <?php if (!empty($errors["password"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["password"]) ?></span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label htmlFor="confirmPassword" class="block text-sm font-medium text-gray-700">
                                Confirm Password:
                            </label>
                            <input 
                                class="border rounded-lg w-full outline-none p-2" 
                                type="password" 
                                name="confirm_password" 
                                id="confirmPassword"
                            />
                            <!-- <span class="error-message">Password must match<span> -->
                            <?php if (!empty($errors["confirm_password"])): ?>
                                <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["confirm_password"]) ?><span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="p-5 px-2 w-full">
                        <button type="submit" class="font-medium w-full rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 px-4 py-2 text-base">
                            Submit
                        </button>
                    </div>
                    
                    <p class="text-center">Already have an account? <a href="./login" class="text-blue-600">Login now</a></p>
                </form>
            </div>
        </div>
    </body>
</html>