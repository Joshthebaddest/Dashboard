<?php    
    $sql = "SELECT profileImg FROM $users_table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>
<!-- Header -->
<header class="bg-white border-b border-gray-200 h-16">
    <div class="h-full px-4 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <h1 class="text-xl font-semibold text-gray-900">PBUY</h1>
        </div>

        <div class="relative space-x-4 group mr-10">
            <div class="flex items-center space-x-2">
                <img
                    src="<?= !empty($row['profileImg']) ? $row['profileImg'] : 'https://ui-avatars.com/api/?name='.urldecode($user); ?>"
                    alt="<?= $user ?>"
                    class="w-8 h-8 rounded-full"
                />
                <div class="text-sm flex gap-2">
                    <p class="font-medium text-gray-700">Hi <?=$user?>!</p>
                    <i class="h-4 w-4 mt-1" data-lucide="chevron-down"></i>
                </div>
            </div>

            <div class="absolute z-50 left-0 p-1 space-y-2 shadow-lg bg-gray-100 rounded-lg border w-full text-center font-bold text-xl opacity-0 group-hover:opacity-100 hover:opacity-100">
                <ul>
                    <li>
                        <a class="block px-4 py-2 bg-gray-200 text-gray-800 text-left rounded-lg text-sm hover:bg-gray-800 hover:text-white" href="./profile.php">Profile</a>
                    </li>
                </ul>
                <div class="font-normal text-sm gap-5 text-center w-full">
                    <form action="../controllers/logoutController.php" method="post">
                        <button class="flex gap-2 px-4 py-1 bg-red-600 rounded-lg text-white w-full h-8 hover:bg-red-800" type="submit"> <i class="w-4 h-4 mt-1" data-lucide="log-out"></i>  Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header end -->