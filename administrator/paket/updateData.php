<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);
    $paket = htmlentities($_POST['paket'], ENT_QUOTES);
    $status = htmlentities($_POST['status'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE paket SET lembaga='$lembaga', paket='$paket', status='$status' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
