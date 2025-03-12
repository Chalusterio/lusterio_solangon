<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST["first_name"]);
    $lastName = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]); // Storing plaintext passwords is not recommended!
    $phoneNumber = trim($_POST["phone"]);
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $role = strtolower(trim($_POST["role"]));
    $verification = 0; // Default verification status

    // Fetch the last user ID
    $result = $conn->query("SELECT MAX(userId) as last_id FROM users");
    $row = $result->fetch_assoc();
    $nextUserId = $row['last_id'] ? $row['last_id'] + 1 : 1;

    // Insert into users table
    $sql = "INSERT INTO users (userId, firstName, lastName, email, password, phoneNumber, gender, birthday, role, verification, createdAt) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssi", $nextUserId, $firstName, $lastName, $email, $password, $phoneNumber, $gender, $birthday, $role, $verification);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>User registered successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<div class="container py-5">
    <h2 class="page-title">Register New User</h2>
    <div class="card">
        <div class="card-body">
            <form id="registerUserForm">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter first name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter last name" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" pattern="09[0-9]{9}" minlength="11" maxlength="11"
                        placeholder="09XXXXXXXXX" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Birthday</label>
                        <input type="date" name="birthday" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <div id="userResponse" class="mt-3"></div>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#registerUserForm").submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: "add_user.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $("#userResponse").html(response).fadeIn();

                // Ensure the success message is visible and centered
                $("#userResponse").css({
                    "text-align": "center",
                    "margin-top": "20px",
                    "border-radius": "8px",
                    "padding": "12px",
                    "font-weight": "bold"
                });

                // Smoothly hide success message after 5 seconds
                setTimeout(function() {
                    $("#userResponse").fadeOut("slow", function() {
                        $(this).html("");
                    });
                }, 5000);

                // Reset form fields
                $("#registerUserForm")[0].reset();
                
                // Prevent sidebar or layout shifts
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        });
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

    .page-title {
        text-align: center;
        font-weight: bold;
        color: white;
        background: linear-gradient(135deg, #A67C52, #CBA35C);
        padding: 14px;
        border-radius: 12px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        font-size: 22px;
        width: 100%;
        max-width: 600px;
        margin-bottom: 20px;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.95);
        padding: 40px;
        backdrop-filter: blur(10px);
        max-width: 600px;
        width: 100%;
        position: relative; /* Fix sidebar overlap issue */
    }

    .form-label {
        font-weight: bold;
        color: #5A3D2B;
        font-size: 16px;
    }

    .row {
        margin-bottom: 12px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #D5C4B1;
        background: #FDF8F3;
        font-size: 16px;
        box-shadow: inset 2px 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #A67C52;
        box-shadow: 0 0 10px rgba(166, 124, 82, 0.3);
        outline: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #735240, #AB886D);
        border: none;
        padding: 14px;
        font-size: 18px;
        font-weight: bold;
        transition: all 0.3s ease;
        border-radius: 10px;
        width: 100%;
        color: white;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5A3D2B, #735240);
        transform: scale(1.03);
        box-shadow: 3px 3px 12px rgba(0, 0, 0, 0.15);
    }

    /* ✅ Success Message Styling */
    #userResponse {
        margin-top: 20px;
        text-align: center;
        font-weight: bold;
        border-radius: 8px;
        padding: 12px;
        font-size: 16px;
    }

    .alert-success {
        background: #C9E4A3;
        color: #2E7D32;
    }

    .alert-danger {
        background: #F8D7DA;
        color: #C72C41;
    }


</style>
