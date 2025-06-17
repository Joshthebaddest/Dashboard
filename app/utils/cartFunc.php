<?php

class CartManager {
    protected $userId;

    public function __construct($userId = null) {
        $this->userId = $userId;
    }

    // Add item to cart
    public function add($productId, $quantity = 1) {
        if ($this->userId) {
            $this->addToDatabase($productId, $quantity);
        } else {
            $this->addToSession($productId, $quantity);
        }
    }

    // Get current cart
    public function getCart() {
        return $this->userId ? $this->getFromDatabase() : $this->getFromSession();
    }

    // Increment item quantity (wrapper for add)
    public function increment($productId, $amount = 1) {
        $this->add($productId, $amount);
    }

    // Decrement item quantity or remove if quantity <= 0
    public function decrement($productId, $amount = 1) {
        if ($this->userId) {
            try{
                $row = CartItem::query()
                    ->select('quantity')
                    ->where('cart_id', $cartId)
                    ->where('product_id', $productId)
                    ->first();
                if (!empty($row)) {
                    $newQuantity = $row['quantity'] - $amount;
                    if ($newQuantity > 0) {
                        $row = CartItem::update(['quantity' => $newQuantity], ['cart_id' => $cartId, 'product_id' => $productId]);
                    } else {
                        // Remove item if quantity <= 0
                        $this->remove($productId);
                    }
                }
            }catch(Exception $e){
                die("Prepare failed: ". $e -> getMessage());
            }
        } else {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] -= $amount;
                if ($_SESSION['cart'][$productId] <= 0) {
                    unset($_SESSION['cart'][$productId]);
                }
            }
        }
    }

    // Remove an item completely from cart
    public function remove($productId) {
        if ($this->userId) {
            try{
                CartItem::delete(['cart_id' => $this->cartId, 'product_id' => $productId]);
            }catch(Exception $e){
                die("Prepare failed: ". $e -> getMessage());
            }
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    }

    // Clear cart
    public function clearCart() {
        if ($this->userId) {
            try{
                require_once __DIR__ . '/../app/models/carts.php';
                CartItem::delete(['cart_id', $this ->cartId]);
                Cart::delete(['user_id', $this ->userId]);
            }catch(Exception $e){
                die("Prepare failed: ". $e -> getMessage());
            }
        } else {
            unset($_SESSION['cart']);
        }
    }

    // Migrate guest cart to DB on login
    public function migrateSessionCartToDatabase($userId) {
        if (!isset($_SESSION['cart'])) return;
        require_once __DIR__ . '/../app/models/carts.php';
        try{
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                // Check if product exists in DB cart
                $row = Cart::query()
                    ->select('*')
                    ->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();
                if (!empty($row)) {
                    $newQuantity = $row['quantity'] + $quantity;
                    Cart::update(['user_id' => $userId, 'product_id' => $productId], ['quantity' => $newQuantity]);
                } else {
                    Cart::create(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
                }
            }
        }catch(Exception $e){
            die("Prepare failed: ". $e -> getMessage());
        }
        unset($_SESSION['cart']);
    }

    // ------- Internal methods ---------

    protected function addToSession($productId, $quantity) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    protected function getFromSession() {
        return $_SESSION['cart'] ?? [];
    }

    protected function addToDatabase($productId, $quantity) {
        require_once __DIR__ . '/../app/models/carts.php';
        try{
            // Check if product exists in DB cart
            $row = Cart::query()
                ->select('quantity')
                ->where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();
            if (!empty($row)) {
                $newQuantity = $row['quantity'] + $quantity;
                Cart::update(['user_id' => $userId, 'product_id' => $productId], ['quantity' => $newQuantity]);
            } else {
                Cart::create(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
            }
        }catch(Exception $e){
            die("Prepare failed: ". $e -> getMessage());
        }
    }

    protected function getFromDatabase() {
        require_once __DIR__ . '/../app/models/carts.php';
        try{
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                // Check if product exists in DB cart
                $data = $this -> getCartId();
                $cart = [];
                if(!empty($data)){
                    $row = CartItem::query()
                        ->select('product_id', 'quantity')
                        ->where('cart_id', $data['id'])
                        ->get();
                    if(!empty($row)){
                        $cart[$row['product_id']] = $row['quantity'];
                    }
                }
                return $cart;
            }
        }catch(Exception $e){
            die("Prepare failed: ". $e -> getMessage());
        }
    }

    protected function getCartId(){
        require_once __DIR__ . '/../app/models/carts.php';
        try{
            $data = Cart::query()
                ->select('id')
                ->where('user_id', $userId)
                ->first();
            return $data['id'] ?? null;
        }catch(Exception $e){
            die("Prepare failed: ". $e -> getMessage());
        }
    }
}
