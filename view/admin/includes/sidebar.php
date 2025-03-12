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
            <a class="nav-link collapsed" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- User Management (Dropdown) -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#user-management-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>User Management</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="user-management-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="add_user.php">
                        <i class="bi bi-circle"></i><span>Add User</span>
                    </a>
                </li>
                <li>
                    <a href="user_list.php">
                        <i class="bi bi-circle"></i><span>User List</span>
                    </a>
                </li>
            </ul>
        </li><!-- End User Management Nav -->

        <!-- Orders -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="orders.php">
                <i class="bi bi-bag"></i>
                <span>Orders</span>
            </a>
        </li><!-- End Orders Nav -->

        <!-- Inventory -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="inventory.php">
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
            </a>
        </li><!-- End Inventory Nav -->

    </ul>

</aside><!-- End Sidebar -->
