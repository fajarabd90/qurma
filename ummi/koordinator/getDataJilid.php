<?php
if (isset($_POST['bulan'])) {
    $bulan = $_POST['bulan'];

    // Include your database connection file
    include('../config.php');
    session_start();
    $id = $_SESSION['koordinator'];

    if (!isset($id)) {
        header('location:../index.php');
    }

    $user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
    $user->execute([$id]);
    $user = $user->fetch(PDO::FETCH_ASSOC);
    $lembaga = $user['lembaga'];

    //Total siswa
    $kelas1_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '1%'"));
    $kelas2_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '2%'"));
    $kelas3_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '3%'"));
    $kelas4_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '4%'"));
    $kelas5_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '5%'"));
    $kelas6_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '6%'"));

    //Total tuntas
    $kelas1_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.ketuntasan_tartil = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas2_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.ketuntasan_tartil = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas3_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.ketuntasan_tartil = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas4_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.ketuntasan_tartil = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas5_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.ketuntasan_tartil = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas6_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.ketuntasan_tartil = 'Tuntas' AND laporan.bulan = '$bulan'"));

    // Menghitung persentase siswa yang tuntas di setiap kelas
    $persentase_tuntas_kelas1 = ($kelas1_siswa != 0) ? round($kelas1_tuntas / $kelas1_siswa * 100) : 0;
    $persentase_tuntas_kelas2 = ($kelas2_siswa != 0) ? round($kelas2_tuntas / $kelas2_siswa * 100) : 0;
    $persentase_tuntas_kelas3 = ($kelas3_siswa != 0) ? round($kelas3_tuntas / $kelas3_siswa * 100) : 0;
    $persentase_tuntas_kelas4 = ($kelas4_siswa != 0) ? round($kelas4_tuntas / $kelas4_siswa * 100) : 0;
    $persentase_tuntas_kelas5 = ($kelas5_siswa != 0) ? round($kelas5_tuntas / $kelas5_siswa * 100) : 0;
    $persentase_tuntas_kelas6 = ($kelas6_siswa != 0) ? round($kelas6_tuntas / $kelas6_siswa * 100) : 0;

    //Total belum tuntas
    $kelas1_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.ketuntasan_tartil = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas2_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.ketuntasan_tartil = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas3_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.ketuntasan_tartil = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas4_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.ketuntasan_tartil = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas5_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.ketuntasan_tartil = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas6_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.ketuntasan_tartil = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));

    // Menghitung persentase siswa yang belum tuntas di setiap kelas
    $persentase_belum_kelas1 = ($kelas1_siswa != 0) ? round($kelas1_belum / $kelas1_siswa * 100) : 0;
    $persentase_belum_kelas2 = ($kelas2_siswa != 0) ? round($kelas2_belum / $kelas2_siswa * 100) : 0;
    $persentase_belum_kelas3 = ($kelas3_siswa != 0) ? round($kelas3_belum / $kelas3_siswa * 100) : 0;
    $persentase_belum_kelas4 = ($kelas4_siswa != 0) ? round($kelas4_belum / $kelas4_siswa * 100) : 0;
    $persentase_belum_kelas5 = ($kelas5_siswa != 0) ? round($kelas5_belum / $kelas5_siswa * 100) : 0;
    $persentase_belum_kelas6 = ($kelas6_siswa != 0) ? round($kelas6_belum / $kelas6_siswa * 100) : 0;

    //Total laporan.jilid 1
    $kelas1_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = '1' AND laporan.bulan = '$bulan'"));
    $kelas2_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = '1' AND laporan.bulan = '$bulan'"));
    $kelas3_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = '1' AND laporan.bulan = '$bulan'"));
    $kelas4_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = '1' AND laporan.bulan = '$bulan'"));
    $kelas5_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = '1' AND laporan.bulan = '$bulan'"));
    $kelas6_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = '1' AND laporan.bulan = '$bulan'"));

    //Total laporan.jilid 2
    $kelas1_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = '2' AND laporan.bulan = '$bulan'"));
    $kelas2_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = '2' AND laporan.bulan = '$bulan'"));
    $kelas3_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = '2' AND laporan.bulan = '$bulan'"));
    $kelas4_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = '2' AND laporan.bulan = '$bulan'"));
    $kelas5_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = '2' AND laporan.bulan = '$bulan'"));
    $kelas6_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = '2' AND laporan.bulan = '$bulan'"));

    //Total laporan.jilid 3
    $kelas1_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = '3' AND laporan.bulan = '$bulan'"));
    $kelas2_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = '3' AND laporan.bulan = '$bulan'"));
    $kelas3_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = '3' AND laporan.bulan = '$bulan'"));
    $kelas4_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = '3' AND laporan.bulan = '$bulan'"));
    $kelas5_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = '3' AND laporan.bulan = '$bulan'"));
    $kelas6_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = '3' AND laporan.bulan = '$bulan'"));

    //Total laporan.jilid 4
    $kelas1_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = '4' AND laporan.bulan = '$bulan'"));
    $kelas2_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = '4' AND laporan.bulan = '$bulan'"));
    $kelas3_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = '4' AND laporan.bulan = '$bulan'"));
    $kelas4_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = '4' AND laporan.bulan = '$bulan'"));
    $kelas5_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = '4' AND laporan.bulan = '$bulan'"));
    $kelas6_4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = '4' AND laporan.bulan = '$bulan'"));

    //Total laporan.jilid 5
    $kelas1_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = '5' AND laporan.bulan = '$bulan'"));
    $kelas2_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = '5' AND laporan.bulan = '$bulan'"));
    $kelas3_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = '5' AND laporan.bulan = '$bulan'"));
    $kelas4_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = '5' AND laporan.bulan = '$bulan'"));
    $kelas5_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = '5' AND laporan.bulan = '$bulan'"));
    $kelas6_5 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = '5' AND laporan.bulan = '$bulan'"));

    //Total laporan.jilid 6
    $kelas1_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = '6' AND laporan.bulan = '$bulan'"));
    $kelas2_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = '6' AND laporan.bulan = '$bulan'"));
    $kelas3_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = '6' AND laporan.bulan = '$bulan'"));
    $kelas4_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = '6' AND laporan.bulan = '$bulan'"));
    $kelas5_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = '6' AND laporan.bulan = '$bulan'"));
    $kelas6_6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = '6' AND laporan.bulan = '$bulan'"));

    //Total Al Quran
    $kelas1_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = 'Al Quran' AND laporan.bulan = '$bulan'"));
    $kelas2_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = 'Al Quran' AND laporan.bulan = '$bulan'"));
    $kelas3_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = 'Al Quran' AND laporan.bulan = '$bulan'"));
    $kelas4_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = 'Al Quran' AND laporan.bulan = '$bulan'"));
    $kelas5_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = 'Al Quran' AND laporan.bulan = '$bulan'"));
    $kelas6_alquran = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = 'Al Quran' AND laporan.bulan = '$bulan'"));

    //Total Ghorib
    $kelas1_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = 'Ghorib' AND laporan.bulan = '$bulan'"));
    $kelas2_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = 'Ghorib' AND laporan.bulan = '$bulan'"));
    $kelas3_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = 'Ghorib' AND laporan.bulan = '$bulan'"));
    $kelas4_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = 'Ghorib' AND laporan.bulan = '$bulan'"));
    $kelas5_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = 'Ghorib' AND laporan.bulan = '$bulan'"));
    $kelas6_ghorib = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = 'Ghorib' AND laporan.bulan = '$bulan'"));

    //Total Tajwid
    $kelas1_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = 'Tajwid' AND laporan.bulan = '$bulan'"));
    $kelas2_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = 'Tajwid' AND laporan.bulan = '$bulan'"));
    $kelas3_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = 'Tajwid' AND laporan.bulan = '$bulan'"));
    $kelas4_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = 'Tajwid' AND laporan.bulan = '$bulan'"));
    $kelas5_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = 'Tajwid' AND laporan.bulan = '$bulan'"));
    $kelas6_tajwid = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = 'Tajwid' AND laporan.bulan = '$bulan'"));

    //Total Tahfizh
    $kelas1_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = 'Tahfizh' AND laporan.bulan = '$bulan'"));
    $kelas2_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = 'Tahfizh' AND laporan.bulan = '$bulan'"));
    $kelas3_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = 'Tahfizh' AND laporan.bulan = '$bulan'"));
    $kelas4_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = 'Tahfizh' AND laporan.bulan = '$bulan'"));
    $kelas5_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = 'Tahfizh' AND laporan.bulan = '$bulan'"));
    $kelas6_tahfizh = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = 'Tahfizh' AND laporan.bulan = '$bulan'"));

    //Total Turjuman
    $kelas1_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = 'Turjuman' AND laporan.bulan = '$bulan'"));
    $kelas2_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = 'Turjuman' AND laporan.bulan = '$bulan'"));
    $kelas3_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = 'Turjuman' AND laporan.bulan = '$bulan'"));
    $kelas4_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = 'Turjuman' AND laporan.bulan = '$bulan'"));
    $kelas5_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = 'Turjuman' AND laporan.bulan = '$bulan'"));
    $kelas6_turjuman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = 'Turjuman' AND laporan.bulan = '$bulan'"));

    //Total KBQ
    $kelas1_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '1%' AND laporan.jilid = 'KBQ' AND laporan.bulan = '$bulan'"));
    $kelas2_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '2%' AND laporan.jilid = 'KBQ' AND laporan.bulan = '$bulan'"));
    $kelas3_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '3%' AND laporan.jilid = 'KBQ' AND laporan.bulan = '$bulan'"));
    $kelas4_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '4%' AND laporan.jilid = 'KBQ' AND laporan.bulan = '$bulan'"));
    $kelas5_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '5%' AND laporan.jilid = 'KBQ' AND laporan.bulan = '$bulan'"));
    $kelas6_kbq = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '6%' AND laporan.jilid = 'KBQ' AND laporan.bulan = '$bulan'"));

    // Check if the query was successful
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
        $persentase_tuntas = ${"persentase_tuntas_kelas" . $i};
        $persentase_belum = ${"persentase_belum_kelas" . $i};
?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $kelas_siswa ?: '' ?></td>
            <td>
                <?= $kelas_tuntas ?: '' ?>
                <?php if ($persentase_tuntas !== '' && $persentase_tuntas != '0') : ?>
                    <span style="color: <?= $persentase_tuntas < 50 ? 'red' : 'green'; ?>;">
                        (<?= $persentase_tuntas ?>%)
                    </span>
                <?php endif; ?>
            </td>
            <td>
                <?= $kelas_belum ?: '' ?>
                <?php if ($persentase_belum !== '' && $persentase_belum != '0') : ?>
                    <span style="color: red;">
                        (<?= $persentase_belum ?>%)
                    </span>
                <?php endif; ?>
            </td>
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
<?php
    }
} else {
    // Handle query error
    echo "<tr><td colspan='16'>Error fetching data: " . mysqli_error($conn) . "</td></tr>";
}
?>