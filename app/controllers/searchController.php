<?php
    require_once __DIR__ .'/../../config/globalConfig.php';
    require_once __DIR__ . '/../models/products.php';
    require_once __DIR__ . '/../models/users.php';
    if(isset($_GET['search'])){
        require_once __DIR__ . '/../utils/features.php';
        $searchField = htmlspecialchars($_GET['search']);
        $params = ['search' => $searchField];
        $search = http_build_query($params);
        $result = Product::query()
            -> search($searchField, ['product_name', 'username'])
            ->getWithPagination();
        $data = $result['data'];
        $matchedOn = 'unknown';
        if(count($data) > 0){
            foreach($data as $row){
                if (stripos($row['product_name'], $searchField) !== false) {
                    $matchedOn = 'product';
                    header('Location: '. BASE_PATH .'products?'.$search);
                    exit();
                } elseif (stripos($row['username'], $searchField) !== false) {
                    $matchedOn = 'vendor';
                    header('Location: '. BASE_PATH .'vendors?'.$search);
                    exit();
                }
            }
        }else{
            $result = Category::query()
                -> search($searchField, ['name', 'slug'])
                ->getWithPagination();
            $data = $result['data'];
            if(count($data) > 0){
                foreach($data as $row){
                    $result = Product::query()
                        -> search($searchField, ['product_name', 'username'])
                        ->getWithPagination();
                    $data = $result['data'];
                }
                $matchedOn = 'category';
                header('Location: '. BASE_PATH . 'products/category?'.$search);
                exit();
            }
        }
        $_SESSION['data'] = $data;
    };
?>