<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $jilid = htmlentities($_POST['jilid'], ENT_QUOTES);
    $juz = htmlentities($_POST['juz'], ENT_QUOTES);
    $surat = htmlentities($_POST['surat'], ENT_QUOTES);
    $nilai1 = htmlentities($_POST['nilai1'], ENT_QUOTES);
    $nilai2 = htmlentities($_POST['nilai2'], ENT_QUOTES);
    $nilai3 = htmlentities($_POST['nilai3'], ENT_QUOTES);
    $catatan = htmlentities($_POST['catatan'], ENT_QUOTES);
    $keterangan = htmlentities($_POST['keterangan'], ENT_QUOTES);
    $kategori = htmlentities($_POST['kategori'], ENT_QUOTES);
    $guru = htmlentities($_POST['guru'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE tes SET nama='$nama', jilid='$jilid', juz='$juz', surat='$surat', nilai1='$nilai1', nilai2='$nilai2', nilai3='$nilai3', catatan='$catatan', keterangan='$keterangan', kategori='$kategori', guru='$guru' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
