<?php 
    $dir = realpath(__DIR__);
    include_once __DIR__ . '/../../config/globalConfig.php';
    require_once($dir . '/../data.php');
    require($dir . '/fileUploadController.php');
    $product_name = $product_size = $quantity = $descriptions = $price = "";
    $images = [
        'img_url_0' => '',
        'img_url_1' => '',
        'img_url_2' => '',
        'img_url_3' => '',
        'img_url_4' => '',
    ];

    $errors = [];
    $type = isset($_GET["type"]) ? $_GET["type"] : "";
    $productId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    if (!$type) {
        header('Location: '.  BASE_PATH  .'dashboard/products');
        exit();
    }

    $username = $_SESSION['user'] ?? null;
    if (!$username) {
        header('Location: '.  BASE_PATH  .'auth/login');
        exit();
    }

    // ----------------------------------------
    // GET: Fetch data for Edit form
    // ----------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "GET" && $type === "edit" && $productId > 0) {
        require_once __DIR__ . '/../models/products.php';
        $product = Product::query()
            ->select('*')
            ->where('id', $productId)
            ->first();
        

        if (empty($product)) {
            echo "Product not found.";
            exit();
        }

        // Prefill form data (optional for rendering)
        $product_name = $product['product_name'];
        $product_size = $product['product_size'];
        $quantity = $product['quantity'];
        $descriptions = $product['description'];
        $price = $product['price'];

        require_once($dir . '/../models/product_images.php');
        // fetch images
        $imgs = ProductImage::query()
            ->select('*')
            ->where('product_id', $productId)
            ->get();
        $count = 0;
        foreach($imgs as $row){
            $images['img_url_'.$count] = $row['img_url'];
            $count++;
        }
    }

    // ----------------------------------------
    // POST: Add or Edit
    // ----------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && ($type === "add" || ($type === "edit" && $productId > 0))) {
        $product_name = test_input($_POST["product_name"]);
        $product_size = test_input($_POST["product_size"]);
        $quantity = test_input($_POST["quantity"]);
        $descriptions = test_input($_POST["descriptions"]);
        $price = test_input($_POST["price"]);
        $images = [];

        // Handle image uploads or reuse existing images
        foreach (['img_url_0', 'img_url_1', 'img_url_2', 'img_url_3', 'img_url_4'] as $key) {
            if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleFileUpload($key);
                if ($uploadResult['success']) {
                    $images[] = $uploadResult['filePath'];
                } else {
                    $errors[$key] = $uploadResult['error'];
                    break;
                }
            } elseif ($type === 'edit' && !empty($_POST[$key])) {
                $images[] = test_input($_POST[$key]); // keep existing image
            }
        }

        if ($type === 'add' && empty($images)) {
            $errors['images'] = "Please upload at least one image.";
        }

        $errors = validate_product_form($product_name, $product_size, $quantity, $descriptions, $price, $errors);

        if (empty($errors)) {
            require_once($dir . '/../models/products.php');
            try{
                $img_url = $images[0];
                if ($type === "add") {
                    $products = Product::create([
                        'product_name' => $product_name,
                        'img_url' => $img_url,
                        'quantity' => $quantity,
                        'product_size' => $product_size,
                        'description' => $descriptions,
                        'price' => $price,
                    ]);
                } else {
                    $products = Product::update(['id' => $productId, 'username' => $username], [
                        'product_name' => $product_name,
                        'img_url' => $img_url,
                        'quantity' => $quantity,
                        'product_size' => $product_size,
                        'description' => $descriptions,
                        'price' => $price,
                    ]);
                }

                $productId = ($type === "add") ? $stmt->insert_id : $productId;

                require_once($dir . '/../models/product_images.php');
                if ($type === 'edit') {
                    ProductImage::delete(['product_id' => $productId]);
                }

                // Insert current image list
                foreach ($images as $index => $img) {
                    $isMain = ($index === 0) ? 1 : 0;
                    ProductImage::create([
                        'product_id' => $productId,
                        'img_url' => $img,
                        'is_main' => $isMain
                    ]);
                }

                header('Location: '. BASE_PATH .'dashboard/products');
                exit();
            }catch(Exception $e){
                echo $e -> getMessage();
            }
        }
    }


    // ----------------------------------------
    // GET: Delete Product
    // ----------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "GET" && $type === "delete" && $productId > 0) {
        try{
            Product::delete(['product_id' => $productId, 'username' => $username]);
            header('Location: '. BASE_PATH .'/products.php');
            exit();
        } catch(Exception $e) {
            echo $e -> getMessage();
        }
    }

    // ----------------------------------------
    // Helper Functions
    // ----------------------------------------

    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    function validate_product_form($product_name, $product_size, $quantity, $descriptions, $price, $errors) {
        if (empty($product_name)) {
            $errors["product_name"] = "Product name is required.";
        }

        if (empty($product_size)) {
            $errors["product_size"] = "Size is required.";
        }

        if (empty($quantity) || !filter_var($quantity, FILTER_VALIDATE_INT) || $quantity <= 0) {
            $errors["quantity"] = "Quantity must be a positive number.";
        }

        if (empty($descriptions)) {
            $errors["description"] = "Description is required.";
        }

        if (empty($price) || !filter_var($price, FILTER_VALIDATE_FLOAT) || $price <= 0) {
            $errors["price"] = "Price must be a positive number.";
        }
        return $errors;
    }
?>
