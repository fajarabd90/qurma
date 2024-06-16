<?php
include 'qurma/config.php';
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
      header('location:qurma/administrator/index.php');
    } elseif ($row['role'] == 'koordinator') {
      $_SESSION['koordinator'] = $row['id'];
      header('location:qurma/koordinator/index.php');
    } elseif ($row['role'] == 'guru') {
      $_SESSION['guru'] = $row['id'];
      header('location:qurma/guru/index.php');
    } elseif ($row['role'] == 'siswa') {
      $_SESSION['siswa'] = $row['id'];
      header('location:qurma/siswa/index.php');
    } else {
      $message[] = 'Pengguna tidak ditemukan!';
    }
  } else {
    $message[] = 'E-mail atau password tidak sesuai!';
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.104.2">
  <title>LMS Metode UMMI</title>
  <link rel="shortcut icon" href="assets/img/logo.png" />
  <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/pricing/">
  <link href="qurma/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .centered {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      /* Untuk membuatnya terpusat secara vertikal */
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

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check" viewBox="0 0 16 16">
      <title>Check</title>
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
  </svg>

  <div class="container py-3">
    <header>
      <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
          <img src="qurma/assets/img/logo.png" alt="" height="50" class="me-2">
          <span class="fs-4">Qur-Ma</span>
        </a>

        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
          <a class="me-3 py-2 text-dark text-decoration-none" href="index.php">Fitur</a>
          <a class="me-3 py-2 text-dark text-decoration-none" href="harga.php">Harga</a>
          <a class="py-2 text-dark text-decoration-none" href="about.php">Tentang Kami</a>
        </nav>
      </div>

      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <img src="qurma/assets/img/logo-ummi.png" alt="" height="100" class="mb-2">
        <h1 class="display-4 fw-normal">LMS Metode UMMI</h1>
        <p class="fs-5 text-muted">Solusi mudah administrasi Anda</p>
      </div>

      <center>
        <div class="d-grid gap-2 d-md-block mx-auto mb-3 col-6">
          <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#signin">Log-in</button>
          <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#demo">Get Demo</button>
          <a href="harga.php" class="btn btn-primary" role="button">Get Product</a>
        </div>
      </center>
    </header>

    <!-- Modal sign-in-->
    <div class="modal fade" id="signin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-sign-in-alt"></i> Log-in</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- Form sign-in -->
            <form action="" method="post">
              <center>
                <img class="mb-1" src="qurma/assets/img/logo-ummi.png" alt="" width="80" height="80">
                <h1 class="h3 mb-3 fw-normal">LMS Metode UMMI</h1>
              </center>
              <?php
              if (isset($message)) {
                foreach ($message as $msg) {
                  echo '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "' . addslashes($msg) . '",
                showConfirmButton: true,
                confirmButtonText: "OK"
            });
        });
        </script>
        ';
                }
              }
              ?>


              <div class="form-floating mb-2">

                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
              </div>
              <div class="form-floating mb-2">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <div class="password-toggle" id="password" onclick="togglePasswordVisibility()">
                  <i id="eyeIcon" class='far fa-eye'></i>
                </div>
              </div>
              <button class="w-100 btn btn-lg btn-primary mb-2" type="submit" name="submit">Submit</button>
            </form>
            <!-- Akhir form sign-in -->
          </div>
        </div>
      </div>
    </div>
    <!-- Akhir modal sign-in -->

    <!-- Modal demo-->
    <div class="modal fade" id="demo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-sign-in-alt"></i> Log-in Demo</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- Form demo -->
            <form action="" method="post">
              <center>
                <img class="mb-1" src="qurma/assets/img/logo-ummi.png" alt="" width="80" height="80">
                <h1 class="h3 mb-3 fw-normal">LMS Metode UMMI</h1>
              </center>
              <?php
              if (isset($message)) {
                foreach ($message as $msg) {
                  echo '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "' . addslashes($msg) . '",
                showConfirmButton: true,
                confirmButtonText: "OK"
            });
        });
        </script>
        ';
                }
              }
              ?>
              <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="email">
                <option selected>Masuk Sebagai</option>
                <option value="demo_koordinator">Koordinator</option>
                <option value="demo_guru">Guru</option>
              </select>
              <input type="hidden" class="form-control" name="password" value="">
              <button class="w-100 btn btn-lg btn-primary mb-2" type="submit" name="submit">Submit</button>
            </form>
            <!-- Akhir form demo -->
          </div>
        </div>
      </div>
    </div>
    <!-- Akhir modal demo -->

    <main>
      <div id="carouselExampleDark" class="carousel carousel-dark slide mt-5">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="10000">
            <img src="qurma/assets/img/Dashboard.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Halaman Dashboard</h5>
              <p>Memuat laporan perkembangan jilid.</p>
            </div>
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <img src="qurma/assets/img/Data Tes Jilid.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Halaman Tes Jilid</h5>
              <p>Mengelola tes jilid dan mencatatkan hasilnya.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="qurma/assets/img/Data Munaqosyah.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Halaman Munaqosyah</h5>
              <p>Mengelola data Munaqosyah, mencetak kartu Munaqosyah dan mengintegrasikan data ke SIM UF .</p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <div class="pricing-header p-3 pb-md-4 mx-auto text-center mt-5">
        <h1 class="display-4 fw-normal">Fitur Unggulan di LMS ini</h1>
      </div>

      <div class="card mb-3 col-12">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="qurma/assets/img/Dashboard.png" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">Dashboard Perkembangan Siswa</h5>
              <p class="card-text">Menampilkan perkembangan jilid dan juz hafalan siswa secara real time ketika Guru memasukkan laporan bulanan.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-3 col-12">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="qurma/assets/img/Data Tes Jilid.png" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">Pengelolaan Tes Jilid dan Tes Tahfizh</h5>
              <p class="card-text">Mengelola Tes Jilid individual maupun kelompok dengan pencatatan nilai dan hasil lulus atau belum lulus.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-3 col-12">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="qurma/assets/img/Data Munaqosyah.png" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">Pengelolaan Pra Munaqosyah dan Munaqosyah</h5>
              <p class="card-text">Mengelola data Pra Munaqosyah dan Munaqosyah, mencetak form Pra Munaqosyah, integrasi data Munaqosyah ke SIM UF, mencetak nomor dan kartu Munaqosyah.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-3 col-12">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="qurma/assets/img/Data Khotaman.png" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">Pengelolaan Khotaman</h5>
              <p class="card-text">Mengelola data Khotaman dan mendownload hasilnya dalam bentuk excel.</p>
            </div>
          </div>
        </div>
      </div>
    </main>

    <center>
      <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <img class="mb-2" src="qurma/assets/img/logo.png" alt="" height="30">
            <small class="d-block mb-3 text-muted">&copy; 2024</small>
          </div>
        </div>
      </footer>
    </center>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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