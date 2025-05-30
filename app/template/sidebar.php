<!-- sidebar -->
<div class="flex flex-col h-screen w-64 bg-gray-900 text-white">
    <div class="p-4">
        <h1 class="text-xl font-bold">PBUY</h1>
    </div>

    <nav class="flex-1 px-2 py-4">
        <ul class="space-y-2">
            <li class="rounded-lg">
                <a class="flex gap-2 cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="./dashboard">
                    <i class="h-5 w-5 mt-1" data-lucide="layout-dashboard"></i>    
                    Dashboard
                </a>
            </li>
            <li class="rounded-lg">
                <a class="flex gap-2 cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="./users">
                    <i class="h-5 w-5 mt-1" data-lucide="users"></i>    
                    Users
                </a>
            </li>
            <li class="rounded-lg">
                <a class="flex gap-2 cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="./products">
                    <i class="h-5 w-5 mt-1" data-lucide="package"></i>    
                    Products
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-4 border-t border-gray-800">
        <a class="rounded-lg flex cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors flex gap-2" href="./settings">  
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