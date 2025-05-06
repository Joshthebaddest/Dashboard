<?php   
    require('../middleware/protected.php');
    include('../controllers/homeController.php');
    $allowed_roles = ['admin', 'editor', 'user'];
    $role_hierarchy = [
        'super_admin' => 4,
        'admin'       => 3,
        'editor'      => 2,
        'user'        => 1,
    ];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My App</title>
        <link rel="stylesheet" href="../public/css/style.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        tbody tr:hover {background-color: #D6EEEE;}
        .container{
            width: 100%;
            height: 300px;
            overflow: auto;
        }
        .btn{
            height: fit-content;
            font-size: 12px;
            color: white;
            border-radius: 5px;
            padding: 5px 10px;
        }
    </style>
    </head>

    <body class="">
        <div class="flex h-screen bg-gray-100">
            <!-- sidebar -->
            <div class="flex flex-col h-screen w-64 bg-gray-900 text-white">
                <div class="p-4">
                    <h1 class="text-xl font-bold">PBUY</h1>
                </div>
            
                <nav class="flex-1 px-2 py-4">
                    <ul class="space-y-2">
                        <li class="rounded-lg">
                            <a class="flex cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="./profile.php">Profile</a>
                        </li>
                        <li class="rounded-lg">
                            <a class="flex cursor-pointer items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors" href="./home.php">Dashboard</a>
                        </li>
                    </ul>
                </nav>

                <div class="p-4 border-t border-gray-800">
                    <form action="../controllers/logoutController.php" method="post">
                        <button 
                            class="flex items-center w-full px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors"  
                        >
                            Logout
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
                                    src="<?= !empty($row['profileImg']) ? $row['profileImg'] : 'https://ui-avatars.com/api/?name='.urldecode($user); ?>"
                                    alt="<?= $user ?>"
                                    class="w-8 h-8 rounded-full"
                                />
                                <div class="text-sm">
                                    <p class="font-medium text-gray-700">Hi <?=$user?>!</p>
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
                                        <button class=" bg-gray-900 rounded-lg text-white w-full h-8 hover:bg-gray-800" type="submit">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- Header end -->

                <div class="p-5 px-10 text-center w-full relative">
                    <div class="text-left pb-10 px-10"> 
                        <div>
                            <h3 class="text-center font-bold text-3xl">Dashboard</h3>
                            <?php if($result -> num_rows > 0): ?>
                                <div style="height: 400px" class='py-5 overflow-auto'>
                                    <table>
                                        <thead class="text-gray-500 border-b text-sm font-normal border-gray-200 hover:bg-gray-50">
                                            <tr>
                                                <th class="py-3 px-6 text-left whitespace-nowrap"></th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">FIRSTNAME</th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">LASTNAME</th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">USERNAME</th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">EMAIL</th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">COUNTRY</th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">GENDER</th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">DATE OF BIRTH</th>
                                                <?php if(isset($_SESSION["role"]) && $_SESSION["role"] !== "user"): ?>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">ROLE</th>
                                                <th class="py-3 px-6 text-left whitespace-nowrap">ACTION</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php while($row = $result -> fetch_assoc()): ?>
                                                <tr class='text-sm text-gray-700'>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$count++?></td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['firstname']?></td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['lastname'] ?></td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['username']?></td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['email']?></td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['country']?></td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['gender']?></td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['date_of_birth']?></td>
                                                    <?php if(isset($_SESSION["role"]) && $_SESSION["role"] !== "user"): ?>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        <div class='relative h-fit w-24 font-semibold'>
                                                            <div class='h-fit rounded-xl dropdown-selector cursor-pointer'>
                                                                <div
                                                                    class='flex justify-between bg-white border p-2 w-full text-center rounded-xl'
                                                                >
                                                                    <p class='text-sm capitalize'><?= $row['role'] ?></p>
                                                                    <div class='pt-1' >
                                                                        <ChevronDown class='h-4 w-4 opacity-50' />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php if(isset($role_hierarchy[$_SESSION["role"]], $role_hierarchy[$row["role"]]) && $role_hierarchy[$_SESSION["role"]] > $role_hierarchy[$row["role"]]): ?>
                                                            <div class="hidden absolute w-full z-10 dropdown">
                                                                <div class='p-1 rounded-xl border bg-white'> 
                                                                    <?php foreach($allowed_roles as $role): ?> 
                                                   
                                                                    <div 
                                                                        class="<?= isset($_SESSION["role"]) && $_SESSION["role"] === "editor" && $role === "admin" ? "hidden" : "flex" ?> gap-2 p-1 px-2 hover:bg-gray-300 rounded-xl cursor-pointer"
                                                                    >
                                                                        <form action="../controllers/roleController.php" method="POST">
                                                                            <input type="hidden" name="username" value="<?= $row["username"] ?>">
                                                                            <input type="hidden" name="role" value="<?= $role ?>">
                                                                            <button type="submit" class="text-sm block capitalize font-semibold"><?= $role ?></button>
                                                                        </form>
                                                                    </div>
                                                                  
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <?php if(isset($role_hierarchy[$_SESSION["role"]], $role_hierarchy[$row["role"]]) && $role_hierarchy[$_SESSION["role"]] > $role_hierarchy[$row["role"]]): ?>
                                                    <td class="flex gap-2 py-3 px-6 text-left whitespace-nowrap"> 
                                                        <a href="./editUser.php?id=<?=$row['id']?>&type=edit" class='edit btn bg-gray-600'>edit</a>
                                                        <?php if(isset($_SESSION["role"]) && ($_SESSION["role"] === "admin" || $_SESSION["role"] === "super_admin")): ?>
                                                        <button type="submit" class='delete btn bg-red-600'>delete</a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php endif; ?>
                                                    <?php endif; ?>

                                                    <div id="popup" class="hidden w-full h-screen bg-gray-800 fixed left-0 opacity-60 top-0 z-50"></div>
                                                    <div id="popup-message" style="width: fit-content; top: 35%; left: 25%; right: 25%" class="hidden z-50 opacity-100 fixed shadow-lg p-5 rounded-lg mx-auto bg-gray-200">
                                                        <p>Are you sure you want to delete this user?</p>
                                                        <div style="width: fit-content" class="flex gap-5 py-2 mx-auto">
                                                            <form action="../controllers/userController.php?id=<?=$row['id']?>&type=delete" method="POST">
                                                                <button type="submit" style="width: 50px; height: 25px" class="popup-btn bg-red-600 text-white rounded-lg text-sm">Yes</button>
                                                            </form>
                                                            <button style="width: 50px; height: 25px" class="popup-btn bg-gray-500 text-white rounded-lg text-sm">No</button>
                                                        </div>
                                                    </div>
                                                </tr>
                                            <?php endwhile;?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- <div class="flex flex-col md:flex-row items-center justify-center gap-10 mt-4 space-y-2 md:space-y-0"> -->
                                    <!-- Page Info -->
                                    <!-- <div class="text-sm text-gray-800">
                                        Showing page <span class="font-medium">1</span> of <span class="font-medium">1<span>
                                    </div> -->
                                    <!-- Pagination Buttons -->
                                    <!-- <div class="flex justify-end mt-4 space-x-1 text-sm">
                                        <a href="" class="px-3 py-2 border rounded-l bg-gray-800 text-white">Prev</a>
                                        <a href="" class="px-3 py-2 border bg-gray-800 text-white">1</a> -->
                                        <!-- <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">2</a>
                                        <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">3</a> -->
                                        <!-- <a href="" class="px-3 py-2 border rounded-r bg-gray-800 text-white">Next</a>
                                    </div>
                                </div> -->
                            <?php else: ?>
                                <p>No users found</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <script src="../public/js/script.js"></script>
    </body>
</html>