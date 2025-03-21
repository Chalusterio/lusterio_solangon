<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Register</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/SLlogo1.png" rel="icon">
  <link href="assets/img/SLlogo1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Custom Theme Styling -->
  <style>
    body {
      background-color: #F6F0F0;
      font-family: 'Poppins', sans-serif;
    }

    .card {
      border-radius: 15px;
      box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      color: #735240;
      font-weight: bold;
    }

    .btn-primary {
      background: linear-gradient(135deg, #A66E38, #AB886D);
      border: none;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #AB886D, #A66E38);
    }

    .form-label {
      color: #735240;
      font-weight: 500;
    }

    a {
      text-decoration: none !important;
      color: #735240;
    }

    a:hover {
      color: #A66E38;
    }
  </style>
</head>

<?php session_start(); ?>
<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="card mb-3 w-100">
                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" action="./controller/registration.php" method="POST" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">First Name</label>
                      <input type="text" name="firstName" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your first name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourLastName" class="form-label">Last Name</label>
                      <input type="text" name="lastName" class="form-control" id="yourLastName" required>
                      <div class="invalid-feedback">Please enter your last name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email Address</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please choose an email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourCPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="cpassword" class="form-control" id="yourCPassword" required>
                      <div class="invalid-feedback">Please confirm your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPhone" class="form-label">Phone Number</label>
                      <input type="text" name="phoneNumber" class="form-control" id="yourPhone" pattern="09[0-9]{9}" minlength="11" maxlength="11" required>
                      <div class="invalid-feedback">Please enter a valid 11-digit phone number!</div>
                    </div>

                    <div class="col-12">
                      <label for="gender" class="form-label">Gender</label>
                      <select class="form-select" name="gender" required>
                        <option selected disabled>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>

                    <div class="col-12">
                      <label for="birthday" class="form-label">Birthday</label>
                      <input type="date" name="birthday" class="form-control" id="birthday" required>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="registration">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="./login.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php
  if(isset($_SESSION['message']) && $_SESSION['code'] !='') {
      ?>
      <script>
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "<?php echo $_SESSION['code']; ?>",
          title: "<?php echo $_SESSION['message']; ?>"
        });
      </script>
      <?php
      unset($_SESSION['message']);
      unset($_SESSION['code']);
  }
  ?>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
