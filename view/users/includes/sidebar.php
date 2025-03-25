<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sidebar Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #F3EDE8, #E6D2C2);
            font-family: 'Poppins', sans-serif;
        }

        #greeting {
            background: #fff6f1;
            padding: 16px 20px;
            margin-bottom: 20px;
            border-radius: 14px;
            color: #5b3c2a;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.1rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease-in-out;
        }

        #greeting i {
            font-size: 1.7rem;
            color: #e09572;
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

<body>

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <div id="greeting">
            <i class="bi bi-sun"></i>
            <span id="greeting-text"></span>
        </div>

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="inventory.php">
                    <i class="bi bi-box-seam"></i>
                    <span>Inventory</span>
                </a>
            </li><!-- End Inventory Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="low_stock.php">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Low Stock Alerts</span>
                </a>
            </li><!-- End Low Stock Alerts Nav -->

        </ul>
    </aside><!-- End Sidebar -->
    <script>
        const greetingText = document.getElementById("greeting-text");
        const greetingIcon = document.querySelector("#greeting i");

        const hour = new Date().getHours();
        if (hour < 12) {
            greetingText.textContent = "Good Morning!";
            greetingIcon.className = "bi bi-sun";
        } else if (hour < 18) {
            greetingText.textContent = "Good Afternoon!";
            greetingIcon.className = "bi bi-cloud-sun";
        } else {
            greetingText.textContent = "Good Evening!";
            greetingIcon.className = "bi bi-moon-stars";
        }
    </script>