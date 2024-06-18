<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $id_tes = $_POST['id_tes'];
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $kelas = htmlentities($_POST['kelas'], ENT_QUOTES);
    $kategori = htmlentities($_POST['kategori'], ENT_QUOTES);
    $catatan = htmlentities($_POST['catatan'], ENT_QUOTES);
    $keterangan_pra = htmlentities($_POST['keterangan_pra'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE pra_munaqosyah SET id_tes='$id_tes', lembaga='$lembaga', nama='$nama', kelas='$kelas', kategori='$kategori', catatan='$catatan', keterangan_pra='$keterangan_pra' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
