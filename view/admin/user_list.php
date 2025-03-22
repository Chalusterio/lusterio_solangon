<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

$query = "SELECT userId, CONCAT(firstName, ' ', lastName) AS fullName, phoneNumber, email, role, createdAt FROM users ORDER BY createdAt DESC";
$result = $conn->query($query);
?>

<div class="wrapper d-flex">
  <main class="content flex-grow-1">
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
            <tr>
              <td colspan="7" class="text-center">No users found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include("./includes/footer.php"); ?>

<!-- JS & Plugin Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<script>
  $(document).ready(function() {
    // Initialize DataTables
    $("#userTable").DataTable({
      paging: true,
      searching: true,
      ordering: false,
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      responsive: true,
      autoWidth: false,
      language: {
        lengthMenu: "Show _MENU_ entries",
        paginate: {
          previous: "Previous",
          next: "Next"
        }
      }
    });

    // Delete Confirmation
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
            data: {
              id: userId
            },
            success: function(response) {
              if (response == "success") {
                Swal.fire({
                  title: "Deleted!",
                  text: "User has been deleted.",
                  icon: "success",
                  timer: 1500,
                  showConfirmButton: false
                });
                row.fadeOut(500, function() {
                  $(this).remove();
                });
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

<!-- Styles -->
<style>
  body {
    background: linear-gradient(to right, #F3EDE8, #E6D2C2);
    font-family: 'Poppins', sans-serif;
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
    margin-left: 260px;
    transition: margin-left 0.3s ease-in-out;
  }

  .sidebar.collapsed+.content {
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

  .page-title {
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

  .card {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.15);
    max-width: 1000px;
    margin: auto;
  }

  .table th {
    background: linear-gradient(135deg, #735240, #AB886D);
    color: white;
    text-align: center;
    padding: 15px;
    font-size: 14px;
    text-transform: uppercase;
  }

  .table td {
    text-align: center;
    vertical-align: middle;
    padding: 15px;
    font-size: 14px;
    color: #5A3D2B;
  }

  .table {
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 0;
    background: rgba(255, 255, 255, 0.9);
  }

  .table tbody tr:nth-child(even) {
    background: rgba(245, 224, 202, 0.6);
  }

  .table tbody tr:hover {
    background: #FDF8F3;
    transform: scale(1.01);
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08);
  }

  .btn-danger {
    background: linear-gradient(135deg, #D9534F, #C9302C);
    border: none;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: bold;
    color: white;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #C9302C, #A0201F);
    transform: scale(1.05);
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
  }

  .text-center {
    font-weight: bold;
    color: #735240;
    padding: 15px;
  }

  /* DataTables Customization */
  .dataTables_wrapper .dataTables_length select {
    border-radius: 12px;
    padding: 5px;
    border: 1px solid #D5C4B1;
    background: #FDF8F3;
    font-size: 14px;
    box-shadow: inset 2px 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease-in-out;
  }

  .dataTables_wrapper .dataTables_filter input {
    border-radius: 12px;
    padding: 5px;
    border: 1px solid #D5C4B1;
    background: #FDF8F3;
    font-size: 14px;
    box-shadow: inset 2px 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease-in-out;
  }

  .dataTables_wrapper .dataTables_length select:focus,
  .dataTables_wrapper .dataTables_filter input:focus {
    border-color: #A67C52;
    box-shadow: 0 0 10px rgba(166, 124, 82, 0.3);
    outline: none;
  }

  a {
    text-decoration: none !important;
    color: inherit;
  }

  a:hover,
  a:focus {
    text-decoration: none !important;
  }
</style>