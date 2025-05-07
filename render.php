<?php
    function render($view, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . "/views/{$view}.php";
        $content = ob_get_clean();
        include __DIR__ . './layout.php';
    }
?>
