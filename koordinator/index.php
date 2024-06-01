<?php

require '../config.php';
session_start();
$id = $_SESSION['koordinator'];

if (!isset($id)) {
    header('location:../index.php');
}

$user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
$lembaga = $user['lembaga'];

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Koordinator</title>
    <link rel="shortcut icon" href="../assets/img/logo.png" />
    <link href="../dist/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php">
                    <span class="align-middle">QurMa (<?= $lembaga ?>)</span>
                </a>

                <ul class="sidebar-nav">

                    <li class="sidebar-item" style="margin-top: -10px;">
                        <a class="sidebar-link" href="index.php">
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
                        <a class="sidebar-link" href="administrasi-harian/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="edit"></i> <span class="align-middle">Administrasi Harian</span>
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
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="pra-munaqosyah/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="bookmark"></i> <span class="align-middle">Pra Munaqosyah</span>
                        </a>
                        <a class="sidebar-link" href="munaqosyah/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="award"></i> <span class="align-middle">Munaqosyah</span>
                        </a>
                    </li>
                    <li class="sidebar-header" style="margin-top: -20px;">
                        Khotaman
                    </li>
                    <li class="sidebar-item mb-4">
                        <a class="sidebar-link" href="khotaman/index.php" style="margin-top: -5px;">
                            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Data Peserta</span>
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
                    $tesJilid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tes INNER JOIN siswa ON tes.nama = siswa.nama WHERE lembaga = '$lembaga' AND keterangan = '' AND kategori = 'Tartil'"));
                    $tesTahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tes INNER JOIN siswa ON tes.nama = siswa.nama WHERE lembaga = '$lembaga' AND keterangan = '' AND kategori = 'Tahfizh'"));
                    ?>

                    <div class="alert alert-danger d-flex justify-content-between align-items-center p-2" role="alert">
                        <span class="me-auto">Ada <?= $tesJilid ?> siswa belum Tes Jilid!</span>
                        <a href="tes-jilid/index.php" class="btn btn-link p-0">Lihat</a>
                    </div>

                    <div class="alert alert-danger d-flex justify-content-between align-items-center p-2" role="alert">
                        <span class="me-auto">Ada <?= $tesTahfizh ?> siswa belum Tes Tahfizh!</span>
                        <a href="tes-tahfizh/index.php" class="btn btn-link p-0">Lihat</a>
                    </div>

                    <?php
                    //Total siswa
                    $kelas1_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '1%'"));
                    $kelas2_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '2%'"));
                    $kelas3_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '3%'"));
                    $kelas4_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '4%'"));
                    $kelas5_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '5%'"));
                    $kelas6_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '6%'"));

                    //Total tuntas
                    $kelas1_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND ketuntasan_tartil = 'Tuntas'"));
                    $kelas2_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND ketuntasan_tartil = 'Tuntas'"));
                    $kelas3_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND ketuntasan_tartil = 'Tuntas'"));
                    $kelas4_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND ketuntasan_tartil = 'Tuntas'"));
                    $kelas5_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND ketuntasan_tartil = 'Tuntas'"));
                    $kelas6_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND ketuntasan_tartil = 'Tuntas'"));

                    //Total tuntas
                    $kelas1_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND ketuntasan_tartil = 'Belum Tuntas'"));
                    $kelas2_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND ketuntasan_tartil = 'Belum Tuntas'"));
                    $kelas3_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND ketuntasan_tartil = 'Belum Tuntas'"));
                    $kelas4_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND ketuntasan_tartil = 'Belum Tuntas'"));
                    $kelas5_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND ketuntasan_tartil = 'Belum Tuntas'"));
                    $kelas6_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND ketuntasan_tartil = 'Belum Tuntas'"));

                    //Total jilid 1
                    $kelas1_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = '1'"));
                    $kelas2_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = '1'"));
                    $kelas3_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = '1'"));
                    $kelas4_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = '1'"));
                    $kelas5_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = '1'"));
                    $kelas6_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = '1'"));

                    //Total jilid 2
                    $kelas1_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = '2'"));
                    $kelas2_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = '2'"));
                    $kelas3_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = '2'"));
                    $kelas4_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = '2'"));
                    $kelas5_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = '2'"));
                    $kelas6_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = '2'"));

                    //Total jilid 3
                    $kelas1_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = '3'"));
                    $kelas2_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = '3'"));
                    $kelas3_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = '3'"));
                    $kelas4_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = '3'"));
                    $kelas5_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = '3'"));
                    $kelas6_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = '3'"));

                    //Total jilid 4
                    $kelas1_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = '4'"));
                    $kelas2_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = '4'"));
                    $kelas3_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = '4'"));
                    $kelas4_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = '4'"));
                    $kelas5_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = '4'"));
                    $kelas6_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = '4'"));

                    //Total jilid 5
                    $kelas1_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = '5'"));
                    $kelas2_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = '5'"));
                    $kelas3_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = '5'"));
                    $kelas4_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = '5'"));
                    $kelas5_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = '5'"));
                    $kelas6_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = '5'"));

                    //Total jilid 6
                    $kelas1_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = '6'"));
                    $kelas2_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = '6'"));
                    $kelas3_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = '6'"));
                    $kelas4_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = '6'"));
                    $kelas5_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = '6'"));
                    $kelas6_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = '6'"));

                    //Total Al Quran
                    $kelas1_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = 'Al Quran'"));
                    $kelas2_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = 'Al Quran'"));
                    $kelas3_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = 'Al Quran'"));
                    $kelas4_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = 'Al Quran'"));
                    $kelas5_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = 'Al Quran'"));
                    $kelas6_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = 'Al Quran'"));

                    //Total Ghorib
                    $kelas1_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = 'Ghorib'"));
                    $kelas2_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = 'Ghorib'"));
                    $kelas3_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = 'Ghorib'"));
                    $kelas4_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = 'Ghorib'"));
                    $kelas5_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = 'Ghorib'"));
                    $kelas6_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = 'Ghorib'"));

                    //Total Tajwid
                    $kelas1_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = 'Tajwid'"));
                    $kelas2_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = 'Tajwid'"));
                    $kelas3_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = 'Tajwid'"));
                    $kelas4_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = 'Tajwid'"));
                    $kelas5_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = 'Tajwid'"));
                    $kelas6_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = 'Tajwid'"));

                    //Total Tahfizh
                    $kelas1_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = 'Tahfizh'"));
                    $kelas2_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = 'Tahfizh'"));
                    $kelas3_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = 'Tahfizh'"));
                    $kelas4_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = 'Tahfizh'"));
                    $kelas5_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = 'Tahfizh'"));
                    $kelas6_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = 'Tahfizh'"));

                    //Total Turjuman
                    $kelas1_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = 'Turjuman'"));
                    $kelas2_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = 'Turjuman'"));
                    $kelas3_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = 'Turjuman'"));
                    $kelas4_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = 'Turjuman'"));
                    $kelas5_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = 'Turjuman'"));
                    $kelas6_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = 'Turjuman'"));

                    //Total KBQ
                    $kelas1_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND jilid = 'KBQ'"));
                    $kelas2_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND jilid = 'KBQ'"));
                    $kelas3_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND jilid = 'KBQ'"));
                    $kelas4_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND jilid = 'KBQ'"));
                    $kelas5_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND jilid = 'KBQ'"));
                    $kelas6_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND jilid = 'KBQ'"));
                    ?>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Data Laporan</h5>
                                </div>

                                <div class="card-body" style="margin-top: -10px; margin-bottom: 10px;">
                                    <div class="overflow-scroll">
                                        <select class="form-select mb-2" aria-label="Default select example" id='bulan-pilih'>
                                            <option value="">Pilih Bulan</option>
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
                                        <p>Guru Yang Sudah Input Laporan Bulanan</p>
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">Nama</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $sql = mysqli_query($conn, "SELECT DISTINCT kelompok.guru
                                            FROM kelompok
                                            INNER JOIN laporan ON kelompok.nama = laporan.nama
                                            WHERE laporan.bulan = '$bulan'");
                                                while ($data = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $no++; ?></th>
                                                        <td><?php echo $data['guru']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

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
                                            <tbody>
                                                <?php
                                                for ($i = 1; $i <= 6; $i++) {
                                                    // Dynamically creating variable names
                                                    $kelas_siswa = ${"kelas" . $i . "_siswa"};
                                                    $kelas_tuntas = ${"kelas" . $i . "_tuntas"};
                                                    $kelas_belum = ${"kelas" . $i . "_belum"};
                                                    $kelas_1 = ${"kelas" . $i . "_1"};
                                                    $kelas_2 = ${"kelas" . $i . "_2"};
                                                    $kelas_3 = ${"kelas" . $i . "_3"};
                                                    $kelas_4 = ${"kelas" . $i . "_4"};
                                                    $kelas_5 = ${"kelas" . $i . "_5"};
                                                    $kelas_6 = ${"kelas" . $i . "_6"};
                                                    $kelas_alquran = ${"kelas" . $i . "_alquran"};
                                                    $kelas_ghorib = ${"kelas" . $i . "_ghorib"};
                                                    $kelas_tajwid = ${"kelas" . $i . "_tajwid"};
                                                    $kelas_tahfizh = ${"kelas" . $i . "_tahfizh"};
                                                    $kelas_turjuman = ${"kelas" . $i . "_turjuman"};
                                                    $kelas_kbq = ${"kelas" . $i . "_kbq"};
                                                ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $kelas_siswa ?: '' ?></td>
                                                        <td><?= $kelas_tuntas ?: '' ?></td>
                                                        <td><?= $kelas_belum ?: '' ?></td>
                                                        <td><?= $kelas_1 ?: '' ?></td>
                                                        <td><?= $kelas_2 ?: '' ?></td>
                                                        <td><?= $kelas_3 ?: '' ?></td>
                                                        <td><?= $kelas_4 ?: '' ?></td>
                                                        <td><?= $kelas_5 ?: '' ?></td>
                                                        <td><?= $kelas_6 ?: '' ?></td>
                                                        <td><?= $kelas_alquran ?: '' ?></td>
                                                        <td><?= $kelas_ghorib ?: '' ?></td>
                                                        <td><?= $kelas_tajwid ?: '' ?></td>
                                                        <td><?= $kelas_tahfizh ?: '' ?></td>
                                                        <td><?= $kelas_turjuman ?: '' ?></td>
                                                        <td><?= $kelas_kbq ?: '' ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row" style="margin-top: -10px;">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Laporan Perkembangan Kelas</h5>
                                </div>

                                <div class="card-body">
                                    <div class="overflow-scroll">


                                    </div>
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