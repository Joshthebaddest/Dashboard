<?php 
    require_once __DIR__ .'/../../config/models.php';

    class Category extends Model {
        protected static $table = 'categories';

        protected static $rules = [
            'name' => 'string|required',
            'url' => 'string|required',
            'slug' => 'date|required',
        ];
    }
?>