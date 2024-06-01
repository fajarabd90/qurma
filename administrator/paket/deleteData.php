<?php
require '../../config.php';
$queryDelete = "DELETE FROM paket WHERE id = " . $_GET['id'];
mysqli_query($conn, $queryDelete);
