<?php
include("../../dB/config.php");

header('Content-Type: application/json'); // Ensure response is JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $stock_quantity = isset($_POST['stock_quantity']) ? intval($_POST['stock_quantity']) : 0;

    if ($id > 0) {
        // Prepare and execute update query
        $query = "UPDATE products SET stock_quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die(json_encode(["status" => "error", "message" => "Database error: " . $conn->error]));
        }

        $stmt->bind_param("ii", $stock_quantity, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Stock updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database update failed: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid product ID!"]);
    }
    
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method!"]);
}
