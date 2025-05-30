<?php 
    require_once __DIR__ . '/../middleware/protected.php';
    include __DIR__ . '/../controllers/productController.php';

?>

<div style="width: 800px;" class="m-auto">
    <div class="flex justify-between m-10 mb-16">
        <h1 class="text-2xl font-bold mb-4">Product</h1>
        <a href="products.php" class="border rounded-md p-2 bg-blue-500 text-white hover:bg-blue-700">Back</a>
    </div>
    <form action="" method="POST" class="text-left" enctype="multipart/form-data">
        <div class="input-container my-5">
            <label htmlFor="ProductName">Product Name</label>
            <input class="w-full mt-3 p-3 bg-slate-200 rounded-lg outline-none ring-0" type="text" name="product_name" id="productName" placeholder="Enter Your Product Name" value="<?php echo htmlspecialchars($product_name) ?>"/>
        </div>
        <div class="flex justify-between space-x-5">
            <div class="flex-1 input-container my-5">
                <label htmlFor="ProductName">Price</label>
                <input class="w-full mt-3 p-3 bg-slate-200 rounded-lg outline-none ring-0" type="text" name="price" id="price" placeholder="Enter Your Price" value="<?php echo htmlspecialchars($price) ?>"/>
            </div>
            <div class="flex-1 input-container my-5 w-1/2">
                <label htmlFor="ProductName">Quantity</label>
                <input class="w-full mt-3 p-3 bg-slate-200 rounded-lg outline-none ring-0" type="text" name="quantity" id="quantity" placeholder="Enter Your Quantity" value="<?php echo htmlspecialchars($quantity) ?>"/>
            </div>
            <div class="flex-1 input-container my-5 w-1/2">
                <label htmlFor="ProductName">Size</label>
                <input class="w-full mt-3 p-3 bg-slate-200 rounded-lg outline-none ring-0" type="text" name="product_size" id="quantity" placeholder="Enter Your Product Size" value="<?php echo htmlspecialchars($product_size) ?>"/>
            </div>
        </div>
        <div class="input-container my-5">
            <label htmlFor="ProductName">Description</label>
            <textarea class="w-full mt-3 h-44 p-3 bg-slate-200 rounded-lg resize-none outline-none ring-0"  type="text" name="descriptions" id="description" placeholder="write about your product" value="<?php echo htmlspecialchars($descriptions) ?>"></textarea>
        </div>
        <div class="flex mb-10">  
            <div class="relative w-24 h-24 mr-5">
                <!-- Profile Image -->
                <img
                    id="profileImg"
                    src="<?= !empty($row['img_url']) ? $row['img_url'] : 'https://placehold.co/300x200?text=Upload+Image' ?> "
                    alt=""
                    class="w-full h-full object-cover border border-gray-300"
                />

                <!-- Overlay -->
                <label for="fileInput" class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                    <svg class="w-6 h-6 text-white mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A2 2 0 0122 9.618V18a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h5l2-2h4l2 2h5a2 2 0 012 2v3.618a2 2 0 01-2.447 1.894L15 10z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-4-4m0 0l4-4m-4 4h16" />
                    </svg>
                    <span class="text-white text-xs font-semibold">Add Photo</span>
                </label>

                <!-- File Input -->
                <input id="fileInput" type="file" accept="image/*" name="img_url" class="hidden">
            </div>
        </div>
        <button type="submit" class="p-3 w-24 bg-black text-white rounded-lg">Submit <i class="fa-solid fa-arrow-right"></i></button>
    </form>
</div>