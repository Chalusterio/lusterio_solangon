<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch low stock products
$query = "SELECT id, product_name, stock_quantity FROM products WHERE stock_quantity <5 ORDER BY stock_quantity ASC";
$result = $conn->query($query);
?>

<div class="wrapper d-flex">
    <main class="content flex-grow-1">
        <h2 class="mb-4">
            <i class="fa-solid fa-triangle-exclamation"></i> Low Stock Alerts
        </h2>

        <div class="low-stock-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="low-stock-item">
                            <div>
                                <i class="fa-solid fa-box-open low-stock-icon"></i>
                                <strong>' . $row['product_name'] . '</strong> is running low!
                            </div>
                            <span class="stock-count">Only ' . $row['stock_quantity'] . ' left</span>
                        </div>
                    ';
                }
            } else {
                echo '
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i> ✅ All products have sufficient stock.
                    </div>
                ';
            }
            ?>
        </div>
    </main>
</div>

<?php include("./includes/footer.php"); ?>

<!-- Styles -->
<style>
    body {
        background-color: #F6F0F0;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        padding: 30px;
        margin-top: 50px;
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

    .low-stock-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .low-stock-item {
        background: linear-gradient(135deg, #E8D1C5, #C7A17A);
        color: #5A3D2B;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 12px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.2s ease-in-out, box-shadow 0.3s;
    }

    .low-stock-item:hover {
        transform: scale(1.02);
        background: linear-gradient(135deg, #DCC3B1, #B98A64);
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.15);
    }

    .low-stock-item .stock-count {
        background: white;
        padding: 5px 15px;
        border-radius: 5px;
        font-weight: bold;
        color: #735240;
        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .low-stock-item:hover .stock-count {
        background: #F8E9E2;
        color: #5A3D2B;
    }

    .alert-success {
        background: #C9E4A3;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        font-weight: bold;
        color: #2E7D32;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease-in-out;
    }

    .alert-success:hover {
        background: #B8DA92;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .low-stock-icon {
        font-size: 1.5rem;
        margin-right: 10px;
        color: #735240;
        transition: transform 0.3s ease-in-out;
    }

    .fa-triangle-exclamation {
        font-size: 1.5rem;
        color: #D65A31;
        animation: warning-pulse 1.5s infinite alternate ease-in-out;
    }

    @keyframes warning-pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(1.1);
            opacity: 0.8;
        }
    }

    a {
        text-decoration: none !important;
        color: inherit;
    }

    a:hover,
    a:focus {
        text-decoration: none !important;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
        transition: all 0.3s ease-in-out;
        justify-content: center;
        /* Ensures centering when sidebar is hidden */
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
        margin-left: 280px;
        /* Default kapag expanded */
        padding: 20px;
        max-width: calc(100% - 280px);
    }

    /* Center content when sidebar is hidden */
    .sidebar.collapsed+.content {
        margin-left: auto;
        margin-right: auto;
        max-width: 900px;
        /* Adjust for better centering */
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Ensures all elements are centered */
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