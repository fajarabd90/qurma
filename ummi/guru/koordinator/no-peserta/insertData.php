<?php
// Sambungkan ke database
require '../../config.php';

// Periksa jika ada pengiriman formulir POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $id_tes = $_POST['id_tes'];
    $nama = $_POST['nama'];
    $nomor = $_POST['nomor'];

    // Array untuk menyimpan nama yang sudah diproses
    $processedNames = array();

    // Flag untuk menandai apakah terdapat duplikat nama
    $duplicateFound = false;

    // Loop melalui setiap nilai siswa
    foreach ($nama as $key => $value) {
        // Bersihkan nilai (gunakan mysqli_real_escape_string() jika tidak menggunakan prepared statement)
        $id_tes_clean = mysqli_real_escape_string($conn, $id_tes[$key]);
        $nama_clean = mysqli_real_escape_string($conn, $nama[$key]);
        $nomor_clean = mysqli_real_escape_string($conn, $nomor[$key]);

        // Validasi nama unik sebelum memasukkan data ke dalam database
        if (in_array($nama_clean, $processedNames)) {
            // Nama sudah diproses sebelumnya, tandai duplikat dan lanjutkan ke siswa berikutnya
            $duplicateFound = true;
            continue;
        }

        // Tambahkan nama ke dalam array processedNames
        $processedNames[] = $nama_clean;

        // Buat dan eksekusi query untuk memeriksa apakah nama sudah ada dalam database
        $queryCheck = "SELECT COUNT(*) as count FROM nomor WHERE id_tes = '$id_tes_clean'";
        $resultCheck = mysqli_query($conn, $queryCheck);
        $rowCheck = mysqli_fetch_assoc($resultCheck);

        if ($rowCheck['count'] > 0) {
            // Nama sudah ada dalam database, tandai duplikat dan lanjutkan ke siswa berikutnya
            $duplicateFound = true;
            continue;
        }

        // Buat dan eksekusi query untuk memasukkan data ke dalam database
        $query = "INSERT INTO nomor (id_tes, nama, nomor) VALUES ('$id_tes_clean', '$nama_clean', '$nomor_clean')";
        $result = mysqli_query($conn, $query);

        // Periksa apakah query berhasil dieksekusi
        if (!$result) {
            echo "<script>alert('Gagal menyimpan data kelompok: " . mysqli_error($conn) . "');</script>";
            // Berhenti jika terjadi kesalahan
            break;
        }
    }

    // Tampilkan pesan berhasil atau duplikat nama
    if ($duplicateFound) {
        echo "<script>alert('Beberapa nama siswa sudah ada dalam database.');</script>";
    } else if ($result) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
    }

    // Redirect ke halaman index setelah selesai
    echo "<script>document.location.href = 'index.php';</script>";
} else {
    // Jika bukan metode POST, tampilkan pesan kesalahan
    echo "Metode tidak diizinkan.";
}
