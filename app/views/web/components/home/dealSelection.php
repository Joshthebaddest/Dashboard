<?php
$deals = [
  [
    "id" => 1,
    "title" => "Lightning Deal",
    "product" => "Wireless Headphones",
    "originalPrice" => 199.99,
    "salePrice" => 79.99,
    "discount" => 60,
    "image" => "/placeholder.svg?height=200&width=200",
    "timeLeft" => "2h 15m",
    "claimed" => 45,
    "total" => 100,
  ],
  [
    "id" => 2,
    "title" => "Flash Sale",
    "product" => "Smart Watch",
    "originalPrice" => 299.99,
    "salePrice" => 149.99,
    "discount" => 50,
    "image" => "/placeholder.svg?height=200&width=200",
    "timeLeft" => "5h 30m",
    "claimed" => 78,
    "total" => 150,
  ],
  [
    "id" => 3,
    "title" => "Daily Deal",
    "product" => "Bluetooth Speaker",
    "originalPrice" => 89.99,
    "salePrice" => 39.99,
    "discount" => 56,
    "image" => "/placeholder.svg?height=200&width=200",
    "timeLeft" => "12h 45m",
    "claimed" => 23,
    "total" => 80,
  ],
  [
    "id" => 4,
    "title" => "Hot Deal",
    "product" => "Laptop Stand",
    "originalPrice" => 59.99,
    "salePrice" => 24.99,
    "discount" => 58,
    "image" => "/placeholder.svg?height=200&width=200",
    "timeLeft" => "8h 20m",
    "claimed" => 67,
    "total" => 120,
  ]
];
?>

<section class="bg-gradient-to-r from-red-50 to-orange-50 rounded-lg p-6">
  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-2">
      <i data-lucide="flame" class="h-6 w-6 text-red-500"></i>
      <h2 class="text-2xl font-bold">Today's Deals</h2>
    </div>
    <a href="/deals" class="border border-gray-300 px-4 py-1 rounded hover:bg-gray-100 text-sm">View All Deals</a>
  </div>

  <!-- Deal Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ($deals as $deal): 
      $progress = ($deal["claimed"] / $deal["total"]) * 100;
    ?>
      <div class="border rounded-lg hover:shadow-lg transition-shadow bg-white">
        <div class="p-4">
          <!-- Image -->
          <div class="relative mb-4">
            <img src="<?= htmlspecialchars($deal["image"]) ?>" alt="<?= htmlspecialchars($deal["product"]) ?>" class="w-full h-40 object-cover rounded-lg" />
            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded">-<?= $deal["discount"] ?>%</span>
          </div>

          <!-- Deal Info -->
          <div class="space-y-2">
            <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded"><?= htmlspecialchars($deal["title"]) ?></span>
            <h3 class="font-semibold text-sm"><?= htmlspecialchars($deal["product"]) ?></h3>

            <div class="flex items-center space-x-2">
              <span class="text-lg font-bold text-red-600">$<?= number_format($deal["salePrice"], 2) ?></span>
              <span class="text-sm text-gray-500 line-through">$<?= number_format($deal["originalPrice"], 2) ?></span>
            </div>

            <div class="flex items-center space-x-1 text-xs text-gray-600">
              <i data-lucide="clock" class="h-3 w-3"></i>
              <span><?= htmlspecialchars($deal["timeLeft"]) ?> left</span>
            </div>

            <!-- Progress -->
            <div class="space-y-1">
              <div class="flex justify-between text-xs">
                <span><?= $deal["claimed"] ?> claimed</span>
                <span><?= $deal["total"] ?> total</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-orange-500 h-2 rounded-full" style="width: <?= $progress ?>%;"></div>
              </div>
            </div>

            <!-- Button -->
            <button class="bg-red-500 hover:bg-red-600 text-white text-sm py-1 w-full rounded mt-2">
              Claim Deal
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
