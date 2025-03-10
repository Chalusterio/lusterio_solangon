<head>
  <style>
        body {
            background-color: #F6F0F0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        
    /* Sidebar Base */
    .sidebar {
      background-color: #F6F0F0 !important;
      padding: 15px;
      width: 250px;
      min-height: 100vh;
      border-right: 2px solid #E0D6D6;
    }

    /* Sidebar Navigation */
    .sidebar-nav {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-nav .nav-item {
      margin-bottom: 10px;
    }

    .sidebar-nav .nav-item a {
      color: #735240 !important;
      font-weight: bold;
      display: flex;
      align-items: center;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 8px;
      transition: background 0.3s ease;
    }

    .sidebar-nav .nav-item a:hover {
      background-color: #EAE3E3;
    }

    /* Icons */
    .sidebar-nav .nav-item a i {
      color: #735240 !important;
      font-size: 1.2rem;
      margin-right: 10px;
    }
  </style>
</head>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="#" id="loadDashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <!-- Inventory -->
    <li class="nav-item">
      <a class="nav-link" href="#" id="loadInventory">
        <i class="bi bi-box-seam"></i>
        <span>Inventory</span>
      </a>
    </li><!-- End Inventory Nav -->

    <!-- Low Stock Alerts -->
    <li class="nav-item">
      <a class="nav-link" href="#" id="loadLowStockAlerts">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Low Stock Alerts</span>
      </a>
    </li><!-- End Low Stock Alerts Nav -->

  </ul>
</aside><!-- End Sidebar -->

<main id="main" class="main">
  <!-- Content will be loaded here -->
</main>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Use event delegation to ensure event listeners remain after content loads
    $(document).on("click", "#loadDashboard", function(event) {
        event.preventDefault();
        $("#main").load("sidebar/dashboard.php");
    });

    $(document).on("click", "#loadInventory", function(event) {
        event.preventDefault();
        $("#main").load("sidebar/inventory.php");
    });

    $(document).on("click", "#loadLowStockAlerts", function(event) {
        event.preventDefault();
        $("#main").load("sidebar/low_stock.php");
    });
});
</script>
