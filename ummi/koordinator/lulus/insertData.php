<?php
// Sambungkan ke database
require '../../config.php';

// Periksa jika ada pengiriman formulir POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $id_tes = $_POST['id_tes'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $keterangan_mun = $_POST['keterangan_mun'];

    // Array untuk menyimpan id_tes yang sudah diproses
    $processedNames = array();

    // Flag untuk menandai apakah terdapat duplikat id_tes
    $duplicateFound = false;

    // Loop melalui setiap nilai siswa
    foreach ($nama as $key => $value) {
        // Bersihkan nilai (gunakan mysqli_real_escape_string() jika tidak menggunakan prepared statement)
        $id_tes_clean = mysqli_real_escape_string($conn, $id_tes[$key]);
        $nama_clean = mysqli_real_escape_string($conn, $nama[$key]);
        $kategori_clean = mysqli_real_escape_string($conn, $kategori[$key]);
        $keterangan_mun_clean = mysqli_real_escape_string($conn, $keterangan_mun[$key]);

        // Validasi id_tes unik sebelum memasukkan data ke dalam database
        if (in_array($id_tes_clean, $processedNames)) {
            // id_tes sudah diproses sebelumnya, tandai duplikat dan lanjutkan ke siswa berikutnya
            $duplicateFound = true;
            continue;
        }

        // Tambahkan id_tes ke dalam array processedNames
        $processedNames[] = $id_tes_clean;

        // Buat dan eksekusi query untuk memeriksa apakah id_tes sudah ada dalam database
        $queryCheck = "SELECT COUNT(*) as count FROM lulus WHERE id_tes = '$id_tes_clean'";
        $resultCheck = mysqli_query($conn, $queryCheck);
        $rowCheck = mysqli_fetch_assoc($resultCheck);

        if ($rowCheck['count'] > 0) {
            // id_tes sudah ada dalam database, tandai duplikat dan lanjutkan ke siswa berikutnya
            $duplicateFound = true;
            continue;
        }

        // Buat dan eksekusi query untuk memasukkan data ke dalam database
        $query = "INSERT INTO lulus (id_tes, nama, kategori, keterangan_mun) VALUES ('$id_tes_clean', '$nama_clean', '$kategori_clean', '$keterangan_mun_clean')";
        $result = mysqli_query($conn, $query);

        // Periksa apakah query berhasil dieksekusi
        if (!$result) {
            echo "<script>alert('Gagal menyimpan data kelompok: " . mysqli_error($conn) . "');</script>";
            // Berhenti jika terjadi kesalahan
            break;
        }
    }

    // Tampilkan pesan berhasil atau duplikat id_tes
    if ($duplicateFound) {
        echo "<script>alert('Beberapa hasil Lolos siswa sudah ada dalam database.');</script>";
    } else if ($result) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
    }

    // Redirect ke catatan index setelah selesai
    echo "<script>document.location.href = 'index.php';</script>";
} else {
    // Jika bukan metode POST, tampilkan pesan kesalahan
    echo "Metode tidak diizinkan.";
}
