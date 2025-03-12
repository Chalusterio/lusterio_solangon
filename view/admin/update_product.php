<?php
include("../../dB/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $size = $_POST['size'];

    $query = $conn->prepare("UPDATE products SET product_name=?, product_description=?, price=?, stock_quantity=?, size=? WHERE id=?");
    $query->bind_param("ssdisi", $product_name, $product_description, $price, $stock_quantity, $size, $id);

    if ($query->execute()) {
        echo json_encode(["message" => "success", "id" => $id, "product_name" => $product_name, "product_description" => $product_description, "price" => $price, "stock_quantity" => $stock_quantity, "size" => $size]);
    } else {
        echo json_encode(["message" => "error"]);
    }
}
?>
