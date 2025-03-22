<?php
include("../../dB/config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["product_name"], $_POST["product_description"], $_POST["price"], $_POST["stock_quantity"], $_POST["size"])) {
        
        $name = $conn->real_escape_string($_POST["product_name"]);
        $description = $conn->real_escape_string($_POST["product_description"]);
        $price = floatval($_POST["price"]);
        $stock = intval($_POST["stock_quantity"]);
        $size = $conn->real_escape_string($_POST["size"]);

        $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, price, stock_quantity, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $name, $description, $price, $stock, $size);

        if ($stmt->execute()) {
            $response = [
                "message" => "success",
                "id" => $stmt->insert_id,
                "product_name" => $name,
                "product_description" => $description,
                "price" => $price,
                "stock_quantity" => $stock,
                "size" => $size
            ];
        } else {
            $response = ["message" => "error: " . $stmt->error];
        }

        $stmt->close();
    } else {
        $response = ["message" => "All fields are required!"];
    }
} else {
    $response = ["message" => "Invalid request method."];
}

echo json_encode($response);
?>
