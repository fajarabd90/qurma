<?php
require '../../config.php';
$queryDelete = "DELETE FROM user WHERE id = " . $_GET['id'];
mysqli_query($conn, $queryDelete);
