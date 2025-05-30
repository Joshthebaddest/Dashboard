<?php
    if(!isset($_GET['user'])){
        header('Location: ../pages/dashboard.php');
        exit();
    }
    $user = $_GET['user'];
    $type = $_GET['type'];
    require_once __DIR__ . '/../controllers/userController.php';
?>

<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Edit your information
            </h2>
        </div>

        <form action="../controllers/fileUploadController.php" method="post" id="imgForm" enctype="multipart/form-data">
            <div class="flex mb-10">   
                <div class="relative w-24 h-24 mr-5">
                    <!-- Profile Image -->
                    <img
                        id="profileImg"
                        src="<?= !empty($row['profileImg']) ? $row['profileImg'] : 'https://ui-avatars.com/api/?name='.urldecode($username); ?>"
                        alt=""
                        class="w-full h-full object-cover rounded-full border border-gray-300"
                    />

                    <!-- Overlay -->
                    <label for="fileInput" class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                        <svg class="w-6 h-6 text-white mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A2 2 0 0122 9.618V18a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h5l2-2h4l2 2h5a2 2 0 012 2v3.618a2 2 0 01-2.447 1.894L15 10z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-4-4m0 0l4-4m-4 4h16" />
                        </svg>
                        <span class="text-white text-xs font-semibold">Change Photo</span>
                    </label>

                    <!-- File Input -->
                    <input id="fileInput" type="file" accept="image/*" name="file" class="hidden">
                </div>
                <button style="width: fit-content; height: fit-content" class="bg-gray-800 p-2 px-4 text-sm text-white rounded-lg my-auto" type="submit">Update Picture</button>
            </div>
        </form>

        <form class="mt-8 space-y-6" action="" method="post" id="signupform">
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label htmlFor="username" class="block text-sm font-medium text-gray-700">
                        Firstname:
                    </label>

                    <input 
                        class="border w-full rounded-lg outline-none p-2" 
                        type="text"
                        name="firstname"
                        id="firstname"
                        value="<?php echo htmlspecialchars($firstname) ?>"
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
                        value="<?php echo htmlspecialchars($lastname) ?>"
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
                        value="<?php echo htmlspecialchars($username) ?>"
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
                        value="<?php echo htmlspecialchars($email) ?>"
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
                        <option value="nigeria" <?php if($country == "nigeria") echo "selected" ?>>Nigeria</option>
                        <option value="ghana" <?php if($country == "ghana") echo "selected" ?>>Ghana</option>
                        <option value="others" <?php if($country == "others") echo "selected" ?>>Others</option>
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
                        <option value="male" <?php if($gender == "male") echo "selected" ?>>Male</option>
                        <option value="female" <?php if($gender == "female") echo "selected" ?>>Female</option>
                        <option value="others" <?php if($gender == "others") echo "selected" ?>>Others</option>
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
                        value="<?php echo htmlspecialchars($dob) ?>"
                    />
                    <!-- <span class="error-message">Must be a valid Date<span> -->
                    <?php if (!empty($errors["dob"])): ?>
                        <span class="text-red-600 text-xs"><?= htmlspecialchars($errors["dob"]) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="p-5 px-2 w-full flex gap-5">
                <button type="submit" class="font-medium text-center w-full rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer bg-gray-900 text-white hover:bg-indigo-700 focus:ring-indigo-500 px-4 py-2 text-base">
                    Submit
                    </button>
                <a href="/users" type="submit" class="font-medium text-center w-full rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer bg-red-600 text-white hover:bg-gray-700 focus:ring-indigo-500 px-4 py-2 text-base">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>