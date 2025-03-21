<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login Page</title>
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
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your Email & password to login</p>
                  </div>

                  <form method="POST" action="./controller/login.php" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="email" class="form-label">Email Address</label>
                      <input type="email" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Please enter your email.</div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name='login'>Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have an account? <a href="./registration.php">Create an account</a></p>
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

  <!-- SweetAlert Toast Notification -->
  <?php
  if (isset($_SESSION['message']) && $_SESSION['code'] != '') {
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

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
