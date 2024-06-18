<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $id_tes = $_POST['id_tes'];
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $kategori = htmlentities($_POST['nama'], ENT_QUOTES);
    $keterangan_mun = htmlentities($_POST['keterangan_mun'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE lulus SET id_tes='$id_tes', nama='$nama', kategori='$kategori', keterangan_mun='$keterangan_mun' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
