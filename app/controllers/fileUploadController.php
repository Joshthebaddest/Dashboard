<?php
    function handleFileUpload($fileInput, $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'], $maxSizeMB = 5, $uploadPath = '../public/uploads/') {
        if (!isset($_FILES[$fileInput])) {
            return ['success' => false, 'error' => 'No file uploaded.'];
        }

        $file = $_FILES[$fileInput];
        $fileName = $file['name'];
        $fileTmpPath = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            return ['success' => false, 'error' => 'Invalid file type.'];
        }

        // Validate file error
        if ($fileError !== 0) {
            return ['success' => false, 'error' => 'Upload error code: ' . $fileError];
        }

        // Validate size
        if ($fileSize > $maxSizeMB * 1024 * 1024) {
            return ['success' => false, 'error' => 'File is too large. Max: ' . $maxSizeMB . 'MB'];
        }

        // Ensure directory exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Create unique filename
        $newFileName = uniqid() . '.' . $fileExtension;
        $destination = $uploadPath . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            return [
                'success' => true,
                'filePath' => $destination,
                'fileName' => $newFileName,
                'originalName' => $fileName,
                'fileSize' => $fileSize,
                'fileType' => $fileExtension
            ];
        } else {
            return ['success' => false, 'error' => 'Failed to move uploaded file.'];
        }
    }
?>
