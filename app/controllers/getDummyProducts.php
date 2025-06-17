<?php
    // if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //     // Fetch dummy data from API
    //     $apiUrl = 'https://dummyjson.com/products/categories';
    //     $json = file_get_contents($apiUrl);
    //     $data = json_decode($json, true);
    //     require_once __DIR__ . '/../models/products.php' ;
    //     foreach ($data as $category) {
    //         require_once __DIR__ . '/../../config/dbConfig.php' ;
    //         $slug = $category['slug'];
    //         $name= $category['name'];
    //         $url = $category['url'];
    //         $sql = "INSERT INTO categories (name, url, slug) 
    //                 VALUES (?, ?, ?)";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bind_param("sss", $name, $url, $slug);
    //         if($stmt->execute()){
    //             echo "Products inserted/updated successfully."; 
    //         };
                    

    //     }
    //     exit();
    //     //         $sql = "INSERT INTO VendorProducts (product_name, img_url, quantity, product_size, descriptions, price, username) 
    //     //                 VALUES (?, ?, ?, ?, ?, ?, ?)";
    //     //         $stmt = $conn->prepare($sql);
    //     //         $stmt->bind_param("ssissds", $name, $img, $quantity, $size, $description, $price, $username);
    //     //         $stmt->execute();
    //     //         echo "Products inserted/updated successfully."; 
    //     //     }
           
            
           
    //     // } else {
    //     //     echo "No products found in API response.";
    //     // }
    // }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Fetch dummy data from API
        $apiUrl = 'https://dummyjson.com/products/category/fragrances?limit=2';
        $json = file_get_contents($apiUrl);
        $data = json_decode($json, true);
        if (!empty($data['products'])) {
            require_once __DIR__ . '/../models/products.php' ;
            foreach ($data['products'] as $product) {
                $name = $product['title'];
                $quantity= $product['stock'];
                $img = '/upload/img';
                $size = 'xxl';
                $description = $product['description'];
                $price= $product['price'];
                $username = "ayomideokubule";
                $sql = "INSERT INTO VendorProducts (product_name, img_url, quantity, product_size, descriptions, price, category_id, username) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $category_id = 1;
                $stmt->bind_param("ssissdis", $name, $img, $quantity, $size, $description, $price, $category_id, $username);
                if($stmt->execute()){
                    echo "Products inserted/updated successfully."; 
                }
            }
           
        } else {
            echo "No products found in API response.";
        }
    }
?>