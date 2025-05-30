<?php
// public/index.php
$url = $_GET['url'] ?? '';


// echo($page);
// exit();

// Define route-to-file map
$routes = [
    'home'         => ['view' => '/../app/views/home.php'],
    'auth/login'   => ['view' => '/../app/views/login.php'],
    'auth/signup'  => ['view' => '/../app/views/signup.php'],
    'auth/logout'  => ['view' => '/../app/controllers/logoutController.php'],
    'dashboard'    => ['view' => '/../app/pages/dashboard.php', 'protected' => true],
    'products'     => ['view' => '/../app/pages/products.php', 'protected' => true],
    'users'        => ['view' => '/../app/pages/users.php', 'protected' => true],
    'profile'      => ['view' => '/../app/pages/profile.php', 'protected' => true],
    'settings'     => ['view' => '/../app/pages/settings.php', 'protected' => true],
];

// Check if route exists
if (isset($routes[$page])) {
    $route = $routes[$page];

    // Load protected middleware if required
    if (!empty($route['protected'])) {
        require_once __DIR__ . '/../app/middleware/protected.php';
    }

    // Load the route file
    require_once __DIR__ . $route['view'];
} else {
    // Route not found
    require_once __DIR__ . '/404.html';
}
