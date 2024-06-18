<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $id_tes = htmlentities($_POST['id_tes'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $nomor = htmlentities($_POST['nomor'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE nomor SET id_tes='$id_tes', nama='$nama', nomor='$nomor' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
