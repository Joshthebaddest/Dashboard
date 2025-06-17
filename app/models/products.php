<?php 
    require_once __DIR__ .'/../../config/models.php';

    class Product extends Model {
        protected static $table = 'vendorproducts';

        protected static $rules = [
            'product_name' => 'string|required',
            'img_url' => 'string|required',
            'product_size' => 'string', 
            'quantity' => 'int|required',
            'description' => 'string|required',
            'price' => 'int|required',
            'username' => 'string|required',
        ];
    }
?>
