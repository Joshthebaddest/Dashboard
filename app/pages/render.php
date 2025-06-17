<?php
    function render($view, $data = [], $fileDir) {
        extract($data);
        ob_start();
        include __DIR__ . "/../views/{$fileDir}/{$view}.php";
        $content = ob_get_clean();
        include __DIR__ . '/../views/layout/layout.php';
    }
?>
