<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $guru = htmlentities($_POST['guru'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE kelompok SET nama='$nama', guru='$guru' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
