<?php
    function render($view, $fileDir, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . "/../views/{$fileDir}/{$view}.php";
        $content = ob_get_clean();
        include __DIR__ . '/../views/layout/layout.php';
    }
?>
