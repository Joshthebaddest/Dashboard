<?php  
    require_once __DIR__ . '/../middleware/protected.php';
    include __DIR__ .'/../controllers/usersController.php';
    $allowed_roles = ['admin', 'editor', 'user'];
    $role_hierarchy = [
        'super_admin' => 4,
        'admin'       => 3,
        'editor'      => 2,
        'user'        => 1,
    ];
?>

<div>
    <div class="flex justify-between p-5 py-10">
        <h1 class="text-2xl font-bold">Users</h1>

        <a href="#" id="add" class="border rounded-md w-40 py-2 text-center bg-gray-800 text-white hover:bg-gray-700 flex gap-2 px-2"><i class="w-6 h-6 text-white" data-lucide="users"></i> Invite Users</a>
    </div>

    <div class="flex justify-between mb-4">
        <input type="text" placeholder="Search by name..." class="border rounded-md py-2 px-4 w-1/3 outline-none" />
        <!-- <select class="border rounded-md py-2 px-4" >
            <option value="">All Categories</option>
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
        </select> -->
    </div>

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
                                            class='flex justify-between p-2 w-full text-center'
                                        >
                                            <p class='text-sm capitalize'><?= $row['role'] ?></p>
                                            <div class='pt-1' >
                                            <?php if(isset($role_hierarchy[$_SESSION["role"]], $role_hierarchy[$row["role"]]) && $role_hierarchy[$_SESSION["role"]] > $role_hierarchy[$row["role"]]): ?>
                                                <i class="h-4 w-4" data-lucide="chevron-down"></i>
                                            <?php endif; ?>
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
                                                <form action="../controllers/roleController.php" method="POST" class="w-full">
                                                    <input type="hidden" name="username" value="<?= $row["username"] ?>">
                                                    <input type="hidden" name="role" value="<?= $role ?>">
                                                    <button type="submit" class="text-sm capitalize font-semibold w-full text-left <?= $row["role"] === $role ? "flex gap-2" : "block" ?>"><?= $role ?><?php if($row["role"] === $role): ?><i class="w-4 h-4 mt-1" data-lucide="check"></i><?php endif ?></button>
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
                                <a href="./editUser.php?user=<?=$row['username']?>&type=edit" class='edit btn hover:bg-gray-600 p-1'><i class="w-5 h-5 text-gray-600 hover:text-white" data-lucide="square-pen"></i></a>
                                <?php if(isset($_SESSION["role"]) && ($_SESSION["role"] === "admin" || $_SESSION["role"] === "super_admin")): ?>
                                <button type="submit" class='delete btn hover:bg-red-600 p-1'><i class="w-5 h-5 text-red-600 hover:text-white" data-lucide="trash-2"></i></a>
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

        <div class="flex flex-col md:flex-row items-center justify-end gap-10 mt-4 space-y-2 md:space-y-0">
            <!-- Page Info -->
            <div class="text-sm text-gray-800">
                Showing page <span class="font-medium">1</span> of <span class="font-medium">1<span>
            </div>
            <!-- Pagination Buttons -->
            <div class="flex justify-end mt-4 space-x-1 text-sm">
                <a href="" class="px-3 py-2 border rounded-l bg-gray-800 text-white"><i class="w-5 h-5 text-white" data-lucide="chevron-left"></i></a>
                <a href="" class="px-3 py-2 border bg-gray-800 text-white">1</a>
                <!-- <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">2</a>
                <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">3</a> -->
                <a href="" class="px-3 py-2 border rounded-r bg-gray-800 text-white"><i class="w-5 h-5 text-white" data-lucide="chevron-right"></i></a>
            </div>
        </div>
    <?php else: ?>
        <p>No users found</p>
    <?php endif; ?>
</div>
                   