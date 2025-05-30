<?php 
$dir = realpath(__DIR__);
include($dir.'/../../config/dbConfig.php');
$products_table = "VendorProducts";

$sql = "CREATE TABLE IF NOT EXISTS $products_table (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    img_url TEXT NOT NULL,
    product_size VARCHAR(100),
    quantity INT NOT NULL,
    descriptions TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    username VARCHAR(150) NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user FOREIGN KEY (username) 
        REFERENCES techusers(username)
        ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE){
    // echo("Table $products_table created successfully");
} else {
    echo("Error creating table: " . $conn->error);
}
?>
