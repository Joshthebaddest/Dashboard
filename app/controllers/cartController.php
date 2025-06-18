<?php
    require_once __DIR__ .'/../utils/cartFunc.php';
    require_once __DIR__ .'/../../config/globalConfig.php';

    $user = isset($_SESSION['user']) ?? null;
    $cart = new CartManager($user); 
    $carts = $cart -> getCart();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = htmlspecialchars($_POST['product_id']);
        $quantity = isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : null;
        if(isset($_POST['type'])){
            if ($_POST['type'] === 'increment' && !empty($product_id)) {
                $cart -> increment($product_id);
            }

            if ($_POST['type'] === 'decrement' && !empty($product_id)) {
                $cart -> decrement($product_id);
            }

            if ($_POST['type'] === 'delete' && !empty($product_id)) {
                $cart -> remove($product_id);
            }

            if ($_POST['type'] === 'clear') {
                $cart -> clearCart();
            }
            header('Location: '. BASE_PATH .'cart');
        }else{
            if(!empty($product_id) && !empty($quantity)){
                $cart -> add($product_id, $quantity);
            }
        }
    }
?>