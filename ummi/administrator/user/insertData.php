<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlentities($_POST['email'], ENT_QUOTES);
    $password = htmlentities($_POST['password'], ENT_QUOTES);
    $role = htmlentities($_POST['role'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);

    mysqli_query($conn, "INSERT INTO `user` (`email`, `password`, `role`, `nama`,`lembaga`) VALUES('$email', '$password', '$role', '$nama', '$lembaga');");
} else {
    header('HTTP/1.1 404 Not found');
}
