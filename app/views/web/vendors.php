<?php 
  $dir = realpath(__DIR__);
   require_once __DIR__ .'/../../../config/globalConfig.php';
  include($dir.'/../../models/users.php');
  $username = $_SESSION['user'] ?? null;
  $role = 'vendor';
  $vendors = [];
  try{
    $result = User::query()
      -> select('*') 
      -> where('role', $role)
      -> getWithPagination();
    $data = $result['data'];
    if ($data) {
      foreach($data as $row) {
        $vendors[] = [
          'id' => $row['id'],
          'name' => $row['username'],
          'logo' => $row['profileImg'],
          'location' => 'San Francisco, CA',
          'description' => 'Premium audio products crafted for professionals and audiophiles alike.',
          'rating' => 4.6,
          'reviews' => 243,
          'productCount' => 30
        ];
      }
    }
  }catch(Exception $e) {
    echo $e -> getMessage();
  }

  if(isset($_GET['search'])){
    require_once __DIR__ . '/../../utils/features.php';
    $searchField = htmlspecialchars($_GET['search']);
    $result = User::query()
      -> search($searchField, ['username'])
      ->getWithPagination();
    $data = $result['data'];
    if(count($data) > 0){
      $vendors = [];
      foreach($data as $row){
        $vendors[] = [
          'id' => $row['id'],
          'name' => $row['username'],
          'logo' => $row['profileImg'],
          'location' => 'San Francisco, CA',
          'description' => 'Premium audio products crafted for professionals and audiophiles alike.',
          'rating' => 4.6,
          'reviews' => 243,
          'productCount' => 30
        ];
      }
    }
  }
?>

<div class="container mx-auto px-4 py-8">
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
    <div>
      <h1 class="text-3xl font-bold mb-2">Our Vendors</h1>
      <p class="text-gray-600">Meet our trusted vendor partners</p>
    </div>

    <div class="relative mt-4 md:mt-0">
      <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4"></i>
      <input 
        type="search" 
        name="search_vendors" 
        placeholder="Search vendors..." 
        class="pl-10 pr-4 w-full sm:w-64 border rounded-md py-2"
      />
    </div>
  </div>

  <?php
  $loading = false; 

  if ($loading): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php for ($i = 0; $i < 6; $i++): ?>
        <div class="bg-gray-200 animate-pulse rounded-lg h-48"></div>
      <?php endfor; ?>
    </div>
    <?php elseif(isset($vendors) && !empty($vendors)): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($vendors as $vendor): ?>
          <div class="hover:shadow-lg transition-shadow duration-200 border rounded-lg overflow-hidden bg-white">
            <div class="p-6">
              <div class="flex items-center space-x-4 mb-4">
                <img
                  src="<?php echo $vendor['logo'] ?? '/placeholder.svg'; ?>"
                  alt="<?php echo htmlspecialchars($vendor['name']); ?>"
                  width="60"
                  height="60"
                  class="rounded-full"
                />
                <div class="flex-1">
                  <a href="<?= BASE_PATH ?>vendors/<?php echo $vendor['name']; ?>">
                    <h3 class="font-semibold text-lg hover:text-blue-600 transition-colors">
                      <?php echo htmlspecialchars($vendor['name']); ?>
                    </h3>
                  </a>
                  <div class="flex items-center text-sm text-gray-600">
                    <i data-lucide="map-pin" class="w-3 h-3 mr-1"></i>
                    <?php echo htmlspecialchars($vendor['location']); ?>
                  </div>
                </div>
              </div>

              <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                <?php echo htmlspecialchars($vendor['description']); ?>
              </p>

              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current mr-1"></i>
                  <span class="text-sm font-medium"><?php echo $vendor['rating']; ?></span>
                  <span class="text-sm text-gray-500 ml-1">(<?php echo $vendor['reviews']; ?>)</span>
                </div>
                <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                  <?php echo $vendor['productCount']; ?> products
                </span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
      <p>No vendors Found</p>
  <?php endif; ?>
</div>
