<?php
// Menghubungkan ke database
$koneksi = mysqli_connect("localhost", "qurk4279_fajar", "fajarabd90", "qurk4279_ummi");

// Memeriksa koneksi
if (mysqli_connect_errno()) {
    $response = array("success" => false, "message" => "Koneksi database gagal: " . mysqli_connect_error());
    echo json_encode($response);
    exit();
}

require '../../config.php';
session_start();
$id = $_SESSION['guru'];

if (!isset($id)) {
    header('location:../../index.php');
}

$user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
$lembaga = $user['lembaga'];
$guru = $user['nama'];

// Mengambil data nama dari tabel
$query = "SELECT siswa.lembaga, siswa.nama, kelompok.guru
FROM siswa
INNER JOIN kelompok ON siswa.nama = kelompok.nama
WHERE lembaga = '$lembaga' AND kelompok.guru = '$guru' ORDER BY siswa.nama ASC";
$result = mysqli_query($koneksi, $query);

// Memeriksa apakah query berhasil dieksekusi
if (!$result) {
    $response = array("success" => false, "message" => "Error: " . mysqli_error($koneksi));
    echo json_encode($response);
    exit();
}

// Menyimpan nama ke dalam array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row['nama'];
}

// Menutup koneksi
mysqli_close($koneksi);

// Mengembalikan data dalam format JSON
$response = array("success" => true, "data" => $data);
echo json_encode($response);
