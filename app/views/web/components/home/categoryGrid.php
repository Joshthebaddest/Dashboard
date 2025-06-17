<?php
  try{
    require_once __DIR__ . '/../../../../models/category.php';
    $data = Category::query()
      ->select('*')
      ->get();
    $categories = [];
    foreach ($data as $row) {
      $categories[] = [
        'id' => $row['id'],
        'slug' => $row['slug'],
        'name' => $row['name'],
        'count' =>  "120 products",
      ];
    }
  }catch(Exception $e) {
    // Handle query preparation error
    echo $e -> getMessage();
  }
?>

<section class="py-16 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold mb-4">Shop by Category</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
      <?php
        if(isset($categories)):
          foreach ($categories as $category): 
            $slug = $category['slug'];
      ?>
        <a href="/category/<?= $slug ?>" class="block hover:shadow-lg transition-shadow cursor-pointer">
          <div class="p-4 text-center border rounded-lg bg-white">
            <img src="" alt="<?= htmlspecialchars($category['name']) ?>" width="80" height="80" class="mx-auto mb-3 rounded-lg" />
            <h3 class="font-medium text-sm mb-1"><?= htmlspecialchars($category['name']) ?></h3>
            <p class="text-xs text-gray-500"><?= htmlspecialchars($category['count']) ?></p>
          </div>
        </a>
      <?php 
        endforeach; 
        endif;
      ?>
    </div>
  </div>
</section>