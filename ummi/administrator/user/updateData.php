<?php
require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $email = htmlentities($_POST['email'], ENT_QUOTES);
    $password = htmlentities($_POST['password'], ENT_QUOTES);
    $role = htmlentities($_POST['role'], ENT_QUOTES);
    $nama = htmlentities($_POST['nama'], ENT_QUOTES);
    $lembaga = htmlentities($_POST['lembaga'], ENT_QUOTES);

    mysqli_query($conn, "UPDATE user SET email='$email', password='$password', role='$role', nama='$nama', lembaga='$lembaga' WHERE id = $id");
} else {
    header('HTTP/1.1 404 Not found');
}
