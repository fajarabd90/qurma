<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $password = $_POST['password'];
  $password = filter_var($password, FILTER_SANITIZE_STRING);
  $select = $conn_pdo->prepare("SELECT * FROM `user` WHERE email = ? AND password = ?");
  $select->execute([$email, $password]);
  $row = $select->fetch(PDO::FETCH_ASSOC);

  if ($select->rowCount() > 0) {
    if ($row['role'] == 'admin') {
      $_SESSION['admin'] = $row['id'];
      header('location:administrator/index.php');
    } elseif ($row['role'] == 'koordinator') {
      $_SESSION['koordinator'] = $row['id'];
      header('location:koordinator/index.php');
    } elseif ($row['role'] == 'guru') {
      $_SESSION['guru'] = $row['id'];
      header('location:guru/index.php');
    } elseif ($row['role'] == 'siswa') {
      $_SESSION['siswa'] = $row['id'];
      header('location:siswa/index.php');
    } else {
      $message[] = 'Pengguna tidak ditemukan!';
    }
  } else {
    $message[] = 'E-mail atau password tidak sesuai!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sign in | Qurma</title>
  <link rel="shortcut icon" href="assets/img/logo.png" />
  <link href="dist/css/app.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-12/assets/css/login-12.css">
  <style>
    .password-container {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      z-index: 1;
    }
  </style>
</head>

<body>
  <!-- Login 12 - Bootstrap Brain Component -->
  <section class="py-3 py-md-5 py-xl-8">
    <div class="container">
      <div class="row mb-3">
        <div class="col-12">
          <div class="container">
            <div class="row justify-content-center align-items-center">
              <div class="col-auto">
                <img src="assets/img/logo.png" alt="" height="100" class="mb-2">
              </div>
              <div class="col-auto">
                <h2 class="display-5 fw-bold text-center">Sign in</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
          <div class="row gy-5 justify-content-center">
            <div class="col-12 col-lg-5">
              <form action="" method="post">
                <div class="row gy-3 overflow-hidden">
                  <?php
                  if (isset($message)) {
                    foreach ($message as $message) {
                      echo '
         <div class="alert alert-danger mb-2" role="alert"">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
                    }
                  }
                  ?>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control border-0 border-bottom rounded-0" name="email" id="email" placeholder="name@example.com" required>
                      <label for="email" class="form-label">Email</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control border-0 border-bottom rounded-0" name="password" id="password" value="" placeholder="Password" required>
                      <label for="password" class="form-label">Password</label>
                      <div class="password-toggle" id="togglePassword" onclick="togglePasswordVisibility()">
                        <i id="eyeIcon" class='far fa-eye'></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button class="btn btn-lg btn-dark rounded-0 fs-6" name="submit" type="submit">Log in</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-12 col-lg-2 d-flex align-items-center justify-content-center gap-3 flex-lg-column">
              <div class="bg-dark h-100 d-none d-lg-block" style="width: 1px; --bs-bg-opacity: .1;"></div>
              <div class="bg-dark w-100 d-lg-none" style="height: 1px; --bs-bg-opacity: .1;"></div>
              <div>or</div>
              <div class="bg-dark h-100 d-none d-lg-block" style="width: 1px; --bs-bg-opacity: .1;"></div>
              <div class="bg-dark w-100 d-lg-none" style="height: 1px; --bs-bg-opacity: .1;"></div>
            </div>
            <div class="col-12 col-lg-5 d-flex align-items-center">
              <div class="d-flex gap-3 flex-column w-100 ">
                <a href="data-munaqosyah/index.php" class="btn bsb-btn-2xl btn-outline-dark rounded-0 d-flex align-items-center">
                  <i class='fas fa-edit'></i>
                  <span class="ms-2 fs-6 flex-grow-1">Lengkapi Data Munaqosyah</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="dist/js/app.js"></script>
  <script>
    function togglePasswordVisibility() {
      var passwordField = document.getElementById("password");
      var toggleButton = document.getElementById("togglePassword");

      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.innerHTML = "<i class='far fa-eye-slash'></i>";
      } else {
        passwordField.type = "password";
        toggleButton.innerHTML = "<i class='far fa-eye'></i>";
      }
    }
  </script>

</body>

</html>