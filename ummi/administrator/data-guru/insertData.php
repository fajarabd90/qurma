<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $status = htmlentities($_POST['status'], ENT_QUOTES);
    $sertifikasi = htmlentities($_POST['sertifikasi'], ENT_QUOTES);

    mysqli_query($conn, "INSERT INTO `guru` (`lembaga`, `nama`, `status`, `sertifikasi`) VALUES ('$lembaga', '$nama', '$status', '$sertifikasi')");
} else {
    header('HTTP/1.1 404 Not found');
}
