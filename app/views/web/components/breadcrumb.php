<?php 
    require_once __DIR__ . '/../../../../config/globalConfig.php'; 
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $result = explode('/', $path);
    $breadcrumbs = [];
    foreach($result as $res){
        if($res !== 'apps' && $res !== 'public'){
        if($res === ''){
            $breadcrumbs[] =['label' => 'Home', 'url' => BASE_PATH];
        }else{
            $breadcrumbs[] =['label' => $res, 'url' => BASE_PATH.$res];
        }
        }
    }; 

?>

<nav class="text-sm text-gray-600" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex items-center">
        <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
            <li class="flex items-center">
                <?php if (!empty($breadcrumb['url']) && $index !== array_key_last($breadcrumbs)): ?>
                    <a href="<?=htmlspecialchars($breadcrumb['url']) ?>" class="capitalize text-blue-600 hover:underline">
                        <?= htmlspecialchars($breadcrumb['label']) ?>
                    </a>
                    <span class="mx-2">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                    </span>
                <?php else: ?>
                    <span class="text-gray-500"><?= htmlspecialchars($breadcrumb['label']) ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>