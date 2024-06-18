<?php
require '../../config.php';

session_start();
$id = $_SESSION['admin'];

if (!isset($id)) {
    header('location:../../index.php');
}

$user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
$lembaga = $user['lembaga'];

// Load file autoload.php
require '../../plugins/vendor/autoload.php';
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Guru | QurMa</title>
    <link rel="shortcut icon" href="../../assets/img/logo.png" />
    <link href="../../dist/css/app.css" rel="stylesheet">
    <link href="../../dist/css/table.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="../index.php">
                    <span class="align-middle">QurMa (<?= $lembaga ?>)</span>
                </a>

                <ul class="sidebar-nav">
                    <?php include '../template/sidenav.php'; ?>
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <?php include '../template/header.php'; ?>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Guru</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Upload Data Guru</h5>
                                    <div class="ms-auto d-flex align-items-center">
                                        <a href="index.php"><button type="button" class="btn btn-sm btn-warning mb-2 rounded-pill" style="margin-right: 5px;">
                                                <i class="fa fa-arrow-circle-left"></i>
                                            </button></a>
                                        <a href="upload-siswa.xlsx"><button type="button" class="btn btn-sm btn-success mb-2 rounded-pill" style="margin-right: 5px;">
                                                <i class="fa fa-file-excel"></i>
                                            </button></a>
                                        <button class="btn btn-sm btn-danger mb-2 rounded-pill" id="hapusDataButton"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>

                                <div class="card-body py-3">
                                    <form method="post" action="upload.php" enctype="multipart/form-data">
                                        <div>
                                            <div class="float-left">
                                                <input type="file" name="file" class="form-control mb-2">
                                            </div>
                                            <center>
                                                <i>Setelah pilih file, PREVIEW dulu. Jika datanya telah sesuai, klik IMPORT di bawah.</i><br>
                                                <button type="submit" name="preview" class="btn btn-primary">PREVIEW</button>
                                            </center>
                                        </div>
                                    </form>
                                    <hr>

                                    <?php
                                    // Jika user telah mengklik tombol Preview
                                    if (isset($_POST['preview'])) {
                                        $tgl_sekarang = date('YmdHis'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
                                        $nama_file_baru = 'data ' . $tgl_sekarang . '.xlsx';

                                        // Cek apakah terdapat file data.xlsx pada folder tmp
                                        if (is_file('tmp/' . $nama_file_baru)) // Jika file tersebut ada
                                            unlink('tmp/' . $nama_file_baru); // Hapus file tersebut

                                        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
                                        $tmp_file = $_FILES['file']['tmp_name'];

                                        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
                                        if ($ext == "xlsx") {
                                            // Upload file yang dipilih ke folder tmp
                                            // dan rename file tersebut menjadi data{tglsekarang}.xlsx
                                            // {tglsekarang} diganti jadi tanggal sekarang dengan format yyyymmddHHiiss
                                            // Contoh nama file setelah di rename : data20210814192500.xlsx
                                            move_uploaded_file($tmp_file, 'tmp/' . $nama_file_baru);

                                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                                            $spreadsheet = $reader->load('tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                                            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                                            // Buat sebuah tag form untuk proses import data ke database
                                            echo "<form method='post' action='import.php'>";

                                            // Disini kita buat input type hidden yg isinya adalah nama file excel yg diupload
                                            // ini tujuannya agar ketika import, kita memilih file yang tepat (sesuai yg diupload)
                                            echo "<input type='hidden' name='namafile' value='" . $nama_file_baru . "'>";

                                            // Buat sebuah div untuk alert validasi kosong
                                            echo "<div id='kosong' class='alert alert-danger' style='display:none;'>
                Ada <span id='jumlah_kosong'></span> data yang belum diisi.
            </div>";

                                            echo "<div class='tableFixHead' style='height: 500px;'>
                <table class='table table-bordered border-dark' id='example'>
                    <thead>
                        <tr>
                            <th colspan='2' class='text-left'>Preview Data</th>
                        </tr>
                        <tr>
                            <th scope='col'>Lembaga</th>
                            <th scope='col'>Nama</th>
                        </tr>
                    </thead>";

                                            $numrow = 1;
                                            $kosong = 0;
                                            foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel
                                                // Ambil data pada excel sesuai Kolom
                                                $lembaga = $row['B'];
                                                $nama = $row['C'];
                                                $status = $row['D'];
                                                $sertifikasi = $row['E'];

                                                // Cek jika semua data tidak diisi
                                                if ($lembaga == "" && $nama == "" && $status == "" && $sertifikasi == "")
                                                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                                // Cek $numrow apakah lebih dari 1
                                                // Artinya karena baris pertama adalah nama-nama kolom
                                                // Jadi dilewat saja, tidak usah diimport
                                                if ($numrow > 1) {
                                                    // Validasi apakah telah diisi
                                                    $lembaga_td = (!empty($lembaga)) ? "" : " style='background: #E07171;'";
                                                    $nama_td = (!empty($nama)) ? "" : " style='background: #E07171;'";
                                                    $status_td = (!empty($status)) ? "" : " style='background: #E07171;'";
                                                    $sertifikasi_td = (!empty($sertifikasi)) ? "" : " style='background: #E07171;'";

                                                    // Jika salah satu data ada yang kosong
                                                    if ($lembaga == "" && $nama == "" && $status == "" && $sertifikasi == "") {
                                                        $kosong++; // Tambah 1 variabel $kosong
                                                    }

                                                    echo "<tbody><tr>";
                                                    echo "<td" . $lembaga_td . ">" . $lembaga . "</td>";
                                                    echo "<td" . $nama_td . ">" . $nama . "</td>";
                                                    echo "<td" . $status_td . ">" . $status . "</td>";
                                                    echo "<td" . $sertifikasi_td . ">" . $sertifikasi . "</td>";
                                                    echo "</tr></tbody>";
                                                }

                                                $numrow++; // Tambah 1 setiap kali looping
                                            }

                                            echo "</table></div>";

                                            // Cek apakah variabel kosong lebih dari 0
                                            // Jika lebih dari 0, berarti ada data yang masih kosong
                                            if ($kosong > 0) {
                                                echo "<script>
                    $(document).ready(function() {
                        // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                        $('#jumlah_kosong').html('" . $kosong . "');

                        $('#kosong').show(); // Munculkan alert validasi kosong
                    });
                </script>";
                                            } else { // Jika semua data sudah diisi
                                                echo "<hr style='margin-top: 0;'>";

                                                // Buat sebuah tombol untuk mengimport data ke database
                                                echo "<center><button type='submit' name='import' class='btn btn-success'>IMPORT</button></center>";
                                            }

                                            echo "</form>";
                                        } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
                                            // Munculkan pesan validasi
                                            echo "<div class='alert alert-danger'>
                Hanya File Excel 2007 (.xlsx) yang diperbolehkan
            </div>";
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </main>

            <footer class="footer">
                <?php include '../template/footer.php'; ?>
            </footer>
        </div>
    </div>

    <script src="../../dist/js/app.js"></script>

    <script>
        $(document).ready(function() {
            $('#hapusDataButton').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin untuk mengosongkan tabel?',
                    text: 'Data yang ada akan dihapus secara permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kosongkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: 'emptyTable.php',
                            success: function(response) {
                                if (response === 'success') {
                                    Swal.fire(
                                        'Tabel dikosongkan!',
                                        'Data telah dihapus',
                                        'success'
                                    ).then(() => {
                                        window.location.href = document.referrer;
                                    });
                                } else {
                                    Swal.fire(
                                        'Gagal mengosongkan tabel',
                                        'Terjadi kesalahan',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Gagal mengosongkan tabel',
                                    'Terjadi kesalahan',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>