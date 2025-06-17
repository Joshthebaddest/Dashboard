<?php 
    require_once __DIR__ .'/../../config/models.php';

    class Cart extends Model {
        protected static $table = 'carts';

        protected static $rules = [
            'cart_id' => 'string|required',
            'product_id' => 'string|required',
            'quantity' => 'int|required',
        ];
    }

    class CartItem extends Model {
        protected static $table = 'cartitems';

        protected static $rules = [
            'user_id' => 'string|required',
        ];
    }
?>
