<?php
 require_once __DIR__ .'/../../config/globalConfig.php';
    $loggedInUser = $_SESSION["user"];
    $profileImg = $_SESSION["profile_img"];
?>

<div class="flex h-screen bg-gray-100">
    <!-- sidebar -->
    <div class="flex flex-col h-screen w-64 bg-gray-900 text-white">
        <div class="p-4">
            <h1 class="text-xl font-bold">PBUY</h1>
        </div>

        <nav class="flex-1 px-2 py-4">
            <ul class="space-y-2">
                <li class="rounded-lg">
                    <a class="flex gap-2 cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="<?= BASE_PATH ?>dashboard">
                        <i class="h-5 w-5 mt-1" data-lucide="layout-dashboard"></i>    
                        Dashboard
                    </a>
                </li>
                <?php if(in_array($_SESSION['role'], ['super_admin', 'admin'])): ?>
                <li class="rounded-lg">
                    <a class="flex gap-2 cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="<?= BASE_PATH ?>dashboard/users">
                        <i class="h-5 w-5 mt-1" data-lucide="users"></i>    
                        Users
                    </a>
                </li>
                <?php endif; ?>
                <li class="rounded-lg">
                    <a class="flex gap-2 cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="<?= BASE_PATH ?>dashboard/products">
                        <i class="h-5 w-5 mt-1" data-lucide="package"></i>    
                        Products
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <a class="rounded-lg flex cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors flex gap-2" href="<?= BASE_PATH ?>dashboard/settings">  
                <i class="h-4 w-4 mt-1" data-lucide="settings"></i>    
                Settings
            </a>

            <form action="../controllers/logoutController.php" method="post">
                <button 
                    class="flex gap-2 items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition-colors"  
                >
                    <i class="w-4 h-4 mt-1" data-lucide="log-out"></i> Logout
                </button>
            </form>
        </div>
    </div>
    <!-- sidebar end -->

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 h-16">
            <div class="h-full px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-semibold text-gray-900">PBUY</h1>
                </div>

                <div class="relative space-x-4 group mr-10">
                    <div class="flex items-center space-x-2">
                        <img
                            src="<?= !empty($profileImg) ? $profileImg : 'https://ui-avatars.com/api/?name='.urldecode($loggedInUser); ?>"
                            alt="<?= $loggedInUser ?>"
                            class="w-8 h-8 rounded-full"
                        />
                        <div class="text-sm flex gap-2">
                            <p class="font-medium text-gray-700">Hi <?=$loggedInUser?>!</p>
                            <i class="h-4 w-4 mt-1" data-lucide="chevron-down"></i>
                        </div>
                    </div>

                    <div class="absolute z-50 left-0 p-1 space-y-2 shadow-lg bg-gray-100 rounded-lg border w-full text-center font-bold text-xl opacity-0 group-hover:opacity-100 hover:opacity-100">
                        <ul>
                            <li>
                                <a class="block px-4 py-2 bg-gray-200 text-gray-800 text-left rounded-lg text-sm hover:bg-gray-800 hover:text-white" href="./profile">Profile</a>
                            </li>
                        </ul>
                        <div class="font-normal text-sm gap-5 text-center w-full">
                            <form action="<?= BASE_PATH ?>auth/logout" method="post">
                                <button class="flex gap-2 px-4 py-1 bg-red-600 rounded-lg text-white w-full h-8 hover:bg-red-800" type="submit"> <i class="w-4 h-4 mt-1" data-lucide="log-out"></i>  Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Header end -->
        <div class="p-5 px-10 text-center w-full overflow-auto relative">
            <div class="text-left pb-10 px-10"> 
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>