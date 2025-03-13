<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php"); // Connect to database

// Fetch low-stock items (stock_quantity < 5)
$lowStockQuery = "SELECT product_name, stock_quantity FROM products WHERE stock_quantity < 5";
$lowStockResult = $conn->query($lowStockQuery);
?>

<div class="container-fluid py-4">
    <h2>Admin Dashboard</h2>

    <div class="row">
        <!-- Weekly Sales -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card dashboard-card card-sales mb-4">
                <div class="card-body">
                    <h5>Weekly Sales (₱)</h5>
                    <h4>₱25,000</h4>
                </div>
            </div>
        </div>

        <!-- Weekly Orders -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card dashboard-card card-orders mb-4">
                <div class="card-body">
                    <h5>Weekly Orders</h5>
                    <h4>45</h4>
                </div>
            </div>
        </div>

        <!-- Visitors Online -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card dashboard-card card-visitors mb-4">
                <div class="card-body">
                    <h5>Visitors Online</h5>
                    <h4>12</h4>
                </div>
            </div>
        </div>
    </div>

<!-- Jewelry Stock and Recent Transactions -->
<div class="row equal-height">
    <!-- Jewelry Stock Chart -->
    <div class="col-lg-6">
        <div class="chart-container">
            <h4>Jewelry Stock Overview</h4>
            <canvas id="jewelryStockChart"></canvas>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="col-lg-6">
        <div class="table-container">
            <h4>Recent Transactions</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Krysel Tiempo</td><td>₱1,000</td><td>Mar 5, 2024</td></tr>
                    <tr><td>2</td><td>Ezra Marinas</td><td>₱500</td><td>Mar 4, 2024</td></tr>
                    <tr><td>3</td><td>Esther Eblacas</td><td>₱2,200</td><td>Mar 3, 2024</td></tr>
                    <tr><td>4</td><td>Marisol Datahan</td><td>₱1,900</td><td>Mar 2, 2024</td></tr>
                    <tr><td>5</td><td>Therese Solangon</td><td>₱6,750</td><td>Mar 1, 2024</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <!-- Stock Alerts -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="table-container">
                <h4>Stock Alerts (Low Stock Items)</h4>
                <?php 
                if ($lowStockResult->num_rows > 0) {
                    while ($row = $lowStockResult->fetch_assoc()) {
                        echo '<div class="alert-low-stock"><strong>' . $row['product_name'] . '</strong> is running low! Only <strong>' . $row['stock_quantity'] . '</strong> left in stock.</div>';
                    }
                } else {
                    echo '<div class="alert-low-stock">No low-stock items at the moment.</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Sample Jewelry Stock Data
var stockLabels = ["Adjustable", "Small", "Medium", "Large"];
var stockValues = [20, 35, 50, 25]; // Sample stock values

// Render Jewelry Stock Chart
var ctx = document.getElementById("jewelryStockChart").getContext("2d");
var jewelryStockChart = new Chart(ctx, {
    type: "bar", // Changed to Bar Chart
    data: {
        labels: stockLabels,
        datasets: [{
            label: "Stock Quantity",
            data: stockValues,
            backgroundColor: ["#735240", "#A66E38", "#D5B89D", "#6E4E32"], /* Matching theme colors */
            borderRadius: 8,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        animation: {
            duration: 1500, // Smooth animation
            easing: "easeInOutQuart"
        },
        plugins: {
            legend: { display: false }, // Hide legend for a cleaner look
            tooltip: {
                enabled: true,
                backgroundColor: "rgba(0,0,0,0.8)",
                titleColor: "#fff",
                bodyColor: "#fff",
                borderColor: "#735240",
                borderWidth: 1
            }
        },
        scales: {
            x: {
                grid: { display: false }, // Remove X grid lines
                ticks: { color: "#735240", font: { size: 14, weight: "bold" } }
            },
            y: {
                grid: { color: "#E0D6D6" },
                ticks: { color: "#735240", font: { size: 14 } },
                beginAtZero: true
            }
        }
    }
});
</script>

<style>
    body {
        background-color: #F6F0F0;
        font-family: 'Poppins', sans-serif;
    }

    /* Dashboard Title */
    h2 {
        color: #735240;
        font-weight: bold;
        text-align: center;
        letter-spacing: 1px;
    }

    /* Dashboard Cards */
    .dashboard-card {
        border-radius: 15px;
        color: white;
        padding: 20px;
        box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 4px 4px 18px rgba(0, 0, 0, 0.2);
    }

    .card-sales { background: linear-gradient(135deg, #A66E38, #AB886D); }
    .card-orders { background: linear-gradient(135deg, #A67C52, #6E4E32); }
    .card-visitors { background: linear-gradient(135deg, #D5B89D, #A47E5C); }

    /* Chart Container */
    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .chart-container:hover {
        transform: scale(1.02);
    }

    /* Table Container */
    .table-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .table-container:hover {
        transform: translateY(-5px);
        box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.2);
    }

    /* Stock Alerts */
    .alert-low-stock {
        background: #9D5C4A;
        color: white;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 12px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-low-stock i {
        font-size: 1.4rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .dashboard-card {
            margin-bottom: 15px;
        }

        .chart-container, .table-container {
            margin-bottom: 15px;
        }
    }
    /* Ensure both sections have equal height */
    .equal-height {
        display: flex;
        align-items: stretch;
    }

    /* Ensure containers stretch properly */
    .chart-container, .table-container {
        flex: 1;
        min-height: 350px; /* Adjust as needed */
    }


</style>
