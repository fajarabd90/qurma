<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tahun_ajaran = htmlentities($_POST['tahun_ajaran'], ENT_QUOTES);

    mysqli_query($conn, "INSERT INTO `tahun_ajaran` (`tahun_ajaran`) VALUES('$tahun_ajaran');");
} else {
    header('HTTP/1.1 404 Not found');
}
