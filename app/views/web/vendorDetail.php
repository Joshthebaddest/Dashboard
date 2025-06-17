<?php

  $dir = realpath(__DIR__);
  $vendorId = htmlspecialchars($_GET['vendorId']);
  include($dir.'/../../models/users.php');
  include($dir.'/../../models/products.php');
  $role = 'vendor';
  $products = [];
  $vendor = [];
  try{
    $row = User::query()
      -> select('*') 
      -> where('username', $vendorId)
      -> first();

    if(!empty($row)){
      $vendor = [
        'id' => $row['id'],
        'name' => $row['username'],
        'logo' => $row['profileImg'],
        'location' => 'San Francisco, CA',
        'description' => 'Premium audio products crafted for professionals and audiophiles alike.',
        'rating' => 4.6,
        'reviews' => 243,
        'productCount' => 30,
        'joinedDate' => $row['reg_date']
      ];

      $result = Product::query()
        -> select('*') 
        -> where('username', $row['username'])
        -> getWithPagination();

      $data = $result['data'];
      foreach($data as $row) {
        $products[] = [
          'id' => $row['id'],
          'name' => $row['product_name'],
          'image' => $row['img_url'],
          'vendorId' => 0,
          'vendorName' => $row['username'],
          'discount' => 20,
          'rating' => 4.3,
          'reviews' => 87,
          'price' => $row['price'],
          'originalPrice' => 99.99
        ];
      }
    }
  }catch(Exception $e){
    echo $e -> getMessage();
  }
  
  $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
  $result = explode('/', $path);
  $breadcrumbs = [];
  foreach($result as $res){
    if($res !== 'apps' && $res !== 'public' && $res !== ''){
      $breadcrumbs[] =['label' => $res, 'url' => '/'.$res];
    }
  };

  if(!isset($vendor)) {
    require_once __DIR__ . '/../../../public/404.html';
    exit();
  }
?>
<div class="p-10"> 
  <?php include_once __DIR__ . '/components/breadcrumb.php' ?>
</div>

<div class="container mx-auto px-4 py-8">
  <!-- Vendor Header -->
  <div class="mb-8 border rounded-lg shadow-sm bg-white">
    <div class="p-8">
      <div class="flex flex-col md:flex-row items-start md:items-center space-y-6 md:space-y-0 md:space-x-8">
        <!-- Vendor Logo -->
        <img 
          src="<?= $vendor['logo'] ?? '/placeholder.svg' ?>" 
          alt="<?= htmlspecialchars($vendor['name']) ?>" 
          width="120" height="120" 
          class="rounded-full border object-cover"
        />

        <div class="flex-1">
          <!-- Vendor Name & Verified -->
          <div class="flex items-center space-x-3 mb-2">
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($vendor['name']) ?></h1>
            <?php if (!empty($vendor['verified'])): ?>
              <i data-lucide="check-circle" class="h-6 w-6 text-blue-600"></i>
            <?php endif; ?>
          </div>

          <!-- Vendor Description -->
          <p class="text-gray-600 mb-4"><?= htmlspecialchars($vendor['description']) ?></p>

          <!-- Vendor Meta -->
          <div class="flex flex-wrap items-center gap-4 text-sm text-gray-700">
            <div class="flex items-center">
              <i data-lucide="map-pin" class="h-4 w-4 mr-1 text-gray-500"></i>
              <?= htmlspecialchars($vendor['location']) ?>
            </div>
            <div class="flex items-center">
              <i data-lucide="calendar" class="h-4 w-4 mr-1 text-gray-500"></i>
              Joined <?= date("F j, Y", strtotime($vendor['joinedDate'])) ?>
            </div>
            <div class="flex items-center">
              <i data-lucide="star" class="h-4 w-4 mr-1 text-yellow-400 fill-yellow-400"></i>
              <?= number_format($vendor['rating'], 1) ?> (<?= $vendor['reviews'] ?> reviews)
            </div>
            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">
              <?= $vendor['productCount'] ?> products
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Products Section -->
  <div class="mb-8">
    <h2 class="text-2xl font-bold mb-6">Products from <?= htmlspecialchars($vendor['name']) ?></h2>

    <?php if (!empty($products)): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($products as $product): ?>
          <?php include __DIR__ . '/components/products-grid.php' ?>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="border rounded-lg p-12 text-center bg-white shadow-sm">
        <p class="text-gray-500">No products available from this vendor yet.</p>
      </div>
    <?php endif; ?>
  </div>
</div>