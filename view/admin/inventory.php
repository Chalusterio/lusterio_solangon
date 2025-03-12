<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch all products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Inventory</title>

    <!-- Bootstrap & DataTables -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <style>
        body {
            background: linear-gradient(to right, #F3EDE8, #E6D2C2);
            font-family: 'Poppins', sans-serif;
        }

        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        /* Page Title */
        h2 {
            color: #735240;
            font-weight: bold;
            text-align: center;
            background: linear-gradient(135deg, #A67C52, #CBA35C);
            padding: 14px;
            border-radius: 12px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
            font-size: 22px;
            color: white;
        }

        /* Table Container */
        .table-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            margin-top: 20px;
        }

        /* Table Styling */
        .table {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0;
            background: rgba(255, 255, 255, 0.95);
        }

        .table th {
            background: linear-gradient(135deg, #735240, #AB886D);
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            vertical-align: middle;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 15px;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }

        /* Hover Effect */
        .table tbody tr:hover {
            background: #FDF8F3;
            transform: scale(1.01);
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* Action Buttons */
        .btn {
            transition: all 0.3s ease-in-out;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Edit Button */
        .edit-btn {
            background: linear-gradient(135deg, #5A3D2B, #8B5E3B);
            color: white;
            border: none;
        }

        /* Delete Button */
        .delete-btn {
            background: linear-gradient(135deg, #D9534F, #C9302C);
            color: white;
            border: none;
        }

        /* Modal Enhancements */
        .modal-content {
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .modal-header {
            background: linear-gradient(135deg, #735240, #AB886D);
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-title {
            font-weight: bold;
        }

        .btn-success {
            background: linear-gradient(135deg, #27AE60, #2ECC71);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #2ECC71, #1E8449);
        }

        /* Form Inputs */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #D5C4B1;
            background: #FDF8F3;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            border-color: #A67C52;
            box-shadow: 0 0 10px rgba(166, 124, 82, 0.3);
            outline: none;
        }

        /* Success Messages */
        #successMessage, #editSuccessMessage {
            text-align: center;
            font-weight: bold;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
        }

        .alert-success {
            background: #C9E4A3;
            color: #2E7D32;
        }

        /* Responsive Fixes */
        @media (max-width: 992px) {
            .table-container {
                padding: 15px;
            }

            .modal-content {
                padding: 15px;
            }
        }
        a {
            text-decoration: none !important;
            color: inherit;
        }
        a:hover, a:focus {
            text-decoration: none !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Stock Inventory</h2>
        <button class="btn" style="background-color: #735240; color: white;" data-bs-toggle="modal" data-bs-target="#addProductModal">
            + Add Product
        </button>
    </div>

    <div class="table-container">
        <table id="inventoryTable" class="table table-striped">
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
                        <td><?= $row['stock_quantity']; ?></td>
                        <td><?= $row['size']; ?></td>
                        <td>
                            <button class="btn edit-btn" data-id="<?= $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#editProductModal" style="background-color: #5A3D2B; color: white; border: none;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn delete-btn" data-id="<?= $row['id']; ?>" style="background-color: #D9534F; color: white; border: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    <div class="mb-3"><label>Product Name</label><input type="text" name="product_name" class="form-control" required></div>
                    <div class="mb-3"><label>Description</label><textarea name="product_description" class="form-control" required></textarea></div>
                    <div class="mb-3"><label>Price</label><input type="number" name="price" class="form-control" step="0.01" required></div>
                    <div class="mb-3"><label>Stock</label><input type="number" name="stock_quantity" class="form-control" required></div>
                    <div class="mb-3">
                        <label>Size</label>
                        <select name="size" class="form-select" required>
                            <option value="Adjustable">Adjustable</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Add Product</button>
                </form>

                <!-- Success message -->
                <div id="successMessage" class="alert alert-success mt-3" style="display: none;">
                    Product successfully added!
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <input type="hidden" name="id" id="editProductId">
                    <div class="mb-3"><label>Product Name</label><input type="text" name="product_name" id="editProductName" class="form-control" required></div>
                    <div class="mb-3"><label>Description</label><textarea name="product_description" id="editProductDescription" class="form-control" required></textarea></div>
                    <div class="mb-3"><label>Price</label><input type="number" name="price" id="editProductPrice" class="form-control" step="0.01" required></div>
                    <div class="mb-3"><label>Stock</label><input type="number" name="stock_quantity" id="editProductStock" class="form-control" required></div>
                    <div class="mb-3">
                        <label>Size</label>
                        <select name="size" id="editProductSize" class="form-select" required>
                            <option value="Adjustable">Adjustable</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update Product</button>
                </form>

                <!-- Success message -->
                <div id="editSuccessMessage" class="alert alert-success mt-3" style="display: none;">
                    Product successfully updated!
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#inventoryTable").DataTable({
        "ordering": false  // Disable sorting for all columns
    });

    // Handle product addition via AJAX
    $("#addProductForm").submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: "add_product.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.message === "success") {
                    $("#successMessage").show();
                    $("#addProductForm")[0].reset();

                    let newRow = `
                    <tr id="row-${response.id}">
                        <td>${response.id}</td>
                        <td>${response.product_name}</td>
                        <td>${response.product_description}</td>
                        <td>₱${parseFloat(response.price).toFixed(2)}</td>
                        <td>${response.stock_quantity}</td>
                        <td>${response.size}</td>
                        <td>
                            <button class="btn edit-btn" data-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editProductModal" style="background-color: #5A3D2B; color: white; border: none;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn delete-btn" data-id="${response.id}" style="background-color: #D9534F; color: white; border: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;

                    $("#productTableBody").append(newRow);

                    setTimeout(function() {
                        $("#successMessage").fadeOut();
                    }, 1000);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("An error occurred while adding the product.");
            }
        });
    });

    // Handle product deletion via AJAX
    $(document).on("click", ".delete-btn", function() {
        let productId = $(this).data("id");
        let row = $(this).closest("tr");

        // SweetAlert Confirmation
        Swal.fire({
            title: "Are you sure?",
            text: "This product will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "delete_product.php",
                    type: "GET",
                    data: { id: productId },
                    dataType: "json",
                    success: function(response) {
                        if (response.message === "success") {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The product has been deleted.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            row.fadeOut(500, function() {
                                $(this).remove();
                            });
                        } else {
                            Swal.fire("Error!", "Failed to delete the product.", "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "An error occurred while deleting the product.", "error");
                    }
                });
            }
        });
    });

    // Load product data into the edit modal
    $(document).on("click", ".edit-btn", function() {
        let productId = $(this).data("id");

        $.ajax({
            url: "get_product.php",  // This PHP file should return product details in JSON format
            type: "GET",
            data: { id: productId },
            dataType: "json",
            success: function(product) {
                $("#editProductId").val(product.id);
                $("#editProductName").val(product.product_name);
                $("#editProductDescription").val(product.product_description);
                $("#editProductPrice").val(product.price);
                $("#editProductStock").val(product.stock_quantity);
                $("#editProductSize").val(product.size);
            },
            error: function() {
                alert("Failed to load product details.");
            }
        });
    });

    // Handle product update via AJAX
    $("#editProductForm").submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: "update_product.php", // This PHP file should update the product in the database
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.message === "success") {
                    $("#editSuccessMessage").show();

                    // Update the product row in the table
                    let updatedRow = `
                        <td>${response.id}</td>
                        <td>${response.product_name}</td>
                        <td>${response.product_description}</td>
                        <td>₱${parseFloat(response.price).toFixed(2)}</td>
                        <td>${response.stock_quantity}</td>
                        <td>${response.size}</td>
                        <td>
                            <button class="btn btn-primary edit-btn" data-id="${response.id}" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger delete-btn" data-id="${response.id}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    `;
                    $("#row-" + response.id).html(updatedRow);

                    setTimeout(function() {
                        $("#editSuccessMessage").fadeOut();
                        $("#editProductModal").modal("hide");
                    }, 1000);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("An error occurred while updating the product.");
            }
        });
    });

    // Hide success message when modal opens again
    $("#addProductModal").on("show.bs.modal", function() {
        $("#successMessage").hide();
    });

    $("#editProductModal").on("show.bs.modal", function() {
        $("#editSuccessMessage").hide();
    });
});
</script>

</body>
</html>