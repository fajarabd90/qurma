<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $status = htmlentities($_POST['status'], ENT_QUOTES);
    $sertifikasi = htmlentities($_POST['sertifikasi'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE `guru` SET lembaga='$lembaga', nama='$nama', status='$status', sertifikasi='$sertifikasi' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
