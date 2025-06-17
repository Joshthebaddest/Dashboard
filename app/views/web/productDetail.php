<?php
  $dir = realpath(__DIR__);
  require_once __DIR__ .'/../../../config/globalConfig.php';
  require_once __DIR__ . '/../../models/products.php';
  require_once __DIR__ . '/../../models/product_images.php';
  require_once __DIR__ . '/../../controllers/cartController.php';
  $productId = htmlspecialchars($_GET['productId']);
  try{
    $row = Product::query()
     ->select('*')
     ->where('id', $productId)
     ->first();
    $product = [
      'id' => $row['id'],
      'name' => $row['product_name'],
      'image' => $row['img_url'],
      'vendorId' => 0,
      'vendorName' => $row['username'],
      'description' => $row['description'],
      'discount' => 20,
      'rating' => 4.3,
      'reviews' => 87,
      'price' => $row['price'],
      'tags' => ['no', 'no'],
      'originalPrice' => 99.99,
      'inStock' => $row['quantity']
    ];

    $data = ProductImage::query()
     ->select('*')
     ->where('product_id', $productId)
     ->get();
    if($data){
      foreach($data as $row){
        $product_images[] = [
          'id' => $row['id'],
          'url' => $row['img_url'],
          'is_main' => $row['is_main']
        ];
      }
    }

  }catch(Exception $e){
    $e -> getMessage();
  }

?>

<div class="p-10"> 
  <?php include_once __DIR__ . '/components/breadcrumb.php' ?>
</div>

<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

    <!-- Product Images -->
    <div class="space-y-4">
      <div class="relative aspect-square overflow-hidden rounded-lg border">
        <img src="<?= $product['image'] ?? '/placeholder.svg' ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="object-cover w-full h-full" />
        
        <?php if (!empty($product['discount'])): ?>
          <span class="absolute top-4 left-4 bg-red-500 text-white text-xs px-2 py-1 rounded">
            -<?= $product['discount'] ?>% OFF
          </span>
        <?php endif; ?>
      </div>
      <div class="flex gap-5">
        <?php  
          if(isset($product_images)):
            foreach($product_images as $img):
        ?> 
        <div class="w-20 h-20 border-2 <?= $num == 0 ? 'border-blue-600' : '' ?> p-0.5 rounded-lg">
          <img src="<?= $img['url'] ?? '/placeholder.svg' ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="object-cover w-full h-full" />
        </div>
        <?php 
            endforeach; 
          endif;  
        ?>
      </div>
    </div>

    <!-- Product Info -->
    <div class="space-y-6">
      <div>
        <a href="<?= BASE_PATH ?>vendors/<?= $product['vendorName'] ?>" class="text-blue-600 hover:underline">
          <?= htmlspecialchars($product['vendorName']) ?>
        </a>
        <h1 class="text-3xl font-bold mt-2"><?= htmlspecialchars($product['name']) ?></h1>

        <div class="flex items-center space-x-4 mt-4">
          <div class="flex items-center">
            <?php for ($i = 0; $i < 5; $i++): ?>
              <i data-lucide="star" class="h-5 w-5 <?= $i < floor($product['rating']) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300' ?>"></i>
            <?php endfor; ?>
          </div>
          <span class="text-sm text-gray-600">
            <?= number_format($product['rating'], 1) ?> (<?= $product['reviews'] ?> reviews)
          </span>
        </div>
      </div>

      <!-- Price -->
      <div class="space-y-2">
        <div class="flex items-center space-x-4">
          <span class="text-3xl font-bold text-green-600">$<?= number_format($product['price'], 2) ?></span>
          <?php if (!empty($product['originalPrice'])): ?>
            <span class="text-xl text-gray-500 line-through">$<?= number_format($product['originalPrice'], 2) ?></span>
          <?php endif; ?>
        </div>
        <?php if (!empty($product['inStock'])): ?>
          <span class="bg-green-100 text-green-800 text-sm px-2 py-1 rounded">In Stock</span>
        <?php else: ?>
          <span class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded">Out of Stock</span>
        <?php endif; ?>
      </div>

      <!-- Separator -->
      <hr class="border-t" />

      <!-- Description -->
      <div>
        <h3 class="font-semibold mb-2">Description</h3>
        <p class="text-gray-600"><?= htmlspecialchars($product['description']) ?></p>
      </div>

      <!-- Tags -->
      <div class="flex flex-wrap gap-2">
        <?php foreach ($product['tags'] as $tag): ?>
          <span class="border text-sm px-2 py-1 rounded"><?= htmlspecialchars($tag) ?></span>
        <?php endforeach; ?>
      </div>

      <!-- Separator -->
      <hr class="border-t" />

      <!-- Add to Cart Section -->
      <div class="space-y-4">
        <form method="POST" action="">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>" />
          <div class="flex items-center space-x-4">
            <label for="quantity" class="font-medium">Quantity:</label>
            <select name="quantity" id="quantity" class="border rounded-md px-3 py-2">
              <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <div class="flex space-x-4 mt-4">
            <button type="submit" class="flex items-center justify-center flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" <?= empty($product['inStock']) ? 'disabled class="opacity-50 cursor-not-allowed"' : '' ?>>
              <i data-lucide="shopping-cart" class="h-5 w-5 mr-2"></i> Add to Cart
            </button>
            <button type="button" class="border rounded px-4 py-2 hover:bg-gray-100">
              <i data-lucide="heart" class="h-5 w-5"></i>
            </button>
            <button type="button" class="border rounded px-4 py-2 hover:bg-gray-100">
              <i data-lucide="share-2" class="h-5 w-5"></i>
            </button>
          </div>
        </form>
      </div>

      <!-- Features -->
      <div class="border rounded-lg p-6 bg-white shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="flex items-center space-x-3">
            <i data-lucide="truck" class="h-5 w-5 text-blue-600"></i>
            <div>
              <p class="font-medium">Free Shipping</p>
              <p class="text-sm text-gray-600">On orders over $50</p>
            </div>
          </div>
          <div class="flex items-center space-x-3">
            <i data-lucide="shield" class="h-5 w-5 text-green-600"></i>
            <div>
              <p class="font-medium">Secure Payment</p>
              <p class="text-sm text-gray-600">100% protected</p>
            </div>
          </div>
          <div class="flex items-center space-x-3">
            <i data-lucide="rotate-ccw" class="h-5 w-5 text-orange-600"></i>
            <div>
              <p class="font-medium">Easy Returns</p>
              <p class="text-sm text-gray-600">30-day policy</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>