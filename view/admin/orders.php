<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="container py-5">
    <h2 class="page-title">Orders</h2>

    <!-- Order Summary -->
    <div class="order-summary">
        <div class="order-card">
            <h3>Total Orders</h3>
            <h1>15,101</h1>
        </div>
        <div class="order-card">
            <h3>New Orders</h3>
            <h1>3,874</h1>
        </div>
        <div class="order-card">
            <h3>Delivered Orders</h3>
            <h1>5,446</h1>
        </div>
        <div class="order-card">
            <h3>Cancelled Orders</h3>
            <h1>556</h1>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-container">
        <table id="ordersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Created At</th>
                    <th>Items</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Cha Lusterio<br><small>cha@gmail.com</small></td>
                    <td>02 Jan 2025</td>
                    <td>2</td>
                    <td>PayMaya</td>
                    <td> ₱245.00</td>
                    <td><span class="status status-delivered">Delivered</span></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Krysel Tiempo<br><small>ktiempo@gmail.com</small></td>
                    <td>14 Jan 2025</td>
                    <td>2</td>
                    <td>Gcash</td>
                    <td>₱210.00</td>
                    <td><span class="status status-shipping">Shipping</span></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Ezra Marinas<br><small>ezra@gmail.com</small></td>
                    <td>04 Feb 2025</td>
                    <td>2</td>
                    <td>Cash on Delivery</td>
                    <td> ₱160.00</td>
                    <td><span class="status status-new">New</span></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Marisol Datahan<br><small>marisoll@gmail.com</small></td>
                    <td>05 Mar 2025</td>
                    <td>2</td>
                    <td>Gcash</td>
                    <td>₱170.00</td>
                    <td><span class="status status-pending">Pending</span></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Esther Eblacas<br><small>eblacas@gmail.com</small></td>
                    <td>06 Dec 2024</td>
                    <td>2</td>
                    <td>Credit Card</td>
                    <td>₱130.00</td>
                    <td><span class="status status-return">Return</span></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Therese Solangon<br><small>therese@gmail.com</small></td>
                    <td>06 Nov 2024</td>
                    <td>2</td>
                    <td>Credit Card</td>
                    <td>₱1000.00</td>
                    <td><span class="status status-return">Return</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include("./includes/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $("#ordersTable").DataTable({
        "paging": true,
        "searching": true,
        "ordering": false,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
});
</script>

<style>
    body {
        background: linear-gradient(to right, #F3EDE8, #E6D2C2);
        font-family: 'Poppins', sans-serif;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        flex-direction: column;
    }

    /* Page Title */
    .page-title {
        text-align: center;
        font-weight: bold;
        color: white;
        background: linear-gradient(135deg, #A67C52, #CBA35C);
        padding: 14px;
        border-radius: 12px;
        box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
        font-size: 22px;
        width: 100%;
        max-width: 600px;
        margin-bottom: 20px;
    }

    /* Order Summary Container */
    .order-summary {
        display: flex;
        gap: 20px;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    /* Glassmorphism Order Cards */
    .order-card {
        flex: 1;
        background: rgba(255, 255, 255, 0.85);
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 3px 3px 12px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease-in-out;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.15);
    }

    .order-card h3 {
        font-size: 16px;
        color: #5A3D2B;
        margin-bottom: 5px;
    }

    .order-card h1 {
        font-size: 28px;
        font-weight: bold;
        color: #735240;
    }

    /* Table Container */
    .table-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        width: 100%;
        max-width: 1200px;
    }

    /* Table Styles */
    .table {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 0;
        background: rgba(255, 255, 255, 0.9);
    }

    /* Table Header */
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

    /* Table Body */
    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 15px;
        font-size: 14px;
        border-bottom: 1px solid #ddd;
    }

    /* Table Row Hover */
    .table tbody tr:hover {
        background: #FDF8F3;
        transform: scale(1.01);
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08);
    }

    /* Status Labels */
    .status {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: bold;
        display: inline-block;
        color: white;
        font-size: 12px;
    }

    .status-delivered { background: #ADE498; } /* Green */
    .status-shipping { background: #7FDBDA; } /* Blue */
    .status-new { background: #EDE682; } /* Orange */
    .status-pending { background: #FEBF63; } /* Dark Orange */
    .status-return { background: #F38181; } /* Red */

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .order-summary {
            flex-direction: column;
            gap: 15px;
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
