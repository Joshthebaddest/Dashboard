<?php 
    require_once __DIR__ .'/../../config/models.php';

    class ProductImage extends Model {
        protected static $table = 'product_images';

        protected static $rules = [
            'product_id' => 'int|required',
            'img_url' => 'string|required',
            'is_main' => 'boolean|required', 
        ];
    }
?>
