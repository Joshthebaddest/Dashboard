<?php
    require_once __DIR__  .'/../middleware/protected.php';
    $dir = realpath(__DIR__);
    include($dir.'/../models/products.php');
    $username = $_SESSION['user'] ?? null;
    $sql = "SELECT * FROM VendorProducts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $products = [];
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        $stmt->close();
    }else {
        // Handle query preparation error
        error_log("Database query preparation failed: " . $conn->error);
    }
    $count = 1; // Initial count

?>

<div style="padding-bottom: 400px;" class="mx-auto">
    <div class="flex justify-between p-5 py-10">
        <h1 class="text-2xl font-bold">Product Listing</h1>

        <a href="vendor?type=add" id="add" class="border rounded-md p-2 w-40 bg-gray-800 text-center text-white hover:bg-gray-700 flex gap-2 px-2"><i class="w-6 h-6 text-white" data-lucide="package"></i> Add Product</a>
    </div>

    <div class="flex justify-between mb-4">
        <input type="text" placeholder="Search by name..." class="border rounded-md py-2 px-4 w-1/3 outline-none" />
        <select class="border rounded-md py-2 px-4" >
            <option value="">All Categories</option>
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
        </select>
    </div>

    <div style="max-height: 400px" class='py-5 overflow-auto'>
        <table>
            <thead class="text-gray-500 border-b text-sm font-normal border-gray-200 hover:bg-gray-50">
                <tr>
                    <th class="py-3 px-6 text-left whitespace-nowrap"></th>
                    <th class="py-3 px-6 text-left whitespace-nowrap">IMAGE</th>
                    <th class="py-3 px-6 text-left whitespace-nowrap">NAME</th>
                    <th class="py-3 px-6 text-left whitespace-nowrap">SIZE</th>
                    <th class="py-3 px-6 text-left whitespace-nowrap">PRICE</th>
                    <th class="py-3 px-6 text-left whitespace-nowrap">QUANTITY</th>
                    <th class="py-3 px-6 text-left whitespace-nowrap">ACTION</th>
                    
                </tr>
            </thead>
            <tbody class="">
                <?php foreach($products as $row): ?>
                    <tr class='text-sm text-gray-700'>
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?=$count++?></td>
                        <td class="py-3 px-6 text-left whitespace-nowrap"><img class="w-10 h-8" src="<?=$row['img_url']?>" alt="<?=$row['product_name']?>"/></td>
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['product_name'] ?></td>
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['product_size']?></td>
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['price']?></td>
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?=$row['quantity']?></td>

                        
                        <td class="flex gap-2 py-3 px-6 text-left whitespace-nowrap"> 
                            <a href="./vendor?id=<?=$row['product_id']?>&type=edit" class='edit btn hover:bg-gray-600 p-1'><i class="w-5 h-5 text-gray-600 hover:text-white" data-lucide="square-pen"></i></a>
                            <button type="submit" class='delete btn hover:bg-red-600 p-1'><i class="w-5 h-5 text-red-600 hover:text-white" data-lucide="trash-2"></i></a>
                        </td>
                        

                        <div id="popup" class="hidden w-full h-screen bg-gray-800 fixed left-0 opacity-60 top-0 z-50"></div>
                        <div id="popup-message" style="width: fit-content; top: 35%; left: 25%; right: 25%" class="hidden z-50 opacity-100 fixed shadow-lg p-5 rounded-lg mx-auto bg-gray-200">
                            <p>Are you sure you want to delete this user?</p>
                            <div style="width: fit-content" class="flex gap-5 py-2 mx-auto">
                                <form action="../controllers/productController.php?id=<?=$row['product_id']?>&type=delete" method="POST">
                                    <button type="submit" style="width: 50px; height: 25px" class="popup-btn bg-red-600 text-white rounded-lg text-sm">Yes</button>
                                </form>
                                <button style="width: 50px; height: 25px" class="popup-btn bg-gray-500 text-white rounded-lg text-sm">No</button>
                            </div>
                        </div>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

        <div class="flex flex-col md:flex-row items-center justify-end gap-10 mt-4 space-y-2 md:space-y-0">
            <!-- Page Info -->
            <div class="text-xs text-gray-800">
                Showing page <span class="font-medium">1</span> of <span class="font-medium">1<span>
            </div>
            <!-- Pagination Buttons -->
            <div class="flex justify-end mt-4 space-x-1 text-xs">
                <a href="" class="px-3 py-2 border rounded-l bg-gray-500 text-white"><i class="w-5 h-5 text-white" data-lucide="chevron-left"></i></a>
                <a href="" class="px-3 py-2 border bg-gray-800 text-white">1</a>
                <!-- <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">2</a>
                <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">3</a> -->
                <a href="" class="px-3 py-2 border rounded-r bg-gray-500 text-white"><i class="w-5 h-5 text-white" data-lucide="chevron-right"></i></a>
            </div>
        </div>

        <!-- <p>No users found</p> -->
  
</div>