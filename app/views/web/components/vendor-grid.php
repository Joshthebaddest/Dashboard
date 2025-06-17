<?php
 require_once __DIR__ .'/../../../../config/globalConfig.php';
?>

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
                        <a href="<?= BASE_PATH ?>vendors/<?php echo $vendor['id']; ?>">
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