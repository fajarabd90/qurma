<?php
require '../../config.php';
$queryDelete = "DELETE FROM tes WHERE id = " . $_GET['id'];
mysqli_query($conn, $queryDelete);
