<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $kelas = htmlentities($_POST['kelas'], ENT_QUOTES);
    $jenis_kelamin = htmlentities($_POST['jenis_kelamin'], ENT_QUOTES);
    $no_hp = htmlentities($_POST['no_hp'], ENT_QUOTES);
    $alamat = htmlentities($_POST['alamat'], ENT_QUOTES);
    $tempat_lahir = htmlentities($_POST['tempat_lahir'], ENT_QUOTES);
    $tgl_lahir = htmlentities($_POST['tgl_lahir'], ENT_QUOTES);
    $ayah = htmlentities($_POST['ayah'], ENT_QUOTES);
    $ibu = htmlentities($_POST['ibu'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE `siswa` SET lembaga='$lembaga', nama='$nama', kelas='$kelas', jenis_kelamin='$jenis_kelamin', no_hp='$no_hp', alamat='$alamat', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir', ayah='$ayah', ibu='$ibu' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
