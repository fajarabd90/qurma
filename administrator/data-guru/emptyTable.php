<?php
require '../../config.php';

// Periksa koneksi
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

// Kode untuk menghapus data dari tabel
$sql = 'TRUNCATE TABLE guru';

if ($conn->query($sql) === TRUE) {
    echo 'success';
} else {
    echo 'error';
}

$conn->close();
