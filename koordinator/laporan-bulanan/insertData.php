<?php
// Sambungkan ke database
require '../../config.php';

// Periksa jika ada pengiriman formulir POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $nama = $_POST['nama'];
    $bulan = $_POST['bulan'];
    $jilid = $_POST['jilid'];
    $halaman = $_POST['halaman'];
    $ketuntasan_tartil = $_POST['ketuntasan_tartil'];
    $juz = $_POST['juz'];
    $surat = $_POST['surat'];
    $ketuntasan_tahfizh = $_POST['ketuntasan_tahfizh'];

    // Loop melalui setiap nilai siswa (asumsi jumlah siswa sesuai dengan $tahun_ajaran)
    foreach ($nama as $key => $value) {
        // Bersihkan nilai (gunakan mysqli_real_escape_string() jika tidak menggunakan prepared statement)
        $nama_clean = $nama[$key];
        $bulan_clean = $bulan[$key];
        $jilid_clean = $jilid[$key];
        $halaman_clean = $halaman[$key];
        $ketuntasan_tartil_clean = $ketuntasan_tartil[$key];
        $juz_clean = $juz[$key];
        $surat_clean = $surat[$key];
        $ketuntasan_tahfizh_clean = $ketuntasan_tahfizh[$key];

        // Buat dan eksekusi query untuk memasukkan data ke dalam database
        $query = "INSERT INTO laporan (nama, bulan, jilid, halaman, ketuntasan_tartil, juz, surat, ketuntasan_tahfizh) VALUES ('$nama_clean', '$bulan_clean', '$jilid_clean', '$halaman_clean', '$ketuntasan_tartil_clean', '$juz_clean', '$surat_clean', '$ketuntasan_tahfizh_clean')";
        $result = mysqli_query($conn, $query);

        // Periksa apakah query berhasil dieksekusi
        if (!$result) {
            echo "Gagal menyimpan data kelompok: " . mysqli_error($conn);
            // Berhenti jika terjadi kesalahan
            break;
        }
    }

    if ($result) {
        echo "
              <script>
                alert('Data berhasil disimpan!');
                document.location.href = 'index.php';
              </script>
              ";
    } else {
        echo "
              <script>
                alert('Data gagal disimpan!');
                // document.location.href = 'index.php';
              </script>
              ";
    }
} else {
    // Jika bukan metode POST, tampilkan pesan kesalahan
    echo "Metode tidak diizinkan.";
}
