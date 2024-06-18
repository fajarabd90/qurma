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
$lembaga = $user['lembaga'];
$guru = $user['nama'];

$paket = $conn_pdo->prepare("SELECT * FROM `paket` WHERE lembaga = '$lembaga'");
$paket->execute();
$paket = $paket->fetch(PDO::FETCH_ASSOC);
$pilih_paket = $paket['paket'];

date_default_timezone_set('Asia/Jakarta');

function tentukan_semester($bulan)
{
    if ($bulan >= 1 && $bulan <= 6) { // Januari sampai Juni
        return "Genap";
    } elseif ($bulan >= 7 && $bulan <= 12) { // Juli sampai Desember
        return "Ganjil";
    } else {
        return "Bulan tidak valid";
    }
}

$bulan_sekarang = intval(date('n')); // Ambil nomor bulan saat ini

// Mendapatkan tanggal saat ini
$tanggal = date("d");
// Mendapatkan nama bulan saat ini dalam bahasa Indonesia
$bulan = date("F");
// Menyesuaikan nama bulan dalam bahasa Indonesia
$bulan = str_replace(
    array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
    array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
    $bulan
);
// Mendapatkan tahun saat ini
$tahun = date("Y");

// Mendapatkan tanggal saat ini
$tanggal = date("d");
// Mendapatkan nomor bulan saat ini
$bulan2 = date("n"); // "n" memberikan angka bulan tanpa leading zero
// Mendapatkan tahun saat ini
$tahun = date("Y");

// Array nama bulan dalam bahasa Indonesia
$nama_bulan = array(
    1 => "Januari",
    2 => "Februari",
    3 => "Maret",
    4 => "April",
    5 => "Mei",
    6 => "Juni",
    7 => "Juli",
    8 => "Agustus",
    9 => "September",
    10 => "Oktober",
    11 => "November",
    12 => "Desember"
);

