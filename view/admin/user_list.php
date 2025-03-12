<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php"); // Database connection

$query = "SELECT userId, CONCAT(firstName, ' ', lastName) AS fullName, phoneNumber, email, role, createdAt FROM users ORDER BY createdAt DESC";
$result = $conn->query($query);
?>

<div class="container py-5">
    <h2 class="page-title">User List</h2>

    <div class="card">
        <table id="userTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Join Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr id="row_<?php echo $row["userId"]; ?>">
                            <td><?php echo $row["userId"]; ?></td>
                            <td><?php echo $row["fullName"]; ?></td>
                            <td><?php echo $row["phoneNumber"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo !empty($row["role"]) ? ucfirst($row["role"]) : "No Role"; ?></td>
                            <td><?php echo date("Y/m/d", strtotime($row["createdAt"])); ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['userId']; ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No users found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("./includes/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $("#userTable").DataTable({
        "paging": true,
        "searching": true,
        "ordering": false,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "responsive": true,
        "autoWidth": false
    });

    // Delete User Confirmation
    $(".delete-btn").click(function() {
        var userId = $(this).data("id");
        var row = $("#row_" + userId);

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "delete_user.php",
                    type: "POST",
                    data: { id: userId },
                    success: function(response) {
                        if (response == "success") {
                            Swal.fire({
                                title: "Deleted!",
                                text: "User has been deleted.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            row.fadeOut(500, function() { $(this).remove(); });
                        } else {
                            Swal.fire("Error!", "User could not be deleted.", "error");
                        }
                    }
                });
            }
        });
    });
});
</script>

<style>
    body {
        background-color: #F6F0F0;
        font-family: 'Poppins', sans-serif;
    }

    .page-title {
        text-align: center;
        font-weight: bold;
        color: #735240;
        margin-bottom: 25px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
        background: white;
        padding: 30px;
        width: 100%;
    }

    .table {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
    }

    .table th {
        background: #735240;
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 14px;
        text-transform: uppercase;
    }

    .table td {
        color: #5A3D2B;
        text-align: center;
        vertical-align: middle;
        padding: 15px;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background: #FDF8F3;
    }

    /* Delete Button */
    .btn-danger {
        background: #D9534F;
        border: none;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn-danger:hover {
        background: #C9302C;
    }

    /* DataTables Styling */
    .dataTables_wrapper {
        padding: 20px;
    }

    .dataTables_length, .dataTables_filter {
        margin-bottom: 15px;
    }

    a {
        text-decoration: none !important;
        color: inherit;
    }

    a:hover, a:focus {
        text-decoration: none !important;
    }
</style>
