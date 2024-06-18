<?php
// Memeriksa apakah parameter filename diterima
if (isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    $folder = "img/"; // Folder tempat foto disimpan

    // Memeriksa apakah file ada dan menghapusnya jika iya
    if (file_exists($folder . $filename)) {
        unlink($folder . $filename);
        echo "Foto berhasil dihapus.";
    } else {
        echo "Gagal menghapus foto. File tidak ditemukan.";
    }
} else {
    echo "Gagal menghapus foto. Parameter filename tidak diterima.";
}
