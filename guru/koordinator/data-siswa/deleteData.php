<?php
require '../../config.php';
$queryDelete = "DELETE FROM siswa WHERE id = " . $_GET['id'];
mysqli_query($conn, $queryDelete);
