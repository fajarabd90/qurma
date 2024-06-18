<?php
// Lokasi folder tempat menyimpan foto yang diupload
$uploadDir = 'img/';

// Jika form di-submit
if (isset($_POST['submit'])) {
    // Jumlah file yang diupload
    $fileCount = count($_FILES['files']['name']);

    // Loop melalui semua file yang diupload
    for ($i = 0; $i < $fileCount; $i++) {
        // File sementara yang diupload
        $tmpFilePath = $_FILES['files']['tmp_name'][$i];

        // Pastikan file tidak kosong
        if ($tmpFilePath != "") {
            // Nama file asli
            $fileName = basename($_FILES['files']['name'][$i]);

            // Lokasi baru untuk menyimpan file
            $newFilePath = $uploadDir . $fileName;

            // Pindahkan file ke lokasi baru
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                // Tampilkan pesan jika berhasil
                echo "<script>
        alert('Data berhasil disimpan!');
        document.location.href = 'index.php';
      </script>
      ";
            } else {
                // Tampilkan pesan jika gagal
                echo "<script>
                alert('Data gagal disimpan!');
                document.location.href = 'index.php';
              </script>
              ";
            }
        }
    }
}
