<?php

require '../config.php';
session_start();
$id = $_SESSION['guru'];

if (!isset($id)) {
    header('location:../index.php');
}

$user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Guru | QurMa</title>
    <link rel="shortcut icon" href="../assets/img/logo.png" />
    <link href="../dist/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php">
                    <span class="align-middle">QurMa (<?= $user['lembaga']; ?>)</span>
                </a>

                <ul class="sidebar-nav">

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="index.php" style="margin-top: -10px;">
                            <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
                        </a>

                    </li>

                    <li class="sidebar-header" style="margin-top: -20px;">
                        Administrasi & Laporan
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="placement-test/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">Placement Test</span>
                        </a>
                        <a class="sidebar-link" href="data-kelompok/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Data Kelompok</span>
                        </a>
                        <a class="sidebar-link" href="laporan-bulanan/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="trending-up"></i> <span class="align-middle">Laporan Bulanan</span>
                        </a>
                    </li>

                    <li class="sidebar-header" style="margin-top: -20px;">
                        Tes Kenaikan Tingkat
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="tes-jilid/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Tes Jilid</span>
                        </a>
                        <a class="sidebar-link" href="tes-tahfizh/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="heart"></i> <span class="align-middle">Tes Tahfizh</span>
                        </a>
                    </li>
                    <li class="sidebar-header" style="margin-top: -20px;">
                        Tahapan Munaqosyah
                    </li>
                    <li class="sidebar-item mb-4">
                        <a class="sidebar-link" href="pra-munaqosyah/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="bookmark"></i> <span class="align-middle">Pra Munaqosyah</span>
                        </a>
                        <a class="sidebar-link" href="munaqosyah/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="award"></i> <span class="align-middle">Munaqosyah</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">0</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    0 Notifications
                                </div>
                                <div class="list-group">

                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <span class="text-dark"><?= $user['nama']; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="../logout.php">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Dashboard</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Coming Soon</h5>
                                </div>
                                <div class="card-body py-3">
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://qurma.site/" target="_blank">&copy; <strong>QurMa</strong> - 2024</a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-0">
                                <a class="text-muted" href="#">v1.0</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="../dist/js/app.js"></script>

</body>

</html>