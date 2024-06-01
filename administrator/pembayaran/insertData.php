<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $tgl_bayar = htmlentities($_POST['tgl_bayar'], ENT_QUOTES);
    $metode_bayar = htmlentities($_POST['metode_bayar'], ENT_QUOTES);
    $jumlah = htmlentities($_POST['jumlah'], ENT_QUOTES);

    mysqli_query($conn, "INSERT INTO `pembayaran` (`lembaga`, `tgl_bayar`, `metode_bayar`, `jumlah`) VALUES('$lembaga', '$tgl_bayar', '$metode_bayar', '$jumlah');");
} else {
    header('HTTP/1.1 404 Not found');
}
