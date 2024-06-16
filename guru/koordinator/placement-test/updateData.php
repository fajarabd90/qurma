<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $jilid = htmlentities($_POST['jilid'], ENT_QUOTES);
    $halaman = htmlentities($_POST['halaman'], ENT_QUOTES);
    $catatan = htmlentities($_POST['catatan'], ENT_QUOTES);
    $guru = htmlentities($_POST['guru'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE placement SET nama='$nama', jilid='$jilid', halaman='$halaman', catatan='$catatan', guru='$guru' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
