<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $paket = htmlentities($_POST['paket'], ENT_QUOTES);
    $status = htmlentities($_POST['status'], ENT_QUOTES);

    mysqli_query($conn, "INSERT INTO `paket` (`lembaga`, `paket`, `status`) VALUES('$lembaga', '$paket', '$status');");
} else {
    header('HTTP/1.1 404 Not found');
}
