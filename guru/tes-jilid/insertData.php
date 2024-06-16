<?php
// Sambungkan ke database
require '../../config.php';

// Periksa jika ada pengiriman formulir POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $nama = $_POST['nama'];
    $jilid = $_POST['jilid'];
    $juz = $_POST['juz'];
    $surat = $_POST['surat'];
    $nilai1 = $_POST['nilai1'];
    $nilai2 = $_POST['nilai2'];
    $nilai3 = $_POST['nilai3'];
    $catatan = $_POST['catatan'];
    $keterangan = $_POST['keterangan'];
    $kategori = $_POST['kategori'];
    $guru = $_POST['guru'];

    // Loop melalui setiap nilai siswa (asumsi jumlah siswa sesuai dengan $tahun_ajaran)
    foreach ($nama as $key => $value) {
        // Bersihkan nilai (gunakan mysqli_real_escape_string() jika tidak menggunakan prepared statement)
        $nama_clean = $nama[$key];
        $jilid_clean = $jilid[$key];
        $juz_clean = $juz[$key];
        $surat_clean = $surat[$key];
        $nilai1_clean = $nilai1[$key];
        $nilai2_clean = $nilai2[$key];
        $nilai3_clean = $nilai3[$key];
        $catatan_clean = $catatan[$key];
        $keterangan_clean = $keterangan[$key];
        $kategori_clean = $kategori[$key];
        $guru_clean = $guru[$key];

        // Buat dan eksekusi query untuk memasukkan data ke dalam database
        $query = "INSERT INTO tes (nama, jilid, juz, surat, nilai1, nilai2, nilai3, catatan, keterangan, kategori, guru) VALUES ('$nama_clean', '$jilid_clean', '$juz_clean', '$surat_clean', '$nilai1_clean', '$nilai2_clean', '$nilai3_clean', '$catatan_clean', '$keterangan_clean', '$kategori_clean', '$guru_clean')";
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
