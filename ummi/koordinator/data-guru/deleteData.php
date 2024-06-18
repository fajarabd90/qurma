<?php
require '../../config.php';
$queryDelete = "DELETE FROM guru WHERE id = " . $_GET['id'];
mysqli_query($conn, $queryDelete);
