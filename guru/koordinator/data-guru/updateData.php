<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE `guru` SET lembaga='$lembaga', nama='$nama' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
