<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);

    mysqli_query($conn, "INSERT INTO `guru` (`lembaga`, `nama`) VALUES ('$lembaga', '$nama')");
} else {
    header('HTTP/1.1 404 Not found');
}
