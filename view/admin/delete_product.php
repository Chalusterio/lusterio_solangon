<?php
include("../../dB/config.php");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]); 

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "success"]);
    } else {
        echo json_encode(["message" => "error: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "Invalid request."]);
}
?>
