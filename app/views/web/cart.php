<?php 
    require_once __DIR__ . '/../../../config/globalConfig.php';
    require_once __DIR__ . '/../../controllers/cartController.php';
    require_once __DIR__ . '/../../models/products.php';
    $items = [];
    foreach($carts as $key => $value){
        $product = Product::query()
            ->select('id', 'product_name', 'img_url', 'quantity', 'price', 'username')
            ->where('id', $key)
            ->first();
        $items [] = [
            'id' => $product['id'],
            'image' => $product['img_url'],
            'name' => $product['product_name'],
            'quantity' => $value,
            'vendorName' => $product['username'],
            'price' => $product['price']
        ];
    }

    // Calculate total
    $total = array_reduce($items, function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);
?>

<?php if (empty($items)): ?>
  <div class="container mx-auto px-4 py-16">
    <div class="text-center">
      <i data-lucide="shopping-bag" class="h-24 w-24 text-gray-300 mx-auto mb-4"></i>
      <h1 class="text-2xl font-bold mb-2">Your cart is empty</h1>
      <p class="text-gray-600 mb-8">Add some products to get started!</p>
      <a href="<?= BASE_PATH ?>products" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">
        Continue Shopping
      </a>
    </div>
  </div>
<?php endif; ?>

<?php if (!empty($items)): ?>
    <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Cart Items -->
        <div class="lg:col-span-2">
        <div class="border rounded-lg bg-white">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold">Cart Items (<?php echo count($items); ?>)</h2>
                <form method="POST" action="">
                    <input type="hidden" name="type" value="clear">
                    <button class="text-sm border px-3 py-1 rounded hover:bg-gray-100">Clear Cart</button>
                </form>
            </div>
            <div class="space-y-4 p-4">
            <?php foreach ($items as $item): ?>
                <div class="flex items-center space-x-4 p-4 border rounded-lg">
                <img src="<?php echo $item['image'] ?? '/placeholder.svg'; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="80" height="80" class="rounded-md">

                <div class="flex-1">
                    <h3 class="font-semibold"><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p class="text-sm text-gray-600">by <?php echo htmlspecialchars($item['vendorName']); ?></p>
                    <p class="font-bold text-green-600">$<?php echo number_format($item['price'], 2); ?></p>
                </div>

                <div class="flex items-center space-x-2">
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="type" value="decrement">
                        <button name="submit" value="decrease" class="border p-2 rounded hover:bg-gray-100" <?php if ($item['quantity'] <= 1) echo 'disabled'; ?>>
                            <i data-lucide="minus" class="w-4 h-4"></i>
                        </button>
                    </form>

                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="w-16 text-center border rounded" form="update-form-<?php echo $item['id']; ?>">

                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="type" value="increment">
                        <button name="submit" value="increase" class="border p-2 rounded hover:bg-gray-100">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>

                <form method="POST" action="">
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="type" value="delete">
                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        </div>

        <!-- Order Summary -->
        <div>
        <div class="border rounded-lg bg-white">
            <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Order Summary</h2>
            </div>
            <div class="p-4 space-y-4">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>$<?php echo number_format($total, 2); ?></span>
            </div>
            <div class="flex justify-between">
                <span>Shipping</span>
                <span>Free</span>
            </div>
            <div class="flex justify-between">
                <span>Tax</span>
                <span>$<?php echo number_format($total * 0.08, 2); ?></span>
            </div>
            <hr>
            <div class="flex justify-between font-bold text-lg">
                <span>Total</span>
                <span>$<?php echo number_format($total * 1.08, 2); ?></span>
            </div>

            <form action="/checkout.php" method="POST">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
                Proceed to Checkout
                </button>
            </form>

            <a href="/products" class="block text-center border border-gray-300 py-2 rounded hover:bg-gray-100">
                Continue Shopping
            </a>
            </div>
        </div>
        </div>
    </div>
    </div>
<?php endif; ?>