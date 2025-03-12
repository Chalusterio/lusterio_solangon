<?php
include("../../dB/config.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Prepare delete query
    $query = "DELETE FROM users WHERE userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "success"; // Response for AJAX
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();
?>
