<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $tahun_ajaran = htmlentities($_POST['tahun_ajaran'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE tahun_ajaran SET tahun_ajaran='$tahun_ajaran' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
