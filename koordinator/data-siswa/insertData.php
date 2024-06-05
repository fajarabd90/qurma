<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $kelas = htmlentities($_POST['kelas'], ENT_QUOTES);
    $jenis_kelamin = htmlentities($_POST['jenis_kelamin'], ENT_QUOTES);
    $no_hp = htmlentities($_POST['no_hp'], ENT_QUOTES);
    $alamat = htmlentities($_POST['alamat'], ENT_QUOTES);
    $tempat_lahir = htmlentities($_POST['tempat_lahir'], ENT_QUOTES);
    $tanggal_lahir = htmlentities($_POST['tanggal_lahir'], ENT_QUOTES);
    $kategori = htmlentities($_POST['kategori'], ENT_QUOTES);
    $no_peserta = htmlentities($_POST['no_peserta'], ENT_QUOTES);

    mysqli_query($conn, "INSERT INTO `siswa` (`lembaga`, `nama`, `kelas`, `jenis_kelamin`, `no_hp`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `kategori`, `no_peserta`) VALUES ('$lembaga', '$nama', '$kelas', '$guru', '$jenis_kelamin', '$no_hp', '$alamat', '$tempat_lahir', '$tanggal_lahir', '$kategori', '$no_peserta')");
} else {
    header('HTTP/1.1 404 Not found');
}
