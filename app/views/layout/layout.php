<?php
    require_once __DIR__ .'/../../../config/globalConfig.php'
?>


<!DOCTYPE html>
<html lang="en" >
    <head>

        <!-- Basic Meta Tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MarketPlace - Your Ultimate Shopping Destination</title>
        <meta name="description" content="Discover millions of products from trusted sellers worldwide. Best prices, fast delivery, and secure shopping.">
        <meta name="keywords" content="ecommerce, marketplace, online shopping, deals, electronics, fashion, home">
        <meta name="author" content="MarketPlace">

        <!-- Open Graph Meta Tags (for social sharing) -->
        <meta property="og:title" content="MarketPlace - Your Ultimate Shopping Destination">
        <meta property="og:description" content="Discover millions of products from trusted sellers worldwide. Best prices, fast delivery, and secure shopping.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://www.marketplace.com/"> <!-- Replace with your actual URL -->
        <meta property="og:image" content="https://www.marketplace.com/images/og-image.jpg"> <!-- Replace with your image URL -->

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="MarketPlace - Your Ultimate Shopping Destination">
        <meta name="twitter:description" content="Discover millions of products from trusted sellers worldwide. Best prices, fast delivery, and secure shopping.">
        <meta name="twitter:image" content="https://www.marketplace.com/images/og-image.jpg"> <!-- Replace with your image URL -->
        <meta name="twitter:site" content="@MarketPlace"> <!-- Replace with your Twitter handle -->

        <!-- Favicon -->
        <link rel="icon" href="/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="<?= BASE_PATH ?>css/style.css">
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

        <!-- <link rel="stylesheet" href="/css/style.css"> -->
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <!-- Development version -->
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <style>
            /* For multiline truncation */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;  
                overflow: hidden;
            }
        </style>
    </head>

    <body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

        <?php 
            if ($fileDir === 'dashboard') {
                include __DIR__ . '/dashboardShell.php';
            } else {
                include __DIR__ . '/webShell.php';
            }
        ?>

        <!-- Toast Container -->
        <div id="toast-container" class="fixed top-5 right-5 space-y-4 z-50"></div>

        <script src="/js/script.js"></script>
        <script src="/js/toast.js"></script>
        <script>
            lucide.createIcons();
        </script>

        <?php
            if (isset($_SESSION['toast'])) {
                $message = addslashes($_SESSION['toast']['message']);
                $type = $_SESSION['toast']['type'];
                echo "<script>showToast('{$message}', '{$type}');</script>";
                unset($_SESSION['toast']);
            }
        ?>
    </body>
</html>



