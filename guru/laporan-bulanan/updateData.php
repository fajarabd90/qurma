<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $bulan = htmlentities($_POST['bulan'], ENT_QUOTES);
    $jilid = htmlentities($_POST['jilid'], ENT_QUOTES);
    $halaman = htmlentities($_POST['halaman'], ENT_QUOTES);
    $ketuntasan_tartil = htmlentities($_POST['ketuntasan_tartil'], ENT_QUOTES);
    $juz = htmlentities($_POST['juz'], ENT_QUOTES);
    $surat = htmlentities($_POST['surat'], ENT_QUOTES);
    $ketuntasan_tahfizh = htmlentities($_POST['ketuntasan_tahfizh'], ENT_QUOTES);
    $catatan = htmlentities($_POST['catatan'], ENT_QUOTES);
    $guru = htmlentities($_POST['guru'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE laporan SET nama='$nama', bulan='$bulan', jilid='$jilid', halaman='$halaman', ketuntasan_tartil='$ketuntasan_tartil', juz='$juz', surat='$surat', ketuntasan_tahfizh='$ketuntasan_tahfizh', catatan='$catatan', guru='$guru' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
