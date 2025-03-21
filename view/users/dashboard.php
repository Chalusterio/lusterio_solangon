<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch stock summary
$stockSummaryQuery = "
    SELECT 
        SUM(CASE WHEN stock_quantity < 5 THEN stock_quantity ELSE 0 END) AS low_stock,
        SUM(CASE WHEN stock_quantity BETWEEN 5 AND 20 THEN stock_quantity ELSE 0 END) AS medium_stock,
        SUM(CASE WHEN stock_quantity > 20 THEN stock_quantity ELSE 0 END) AS high_stock
    FROM products";
$stockSummary = $conn->query($stockSummaryQuery)->fetch_assoc();

// Fetch recent user activity
$recentActivity = [
    ["Added 'Silver Necklace' to cart", "Mar 10, 2025"],
    ["Purchased 'Gold Ring'", "Mar 9, 2025"],
    ["Browsed 'Mystic Beads Bracelet'", "Mar 8, 2025"],
    ["Reviewed 'Diamond Earrings'", "Mar 7, 2025"],
    ["Wishlist updated - 'Pearl Pendant'", "Mar 6, 2025"],
];

// Fetch featured products
$featuredProductsQuery = "SELECT product_name, price, stock_quantity FROM products ORDER BY RAND() LIMIT 3";
$featuredProducts = $conn->query($featuredProductsQuery);

// Fetch top-selling products
$topSellingQuery = "SELECT product_name, price, stock_quantity FROM products ORDER BY stock_quantity DESC LIMIT 3";
$topSellingProducts = $conn->query($topSellingQuery);
?>

<style>
    body {
        background-color: #F6F0F0;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        color: #735240;
        font-weight: bold;
        text-align: left;
        letter-spacing: 1px;
    }

    .dashboard-card {
        border-radius: 12px;
        color: white;
        padding: 20px;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s, box-shadow 0.3s;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 3px 3px 20px rgba(0, 0, 0, 0.2);
    }

    .card-low {
        background: linear-gradient(135deg, #A66E38, #AB886D);
    }

    .card-medium {
        background: linear-gradient(135deg, #A67C52, #CBA35C);
    }

    .card-high {
        background: linear-gradient(135deg, #A47E5C, #D5B89D);
    }

    .btn-dark {
        background-color: #735240;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease-in-out;
    }

    .btn-dark:hover {
        background-color: #5a3d2f;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .table-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .table-container:hover {
        transform: translateY(-5px);
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.15);
    }

    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.1);
    }

    .equal-height-container {
        display: flex;
        gap: 20px;
        align-items: stretch;
    }

    .equal-height-container > .table-container {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        flex-grow: 1;
    }

    .product-list .card-box {
        flex: 1 1 calc(33.33% - 10px);
        max-width: 32%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .product-list .card-box:hover {
        transform: scale(1.03);
        box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.15);
    }

    .product-list .card-box h5 {
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #735240;
    }

    .product-list .card-box p {
        margin: 5px 0;
        font-size: 14px;
    }

    .product-list .card-box .btn {
        margin-top: auto;
        background-color: #735240;
        color: white;
        border: none;
        transition: all 0.3s;
    }

    .product-list .card-box .btn:hover {
        background-color: #5a3d2f;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    }

    .list-group-item {
        background: rgba(255, 255, 255, 0.8);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 8px;
        box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.08);
    }

    .list-group-item small {
        color: #666;
        font-size: 12px;
        float: right;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
        transition: all 0.3s ease-in-out;
    }

    .sidebar {
        width: 260px;
        transition: width 0.3s ease-in-out;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .content {
        flex-grow: 1;
        transition: margin-left 0.3s ease-in-out;
        margin-left: 260px;
    }

    .sidebar.collapsed + .content {
        margin-left: 80px;
    }

    @media (max-width: 992px) {
        .sidebar {
            width: 80px;
        }

        .content {
            margin-left: 80px;
        }
    }
</style>

<div class="wrapper d-flex">  
    <main class="content flex-grow-1">
        <h2 class="mb-4">User Dashboard</h2>

        <div class="row">
            <div class="col-lg-4">
                <div class="card dashboard-card card-low mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold">Low Stock</h5>
                        <h4><?= $stockSummary['low_stock']; ?> Items</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card dashboard-card card-medium mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold">Medium Stock</h5>
                        <h4><?= $stockSummary['medium_stock']; ?> Items</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card dashboard-card card-high mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold">High Stock</h5>
                        <h4><?= $stockSummary['high_stock']; ?> Items</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="equal-height-container">
            <div class="table-container">
                <h4 class="fw-bold">Recent Activity</h4>
                <ul class="list-group flex-grow-1">
                    <?php foreach ($recentActivity as $activity): ?>
                        <li class="list-group-item"><?= $activity[0] ?> <small class="text-muted"><?= $activity[1] ?></small></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="table-container">
                <h4 class="fw-bold">Top Selling Products</h4>
                <div class="product-list">
                    <?php while ($product = $topSellingProducts->fetch_assoc()): ?>
                        <div class="card card-box text-center">
                            <h5><?= $product['product_name']; ?></h5>
                            <p>₱<?= number_format($product['price'], 2); ?></p>
                            <p class="text-muted">Stock: <?= $product['stock_quantity']; ?></p>
                            <button class="btn btn-sm btn-dark">View Details</button>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="table-container">
                    <h4 class="fw-bold">Featured Products</h4>
                    <div class="product-list">
                        <?php while ($product = $featuredProducts->fetch_assoc()): ?>
                            <div class="card card-box text-center">
                                <h5><?= $product['product_name']; ?></h5>
                                <p>₱<?= number_format($product['price'], 2); ?></p>
                                <p class="text-muted">Stock: <?= $product['stock_quantity']; ?></p>
                                <button class="btn btn-sm btn-dark">View Details</button>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="chart-container">
                    <h4 class="fw-bold">Stock Summary</h4>
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("stockChart").getContext("2d");

        var gradientLow = ctx.createLinearGradient(0, 0, 0, 400);
        gradientLow.addColorStop(0, "#A66E38");
        gradientLow.addColorStop(1, "#AB886D");

        var gradientMedium = ctx.createLinearGradient(0, 0, 0, 400);
        gradientMedium.addColorStop(0, "#A67C52");
        gradientMedium.addColorStop(1, "#CBA35C");

        var gradientHigh = ctx.createLinearGradient(0, 0, 0, 400);
        gradientHigh.addColorStop(0, "#A47E5C");
        gradientHigh.addColorStop(1, "#D5B89D");

        var stockData = {
            labels: ["Low Stock", "Medium Stock", "High Stock"],
            datasets: [{
                label: "Stock Count",
                data: [
                    <?= $stockSummary['low_stock'] ?? 0; ?>,
                    <?= $stockSummary['medium_stock'] ?? 0; ?>,
                    <?= $stockSummary['high_stock'] ?? 0; ?>
                ],
                backgroundColor: [gradientLow, gradientMedium, gradientHigh],
                borderColor: "#735240",
                borderWidth: 1
            }]
        };

        new Chart(ctx, {
            type: "bar",
            data: stockData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>

<?php include("./includes/footer.php"); ?>
