<?php
include("../../dB/config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $product = $result->fetch_assoc();

    echo json_encode($product);
}
?>
