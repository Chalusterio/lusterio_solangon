<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY id ASC");
?>

<div class="wrapper d-flex">  
    <main class="content flex-grow-1">
        <h2 class="mb-4">Stock Inventory</h2>

        <!-- Inventory Search Bar -->
        <input type="text" id="inventorySearch" class="form-control" placeholder="Search for products...">

        <div class="table-container mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr id="row-<?= $row['id']; ?>">
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['product_name']; ?></td>
                            <td><?= $row['product_description']; ?></td>
                            <td>₱<?= number_format($row['price'], 2); ?></td>
                            <td>
                                <input 
                                    type="number" 
                                    class="stock-input" 
                                    data-id="<?= $row['id']; ?>" 
                                    value="<?= $row['stock_quantity']; ?>">
                            </td>
                            <td><?= $row['size']; ?></td>
                            <td>
                                <button class="update-btn" data-id="<?= $row['id']; ?>">Update</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include("./includes/footer.php"); ?>

<!-- JavaScript & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inventory Search
        $("#inventorySearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#productTableBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Handle stock update via AJAX
        $(".update-btn").click(function() {
            let productId = $(this).data("id");
            let newStock = $(this).closest("tr").find(".stock-input").val();

            $.ajax({
                url: "update_stock.php",
                type: "POST",
                data: { id: productId, stock_quantity: newStock },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        Swal.fire({
                            title: "Updated!",
                            text: "Stock has been updated successfully.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire("Error!", "AJAX request failed: " + error, "error");
                }
            });
        });
    });
</script>

<style>
    body {
        background-color: #F6F0F0;
        font-family: 'Poppins', sans-serif;
        margin-top: 50px;
    }

    .container {
        padding: 30px;
    }

    h2 {
        text-align: center;
    font-weight: bold;
    color: white;
    background: linear-gradient(135deg, #A67C52, #CBA35C);
    padding: 14px;
    border-radius: 12px;
    font-size: 22px;
    margin-bottom: 20px;
    max-width: 600px;
    margin: 20px auto;
    box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
    }

    #inventorySearch {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
    }

    #inventorySearch:focus {
        outline: none;
        border: 1px solid #A67C52;
        box-shadow: 0px 0px 10px rgba(166, 124, 82, 0.3);
    }

    .table-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(8px);
    }

    .table {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead th {
        background: linear-gradient(135deg, #735240, #AB886D);
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 14px;
        text-transform: uppercase;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .table tbody tr:nth-child(even) {
        background: rgba(245, 224, 202, 0.6);
    }

    .table tbody tr {
        transition: all 0.3s ease-in-out;
    }

    .table tbody tr:hover {
        background: #FDF8F3;
        transform: scale(1.01);
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08);
    }

    .table td {
        color: #5A3D2B;
        text-align: center;
        vertical-align: middle;
        padding: 15px;
        font-size: 14px;
    }

    .stock-input {
        width: 60px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 5px;
        transition: all 0.3s ease-in-out;
    }

    .stock-input:focus {
        border-color: #A67C52;
        box-shadow: 0px 0px 5px rgba(166, 124, 82, 0.3);
        outline: none;
    }

    .update-btn {
        background: linear-gradient(135deg, #5A3D2B, #735240);
        color: white;
        border: none;
        padding: 8px 12px;
        font-size: 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .update-btn:hover {
        background: linear-gradient(135deg, #4A2C1D, #5A3D2B);
        transform: scale(1.05);
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.15);
    }

    .wrapper {
    display: flex;
    min-height: 100vh;
    transition: all 0.3s ease-in-out;
    justify-content: center; /* Ensures centering when sidebar is hidden */
}

.sidebar {
    width: 260px;
    transition: width 0.3s ease-in-out;
}

.sidebar.collapsed {
    width: 0;
}

.content {
    flex-grow: 1;
    transition: all 0.3s ease-in-out;
    margin-left: 280px; /* Default kapag expanded */
    padding: 20px;
    max-width: calc(100% - 280px);
}

/* Center content when sidebar is hidden */
.sidebar.collapsed + .content {
    margin-left: auto;
    margin-right: auto;
    max-width: 900px; /* Adjust for better centering */
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center; /* Ensures all elements are centered */
}

/* Mobile Responsiveness */
@media (max-width: 992px) {
    .sidebar {
        width: 0;
    }

    .content {
        margin-left: auto;
        margin-right: auto;
        max-width: 900px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
}

</style>
