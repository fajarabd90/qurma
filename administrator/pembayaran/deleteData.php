<?php
require '../../config.php';
$queryDelete = "DELETE FROM pembayaran WHERE id = " . $_GET['id'];
mysqli_query($conn, $queryDelete);
