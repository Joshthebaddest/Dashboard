<?php
  $dir = realpath(__DIR__);
  require_once __DIR__ . '/../../models/products.php';
  require_once __DIR__ . '/../../models/category.php';
  $username = $_SESSION['user'] ?? null;
  $products = [];
  try{
    $data = Product::query()
      ->select('*')
      ->get();

    if (!empty($data)) {
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

    if(isset($_GET['search'])){
      $searchField = $_GET['search'];
      $result = Product::query()
        -> search($searchField, ['product_name', 'username'])
        ->getWithPagination();
      $data = $result['data'];
      if(count($data) > 0){
        $products = [];
        foreach($data as $row){
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
    };

    $category = Category::query()
      ->select('*')
      ->get();

  }catch(Exception $e) {
    echo $e -> getMessage();
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(count($_GET) >= 2 && !isset($_GET['search'])){
      $products = [];
      foreach ($_GET as $key => $value) {
          if (str_starts_with($key, 'category_')) {
              $category_id = str_replace('category_', '', $key);

              $query = Product::query()->select('*')->where('category_id', $category_id);

              // Optional price filters
              if (!empty($_GET['minRange'])) {
                  $query->where('price', '>=', $_GET['minRange']);
              }

              if (!empty($_GET['maxRange'])) {
                  $query->where('price', '<=', $_GET['maxRange']);
              }

              // if (!empty($_GET['rating'])) {
              //     $query->where('rating', '>=', $_GET['rating']);
              // }

              // // Optional sorting
              // if (!empty($_GET['sort_by']) && in_array($_GET['sort_by'], ['price', 'product_name', 'created_at'])) {
              //     $sortOrder = (!empty($_GET['sort_order']) && strtolower($_GET['sort_order']) === 'desc') ? 'desc' : 'asc';
              //     $query->orderBy($_GET['sort_by'], $sortOrder);
              // }

              // Optional pagination (default: page 1, 10 items)
              $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
              $pageSize = isset($_GET['page_size']) ? (int)$_GET['page_size'] : 10;
              $results = $query->paginate($page, $pageSize)->getWithPagination();

              foreach ($results['data'] as $row) {
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
      }
    }
  }

?>


  <style>
    input[type="range"]::-webkit-slider-thumb {
      -webkit-appearance: none;
      height: 20px;
      width: 20px;
      border-radius: 9999px;
      background: #3b82f6;
      cursor: pointer;
      pointer-events: all;
      position: relative;
      top: 50%;
      transform: translateY(-50%);
    }

    input[type="range"]::-moz-range-thumb {
      height: 20px;
      width: 20px;
      border-radius: 9999px;
      background: #3b82f6;
      cursor: pointer;
      pointer-events: all;
    }

    input[type="range"]::-ms-thumb {
      height: 20px;
      width: 20px;
      border-radius: 9999px;
      background: #3b82f6;
      cursor: pointer;
      pointer-events: all;
    }
  </style>


<main class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-8 flex-grow">
  <!-- Filters Sidebar -->
  <aside class="w-full md:w-64 bg-white rounded-lg shadow p-6 mt-32 h-fit self-start">
    <h3 class="text-xl font-semibold mb-3">Filters</h3>
    <form action="" method="GET">
      <!-- Categories -->
      <div class="mb-3">
        <h4 class="font-semibold mb-2">Category</h4>
        <ul class="space-y-1 text-gray-700">
          <?php foreach($category as $row): ?>
          <li>
            <label class="inline-flex items-center">
              <input type="checkbox" name="category_<?= htmlspecialchars($row['id'])?>" <?= isset($_GET['category_'.$row['id']]) ? 'checked' : '' ?> class="form-checkbox" /> 
              <span class="ml-2"><?= htmlspecialchars($row['name']) ?></span>
            </label>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      
      <div class="w-full max-w-md mb-3">
        <h4 class="font-semibold mb-2">Price Range</h4>
        <div class="relative h-12">
          <!-- Full Track -->
          <div class="absolute top-1/2 w-full h-1 bg-gray-300 rounded-md transform -translate-y-1/2"></div>

          <!-- Selected Range Highlight -->
          <div id="rangeFill" class="absolute top-1/2 h-1 bg-blue-500 rounded-md transform -translate-y-1/2 z-0"></div>

          <!-- Range Inputs -->
          <input type="range" name="minRange" id="minRange" min="0" max="1000" value="<?= $_GET['minRange'] ?? 0 ?>" step="10"
            class="absolute top-1/2 w-full appearance-none bg-transparent pointer-events-none z-10" />
          <input type="range" name="maxRange" id="maxRange" min="0" max="1000" value="<?= $_GET['maxRange'] ?? 1000 ?>" step="10"
            class="absolute top-1/2 w-full appearance-none bg-transparent pointer-events-none z-10" />
        </div>

        <!-- Value Display -->
        <div class="flex justify-between mt-6 text-sm font-medium text-gray-700">
          <span>Min: $<span id="minValue">200</span></span>
          <span>Max: $<span id="maxValue">800</span></span>
        </div>
      </div>

      <!-- Ratings -->
      <div class="">
        <h4 class="font-semibold mb-2">Minimum Rating</h4>
        <select name="rating" class="w-full border rounded px-2 py-1">
          <option value="0" <?= ($_GET['rating'] ?? 0) === '0' ? 'selected' : '' ?>>All Ratings</option>
          <option value="4" <?= ($_GET['rating'] ?? 0) === '4' ? 'selected' : '' ?>>4 stars & up</option>
          <option value="3" <?= ($_GET['rating'] ?? 0) === '3' ? 'selected' : '' ?>>3 stars & up</option>
          <option value="2" <?= ($_GET['rating'] ?? 0) === '2' ? 'selected' : '' ?>>2 stars & up</option>
          <option value="1" <?= ($_GET['rating'] ?? 0) === '1' ? 'selected' : '' ?>>1 star & up</option>
        </select>
      </div>

      <div class="flex space-x-4 mt-4">
        <button type="submit" class="flex items-center justify-center flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          <i data-lucide="shopping-cart" class="h-5 w-5 mr-2"></i> Apply Filter
        </button>
      </div>
    </form>
  </aside>

  <!-- Products Grid -->
  <div class="container px-4 py-8 flex-1">
  <!-- <div class="container mx-auto px-4 py-8"> -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold mb-2">All Products</h1>
        <p class="text-gray-600">Discover amazing products from our trusted vendors</p>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 mt-4 md:mt-0">
        <div class="relative">
          <!-- Lucide Search Icon -->
          <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4"></i>

          <!-- Search Input -->
          <form action="" class="w-full" method="GET">
            <input type="search" name="search" placeholder="Search products..." class="pl-10 pr-4 w-full sm:w-64 border border-gray-300 rounded-md py-2">
          </form>
        </div>

        <!-- Button with Filter Icon -->
        <!-- <button class="flex items-center border border-gray-300 rounded-md px-4 py-2 hover:bg-gray-100 transition">
          <i data-lucide="filter" class="h-4 w-4 mr-2"></i>
          Filters
        </button> -->
      </div>
    </div>

    <!-- Fallback Loader Grid -->
    <?php
    $loading = false; 

    if ($loading): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <?php for ($i = 0; $i < 8; $i++): ?>
        <div class="bg-gray-200 animate-pulse rounded-lg h-80"></div>
      <?php endfor; ?>
    </div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach($products as $product): ?>
          <!-- Product Grid Placeholder -->
          <?php include __DIR__ .'/components/products-grid.php'; ?>
        <?php endforeach; ?>
      </div>
      <!-- Pagination (dummy) -->
      <nav aria-label="Page navigation" class="flex justify-center space-x-2 mb-16 mt-16">
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50"><i data-lucide="chevron-left" class="w-4 h-4 my-1"></i></a>
        <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded shadow">1</a>
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50">2</a>
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50">3</a>
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50"><i data-lucide="chevron-right" class="w-4 h-4 my-1"></i></a>
      </nav>
    <?php endif; ?>
  </div>
</main>

  <script>
    const minRange = document.getElementById('minRange');
    const maxRange = document.getElementById('maxRange');
    const minValue = document.getElementById('minValue');
    const maxValue = document.getElementById('maxValue');
    const rangeFill = document.getElementById('rangeFill');

    const minGap = 50;
    const max = 1000;

    function updateSlider() {
      let min = parseInt(minRange.value);
      let maxVal = parseInt(maxRange.value);

      // Prevent overlap
      if (maxVal - min < minGap) {
        if (event.target === minRange) {
          minRange.value = maxVal - minGap;
          min = parseInt(minRange.value);
        } else {
          maxRange.value = min + minGap;
          maxVal = parseInt(maxRange.value);
        }
      }

      minValue.textContent = min;
      maxValue.textContent = maxVal;

      // Update filled track
      const percentMin = (min / max) * 100;
      const percentMax = (maxVal / max) * 100;

      rangeFill.style.left = percentMin + '%';
      rangeFill.style.width = (percentMax - percentMin) + '%';
    }

    minRange.addEventListener('input', updateSlider);
    maxRange.addEventListener('input', updateSlider);

    // Initial set
    updateSlider();
  </script>

</body>
  