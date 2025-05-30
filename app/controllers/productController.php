<?php 
    $dir = realpath(__DIR__);
    require_once($dir . '/../data.php');
    require_once($dir . '/../controllers/fileUploadController.php');
    $product_name = $product_size = $quantity = $descriptions = $price = $img_url = "";

    $errors = [];
    $type = isset($_GET["type"]) ? $_GET["type"] : "";
    $productId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    if (!$type) {
        header('Location: ../pages/products.php');
        exit();
    }

    $username = $_SESSION['user'] ?? null;
    if (!$username) {
        echo "Unauthorized. Please login.";
        exit();
    }

    // ----------------------------------------
    // GET: Fetch data for Edit form
    // ----------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "GET" && $type === "edit" && $productId > 0) {
        $sql = "SELECT * FROM VendorProducts WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            echo "Product not found.";
            exit();
        }

        // Prefill form data (optional for rendering)
        $product_name = $row['product_name'];
        $img_url = $row['img_url'];
        $product_size = $row['product_size'];
        $quantity = $row['quantity'];
        $descriptions = $row['descriptions'];
        $price = $row['price'];
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
        $img_url = "";

        // Handle image upload
        $uploadResult = handleFileUpload("img_url");
        if ($uploadResult['success']) {
            $img_url = $uploadResult['filePath'];
        } elseif ($type === "edit") {
            $img_url = test_input($_POST["img_url"]); // keep previous image
        } else {
            $errors["img_url"] = $uploadResult['error'];
        }

        // Validate inputs
        validate_product_form($product_name, $img_url, $product_size, $quantity, $descriptions, $price);       

        if (empty($errors)) {
            require_once($dir . '/../models/products.php');
            if ($type === "add") {
                $sql = "INSERT INTO VendorProducts (product_name, img_url, quantity, product_size, descriptions, price, username) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssissds", $product_name, $img_url, $quantity, $product_size, $descriptions, $price, $username);
            } else { // edit
                $sql = "UPDATE VendorProducts 
                        SET product_name = ?, img_url = ?, quantity = ?, product_size = ?, descriptions = ?, price = ?
                        WHERE product_id = ? AND username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssissdis", $product_name, $img_url, $quantity, $product_size, $descriptions, $price, $productId, $username);
            }

            if ($stmt->execute()) {
                header('Location: ../pages/products.php');
                exit();
            } else {
                echo "Database error: " . $stmt->error;
            }
        }
    }

    // ----------------------------------------
    // GET: Delete Product
    // ----------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "GET" && $type === "delete" && $productId > 0) {
        $sql = "DELETE FROM VendorProducts WHERE product_id = ? AND username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $productId, $username);

        if ($stmt->execute()) {
            header('Location: ../pages/products.php');
            exit();
        } else {
            echo "Error deleting product: " . $stmt->error;
        }
    }

    // ----------------------------------------
    // Helper Functions
    // ----------------------------------------

    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    function validate_product_form($product_name, $img_url, $product_size, $quantity, $descriptions, $price) {
        global $errors;

        if (empty($product_name)) {
            $errors["product_name"] = "Product name is required.";
        }

        if (empty($img_url)) {
            $errors["img_url"] = "Product image is required.";
        } elseif (!preg_match("/\.(jpg|jpeg|png|gif)$/i", $img_url)) {
            $errors["img_url"] = "Invalid image format.";
        }

        if (empty($product_size)) {
            $errors["product_size"] = "Size is required.";
        }

        if (empty($quantity) || !filter_var($quantity, FILTER_VALIDATE_INT) || $quantity <= 0) {
            $errors["quantity"] = "Quantity must be a positive number.";
        }

        if (empty($descriptions)) {
            $errors["descriptions"] = "Description is required.";
        }

        if (empty($price) || !filter_var($price, FILTER_VALIDATE_FLOAT) || $price <= 0) {
            $errors["price"] = "Price must be a positive number.";
        }
    }
?>
