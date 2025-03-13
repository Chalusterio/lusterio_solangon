<head>
  <style>
    body {
        background: linear-gradient(to right, #F3EDE8, #E6D2C2);
        font-family: 'Poppins', sans-serif;
    }

    /* Sidebar Base */
    .sidebar {
        background: rgba(255, 255, 255, 0.85);
        width: 260px;
        min-height: 100vh;
        padding: 15px;
        box-shadow: 3px 0px 10px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(12px);
        transition: width 0.3s ease-in-out;
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
        padding: 12px 18px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .sidebar-nav .nav-item a:hover {
        background: rgba(220, 200, 180, 0.7);
        transform: scale(1.03);
    }

    /* Icons */
    .sidebar-nav .nav-item a i {
        color: #735240 !important;
        font-size: 1.3rem;
        margin-right: 12px;
    }

    /* Dropdown Styling */
    .nav-content {
        padding-left: 30px;
        display: none;
    }

    .nav-content li a {
        font-size: 14px;
        padding: 10px 18px;
        display: flex;
        align-items: center;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .nav-content li a:hover {
        background: rgba(220, 200, 180, 0.7);
        transform: scale(1.02);
    }

    .nav-content li a i {
        font-size: 1rem;
        margin-right: 10px;
    }

    /* Dropdown Animation */
    .nav-content.collapse.show {
        display: block !important;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Sidebar Toggle for Mobile */
    @media (max-width: 992px) {
        .sidebar {
            width: 80px;
            overflow: hidden;
        }

        .sidebar:hover {
            width: 260px;
        }

        .sidebar .sidebar-nav .nav-item a {
            justify-content: center;
        }

        .sidebar .sidebar-nav .nav-item a span {
            display: none;
        }

        .sidebar:hover .sidebar-nav .nav-item a span {
            display: inline;
        }

        .nav-content {
            display: none !important;
        }

        .sidebar:hover .nav-content {
            display: block !important;
        }
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
                    <i class="bi bi-person-plus"></i><span>Add User</span>
                </a>
            </li>
            <li>
                <a href="user_list.php">
                    <i class="bi bi-people"></i><span>User List</span>
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