// Mendapatkan nama bulan dalam bahasa Indonesia
$nama_bulan_indonesia = $nama_bulan[$bulan2];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Guru</title>
    <link rel="shortcut icon" href="../assets/img/logo.png" />
    <link href="../dist/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .custom-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #3085d6;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #2565a8;
        }

        .custom-link-button {
            display: inline-block;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: red;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .custom-link-button:hover {
            background-color: darkred;
        }
    </style>
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
                        <?php

                        if ($pilih_paket == 'Standar') {
                            echo '<a class="sidebar-link" href="#" style="margin-top: -5px;" id="pro-link">
            <i class="align-middle" data-feather="trending-up"></i>
            <span class="align-middle">Laporan Bulanan</span>
            <sup style="font-size: smaller; vertical-align: super; background-color: red; color: white; padding: 2px 4px; border-radius: 3px;">Pro</sup>
          </a>';
                        } else {
                            echo '<a class="sidebar-link" href="laporan-bulanan/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="trending-up"></i> 
            <span class="align-middle">Laporan Bulanan</span>
          </a>';
                        }
                        ?>
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

                    <?php
                    $tesJilid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tes INNER JOIN siswa ON tes.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND tes.keterangan = '' AND tes.kategori = 'Tartil'"));
                    $tesTahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tes INNER JOIN siswa ON tes.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND tes.keterangan = '' AND tes.kategori = 'Tahfizh'"));
                    $tesBelumLulusJilid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tes INNER JOIN siswa ON tes.nama = siswa.nama INNER JOIN kelompok ON tes.nama = kelompok.nama WHERE siswa.lembaga = '$lembaga' AND tes.keterangan = 'Belum' AND tes.kategori = 'Tartil' AND kelompok.guru = '$guru'"));
                    $tesBelumLulusTahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tes INNER JOIN siswa ON tes.nama = siswa.nama INNER JOIN kelompok ON tes.nama = kelompok.nama WHERE siswa.lembaga = '$lembaga' AND tes.keterangan = 'Belum' AND tes.kategori = 'Tahfizh' AND kelompok.guru = '$guru'"));
                    ?>

                    <?php if ($tesJilid > 0) : ?>
                        <div class="alert alert-danger d-flex justify-content-between align-items-center p-2" role="alert">
                            <span class="me-auto">Ada <?= $tesJilid ?> siswa belum Tes Jilid!</span>
                            <a href="tes-jilid/index.php" class="btn btn-link p-0">Lihat</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($tesTahfizh > 0) : ?>
                        <div class="alert alert-danger d-flex justify-content-between align-items-center p-2" role="alert">
                            <span class="me-auto">Ada <?= $tesTahfizh ?> siswa belum Tes Tahfizh!</span>
                            <a href="tes-tahfizh/index.php" class="btn btn-link p-0">Lihat</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($tesBelumLulusJilid > 0) : ?>
                        <div class="alert alert-danger d-flex justify-content-between align-items-center p-2" role="alert">
                            <span class="me-auto">Ada <?= $tesBelumLulusJilid ?> siswa belum Lulus Tes Jilid!</span>
                            <a href="tes-jilid/index.php" class="btn btn-link p-0">Lihat</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($tesBelumLulusTahfizh > 0) : ?>
                        <div class="alert alert-danger d-flex justify-content-between align-items-center p-2" role="alert">
                            <span class="me-auto">Ada <?= $tesBelumLulusTahfizh ?> siswa belum Lulus Tes Tahfizh!</span>
                            <a href="tes-tahfizh/index.php" class="btn btn-link p-0">Lihat</a>
                        </div>
                    <?php endif; ?>

                    <?php

                    if ($pilih_paket == 'Standar') {
                        echo '<div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Data Laporan</h5>
                                </div>

                                <div class="card-body" style="margin-top: -10px; margin-bottom: 10px;">
                                    Data Laporan Perkembangan Tahsin dan Tahfizh tersedia dalam <a href="../harga.php" target="_blank" class="custom-link-button">
                                        versi Pro
                                    </a>.
                                </div>
                            </div>
                        </div>
                    </div>';
                    } else {
                        echo '<div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Data Laporan</h5>
                                </div>

                                <div class="card-body" style="margin-top: -10px; margin-bottom: 10px;">

                                    <select class="form-select mb-3" aria-label="Default select example" id="bulan-pilih">
                                        <option value="' .  $nama_bulan_indonesia . '">' . $nama_bulan_indonesia . '</option>
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>

                                    <div class="overflow-scroll">
                                        <p>Guru Yang Sudah Input Laporan Bulanan</p>

                                        <div id="data-guru"></div>

                                        <p>Perkembangan Jilid Setiap Kelas</p>

                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Kelas</th>
                                                    <th scope="col">Total Siswa</th>
                                                    <th scope="col">Tuntas</th>
                                                    <th scope="col">Belum Tuntas</th>
                                                    <th scope="col">Jilid 1</th>
                                                    <th scope="col">Jilid 2</th>
                                                    <th scope="col">Jilid 3</th>
                                                    <th scope="col">Jilid 4</th>
                                                    <th scope="col">Jilid 5</th>
                                                    <th scope="col">Jilid 6</th>
                                                    <th scope="col">Al Quran</th>
                                                    <th scope="col">Ghorib</th>
                                                    <th scope="col">Tajwid</th>
                                                    <th scope="col">Tahfizh</th>
                                                    <th scope="col">Turjuman</th>
                                                    <th scope="col">KBQ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-jilid">

                                            </tbody>
                                        </table>

                                        <p>Perkembangan Juz Setiap Kelas</p>

                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Kelas</th>
                                                    <th scope="col">Total Siswa</th>
                                                    <th scope="col">Tuntas</th>
                                                    <th scope="col">Belum Tuntas</th>
                                                    <th scope="col">Juz 30</th>
                                                    <th scope="col">Juz 29</th>
                                                    <th scope="col">Juz 28</th>
                                                    <th scope="col">Juz 1</th>
                                                    <th scope="col">Juz 2</th>
                                                    <th scope="col">Juz 3</th>
                                                    <th scope="col">Juz Lainnya</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-juz">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                    ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var proLink = document.getElementById('pro-link');
            if (proLink) {
                proLink.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default link action
                    Swal.fire({
                        icon: 'warning',
                        title: 'Paket Pro Diperlukan',
                        html: 'Anda harus berlangganan paket pro.<br><br><a href="../harga.php" target="_blank" class="custom-button">Langganan Sekarang</a>',
                        showConfirmButton: false,
                    });
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var bulanPilih = document.getElementById('bulan-pilih');

            // Trigger change event to load data for the selected month
            bulanPilih.dispatchEvent(new Event('change'));
        });

        document.getElementById('bulan-pilih').addEventListener('change', function() {
            var selectedMonth = this.value;

            // Function to send AJAX request for getLaporanGuru.php
            function fetchLaporanGuru() {
                var xhrLaporanGuru = new XMLHttpRequest();
                xhrLaporanGuru.open('POST', 'getLaporanGuru.php', true);
                xhrLaporanGuru.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhrLaporanGuru.onreadystatechange = function() {
                    if (xhrLaporanGuru.readyState == 4 && xhrLaporanGuru.status == 200) {
                        document.getElementById('data-guru').innerHTML = xhrLaporanGuru.responseText;
                    }
                };
                xhrLaporanGuru.send('bulan=' + selectedMonth);
            }

            // Function to send AJAX request for getDataJilid.php
            function fetchDataJilid() {
                var xhrDataJilid = new XMLHttpRequest();
                xhrDataJilid.open('POST', 'getDataJilid.php', true);
                xhrDataJilid.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhrDataJilid.onreadystatechange = function() {
                    if (xhrDataJilid.readyState == 4 && xhrDataJilid.status == 200) {
                        document.getElementById('data-jilid').innerHTML = xhrDataJilid.responseText;
                    }
                };
                xhrDataJilid.send('bulan=' + selectedMonth);
            }

            // Function to send AJAX request for getDataJuz.php

            function fetchDataJuz() {
                var xhrDataJuz = new XMLHttpRequest();
                xhrDataJuz.open('POST', 'getDataJuz.php', true);
                xhrDataJuz.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhrDataJuz.onreadystatechange = function() {
                    if (xhrDataJuz.readyState == 4 && xhrDataJuz.status == 200) {
                        document.getElementById('data-juz').innerHTML = xhrDataJuz.responseText;
                    }
                };
                xhrDataJuz.send('bulan=' + selectedMonth);
            }

            // Call both functions
            fetchLaporanGuru();
            fetchDataJilid();
            fetchDataJuz();
        });
    </script>

</body>

</html>