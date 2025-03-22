<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch stock data
$stockQuery = "SELECT size, SUM(stock_quantity) AS total_stock FROM products GROUP BY size";
$stockResult = $conn->query($stockQuery);

// Fetch low stock alerts
$lowStockQuery = "SELECT product_name, stock_quantity FROM products WHERE stock_quantity < 5"; 
$lowStockResult = $conn->query($lowStockQuery);

// Prepare data for chart
$stockLabels = [];
$stockValues = [];

if ($stockResult->num_rows > 0) {
    while ($row = $stockResult->fetch_assoc()) {
        $stockLabels[] = $row['size'];
        $stockValues[] = (int)$row['total_stock'];
    }
}

$stockLabelsJSON = json_encode($stockLabels);
$stockValuesJSON = json_encode($stockValues);
?>

<div class="wrapper d-flex">
  <main class="content flex-grow-1">
    <div class="container">
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

      <!-- Stock and Transactions -->
      <div class="row equal-height">
        <div class="col-lg-6">
          <div class="chart-container">
            <h4>Jewelry Stock Overview</h4>
            <canvas id="jewelryStockChart"></canvas>
          </div>
        </div>

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
                <tr><td>6</td><td>Sophia Diaz</td><td>₱6,000</td><td>Mar 1, 2024</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Low Stock Alerts -->
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
  </main>
</div>

<?php include("./includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var stockLabels = <?php echo $stockLabelsJSON; ?>;
  var stockValues = <?php echo $stockValuesJSON; ?>;

  var ctx = document.getElementById("jewelryStockChart").getContext("2d");
  var jewelryStockChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: stockLabels,
      datasets: [{
        label: "Stock Quantity",
        data: stockValues,
        backgroundColor: ["#735240", "#A66E38", "#D5B89D", "#6E4E32"],
        borderRadius: 8,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: { grid: { display: false } },
        y: { grid: { color: "#E0D6D6" }, beginAtZero: true }
      }
    }
  });
</script>

<style>
  body {
    background-color: #F6F0F0;
    font-family: 'Poppins', sans-serif;
  }

  .container-fluid {
    padding: 20px;
    max-width: 100%;
    overflow-x: hidden;
  }

  h2 {
    color: #735240;
    font-weight: bold;
    text-align: left;
    letter-spacing: 1px;
  }

  .dashboard-card {
    border-radius: 15px;
    color: white;
    padding: 20px;
    box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.15);
  }

  .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 4px 4px 18px rgba(0, 0, 0, 0.2);
  }

  .card-sales { background: linear-gradient(135deg, #A66E38, #AB886D); }
  .card-orders { background: linear-gradient(135deg, #A67C52, #6E4E32); }
  .card-visitors { background: linear-gradient(135deg, #D5B89D, #A47E5C); }

  .chart-container, .table-container {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.1);
  }

  .chart-container { height: 400px; }
  .table-container { height: 400px; }

  .table-container table { width: 100%; }

  .alert-low-stock {
    background: #9D5C4A;
    color: white;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 12px;
    font-weight: bold;
  }

  @media (max-width: 992px) {
    .row { flex-wrap: wrap; }
    .col-lg-4 { flex: 1 1 100%; }
  }

  @media (max-width: 768px) {
    .container-fluid { padding: 10px; }
  }

  .equal-height {
    display: flex;
    align-items: stretch;
    flex-wrap: wrap;
  }

  .chart-container, .table-container {
    flex: 1;
    min-height: 350px;
  }

  .main-content {
    margin-left: 220px;
    width: calc(100% - 220px);
  }
  /* Wrapper for Sidebar & Content */
.wrapper {
    display: flex;
    min-height: 100vh;
    transition: all 0.3s ease-in-out;
}

/* Sidebar Styling */
.sidebar {
    width: 260px;
    transition: width 0.3s ease-in-out;
}

.sidebar.collapsed {
    width: 80px;
}

/* Main Content */
.content {
    flex-grow: 1;
    transition: margin-left 0.3s ease-in-out;
    margin-left: 260px; /* Default when sidebar is visible */
}

/* When Sidebar is Collapsed */
.sidebar.collapsed + .content {
    margin-left: 80px;
}

/* Mobile Responsive */
@media (max-width: 992px) {
    .sidebar {
        width: 80px;
    }
    .content {
        margin-left: 80px;
    }
}

</style>