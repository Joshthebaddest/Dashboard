<?php
    $dir = realpath(__DIR__);
    // Check if a file is uploaded
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // Define the upload directory
        $uploadDirectory ='../public/uploads/';
        
        // Make sure the upload directory exists
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Get file information
        $fileName = $file['name'];
        $fileTmpPath = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // Get the file extension
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allowed file types (extensions)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if the file type is allowed
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo "Error: Invalid file type.";
            exit;
        }

        // Check for any errors during upload
        if ($fileError !== 0) {
            echo "Error: There was a problem with the upload.";
            exit;
        }

        // Check the file size (optional, e.g., limit to 5MB)
        if ($fileSize > 5 * 1024 * 1024) {
            echo "Error: File is too large. Max size is 5MB.";
            exit;
        }

        // Generate a unique file name to prevent overwriting existing files
        $newFileName = uniqid() . '.' . $fileExtension;

        // Move the uploaded file to the desired directory
        $destination = $uploadDirectory . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            require($dir.'/../middleware/protected.php');
            if(isset($_SESSION["user"])){
                $user = $_SESSION["user"];
                include('../models/users.php');
                // Insert file path and size into the database
                $sql = "UPDATE $users_table SET profileImg = ? WHERE username = ?";
                $result = $conn->prepare($sql);
                $result -> bind_param("ss", $destination, $user);

                if ($result->execute()) {
                    echo 'File uploaded and saved to database successfully.';
                    header("Location: ../pages/editUser.php");
                } else {
                    echo 'Failed to save file information to database.';
                }
                $result->close();
                $conn->close();
                exit();
            }else{
                echo($_SESSION["user"]);
                // header("Location: ../controllers/logoutController.php");
            }
        } else {
            echo "Error: File upload failed.";
        }
    } else {
        echo "No file uploaded.";
    }
?>
