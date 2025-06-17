<?php
    require_once __DIR__ .'/../../../../config/globalConfig.php';
?>
        <div class="group hover:shadow-lg transition-shadow duration-200 border rounded-lg overflow-hidden bg-white">
            <div class="p-0">
                <div class="relative overflow-hidden rounded-t-lg">
                    <img
                        src="<?php echo $product['image'] ?? '/placeholder.svg'; ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                        width="300"
                        height="300"
                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-200"
                    />
                    <?php if (!empty($product['discount'])): ?>
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            -<?php echo $product['discount']; ?>%
                        </span>
                    <?php endif; ?>
                </div>

                <div class="p-4">
                    <a href="<?= BASE_PATH ?>products/<?php echo $product['id']; ?>">
                        <h3 class="font-semibold text-lg mb-2 hover:text-blue-600 transition-colors line-clamp-2">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h3>
                    </a>
                    <a href="<?= BASE_PATH ?>vendors/<?php echo $product['vendorName']; ?>">
                        <p class="text-sm text-gray-600 mb-2 hover:text-blue-600 transition-colors">
                            by <?php echo htmlspecialchars($product['vendorName']); ?>
                        </p>
                    </a>

                    <div class="flex items-center mb-2">
                        <div class="flex items-center">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <i data-lucide="star" class="w-4 h-4 <?php echo $i < floor($product['rating']) ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-sm text-gray-600 ml-2">(<?php echo $product['reviews']; ?>)</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl font-bold text-green-600">$<?php echo number_format($product['price'], 2); ?></span>
                            <?php if (!empty($product['originalPrice'])): ?>
                                <span class="text-sm text-gray-500 line-through">$<?php echo number_format($product['originalPrice'], 2); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 pt-0">
                <form method="POST" action="/add-to-cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="w-4 h-4 mr-2"></i>
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>