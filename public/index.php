<?php
// public/index.php

$url = trim($_GET['url'] ?? '', '/');

// Define route-to-file map with support for dynamic parameters
$routes = [
    ''                         => ['view' => '/../app/pages/web/home.php'],
    'home'                     => ['view' => '/../app/pages/web/home.php'],
    'cart'                     => ['view' => '/../app/pages/web/cart.php'],
    'dummy'                    => ['view' => '/../app/controllers/getDummyProducts.php'],
    'products'                 => ['view' => '/../app/pages/web/products.php'],
    'products/:productId'       => ['view' => '/../app/pages/web/productDetails.php'],
    'vendors'                  => ['view' => '/../app/pages/web/vendors.php'],
    'vendors/:vendorId'          => ['view' => '/../app/pages/web/vendorDetails.php'],
    'auth/login'               => ['view' => '/../app/views/auth/login.php'],
    'auth/signup'              => ['view' => '/../app/views/auth/signup.php'],
    'auth/forgot-password'              => ['view' => '/../app/views/auth/forgot_password.php'],
    'auth/verify-email'              => ['view' => '/../app/views/auth/verify_email.php'],
    'auth/reset-password'              => ['view' => '/../app/views/auth/reset_password.php'],
    'auth/logout'              => ['view' => '/../app/controllers/logoutController.php'],
    'dashboard'                => ['view' => '/../app/pages/dashboard/dashboard.php', 'protected' => true],
    'dashboard/products'       => ['view' => '/../app/pages/dashboard/products.php', 'protected' => true],
    'dashboard/products/:product'       => ['view' => '/../app/pages/dashboard/addProduct.php', 'protected' => true],
    'dashboard/users'          => ['view' => '/../app/pages/dashboard/users.php', 'protected' => true, 'roles' => ['super_admin', 'admin']],
    'dashboard/profile'        => ['view' => '/../app/pages/dashboard/profile.php', 'protected' => true],
    'dashboard/orders'       => ['view' => '/../app/pages/dashboard/settings.php', 'protected' => true],
    'dashboard/recommendations'       => ['view' => '/../app/pages/dashboard/settings.php', 'protected' => true],
];

// Try to match route (static or dynamic)
$routeMatched = false;
// require_once __DIR__ . '../config/dbConfig.php';

foreach ($routes as $routePattern => $routeConfig) {
    // Convert route pattern to regex
    $regexPattern = preg_replace('#:([\w]+)#', '(?P<\1>[^/]+)', $routePattern);
    $regexPattern = '#^' . $regexPattern . '$#';

    if (preg_match($regexPattern, $url, $matches)) {
        $routeMatched = true;

        // Extract dynamic params
        $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        foreach ($params as $key => $value) {
            $_GET[$key] = $value; // Add to $_GET for convenience
        }

        $currentUserRole = null;

        // Check for protected routes
        if (!empty($routeConfig['protected'])) {
            require_once __DIR__ . '/../app/middleware/protected.php';
            $currentUserRole = $_SESSION['role'];
        }

        // Check role access if 'roles' are defined
        if (isset($routeConfig['roles']) && !in_array($currentUserRole, $routeConfig['roles'])) {
            require_once __DIR__ . '/404.html';
            break;
        }

        // Load the view/controller
        require_once __DIR__ . $routeConfig['view'];
        break;
    }
}

// If no route matched, load 404 page
if (!$routeMatched) {
    require_once __DIR__ . '/404.html';
}
