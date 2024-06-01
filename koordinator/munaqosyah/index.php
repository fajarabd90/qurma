<?php

require '../../config.php';

session_start();
$id = $_SESSION['koordinator'];

if (!isset($id)) {
    header('location:../../index.php');
}

$user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
$lembaga = $user['lembaga'];

// Load file autoload.php
require '../../plugins/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['download_excel'])) {
    // Query SQL
    $sql = "SELECT siswa.lembaga, siswa.nama, siswa.kelas, pra_munaqosyah.kategori, pra_munaqosyah.keterangan_pra,
    siswa.jenis_kelamin, siswa.no_hp, siswa.alamat, siswa.tempat_lahir, siswa.tgl_lahir
    FROM siswa
    LEFT JOIN pra_munaqosyah ON siswa.nama = pra_munaqosyah.nama
    WHERE siswa.lembaga = '$lembaga' AND pra_munaqosyah.keterangan_pra = 'Lolos'
    ORDER BY siswa.kelas, siswa.nama ASC";

    $result = mysqli_query($conn, $sql);

    // Inisialisasi Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Lengkap');
    $sheet->setCellValue('C1', 'Jenis Kelamin');
    $sheet->setCellValue('D1', 'Kelas');
    $sheet->setCellValue('E1', 'No.Hp Wali Peserta');
    $sheet->setCellValue('F1', 'Alamat');
    $sheet->setCellValue('G1', 'Tempat Lahir');
    $sheet->setCellValue('H1', 'Tanggal Lahir');
    $sheet->setCellValue('I1', 'Jenis Munaqosyah');

    // Isi data
    $row = 2;
    $number = 1;
    $no_data = ""; // Variabel untuk nomor urutan

    $number = 1; // Inisialisasi nomor urutan
    while ($row_data = mysqli_fetch_assoc($result)) {
        // Set nilai di setiap kolom
        // Set nilai di setiap kolom
        $sheet->setCellValue('A' . $row, $number); // Kolom nomor urutan
        $sheet->setCellValue('B' . $row, $row_data['nama']);
        $sheet->setCellValue('C' . $row, $row_data['jenis_kelamin']);
        $sheet->setCellValue('D' . $row, $row_data['kelas']);
        $sheet->setCellValue('E' . $row, $row_data['no_hp']);
        $sheet->setCellValue('F' . $row, $row_data['alamat']);
        $sheet->setCellValue('G' . $row, $row_data['tempat_lahir']);
        $sheet->setCellValue('H' . $row, $row_data['tgl_lahir']);

        // String kategori
        $kategori = $row_data["kategori"];

        // Inisialisasi $juz
        $juz = null;

        // Mencari angka dalam string menggunakan preg_match
        if (preg_match('/\d+/', $kategori, $matches)) {
            // Jika ada angka yang cocok, maka ambil nilai pertama dalam $matches
            $juz = $matches[0];
        }

        // Mengatur nilai di kolom "I" berdasarkan kondisi $tartil dan $tahfizh
        $info_munaqasyah = '';
        if ($kategori == "Tartil") {
            $info_munaqasyah = "Munaqasyah Tartil";
        } else {
            if ($juz !== null) {
                $info_munaqasyah = "Munaqasyah Tahfidz Al Quran Juz ke - " . $juz;
            } else {
                // Handle jika tidak ada angka yang ditemukan
                $info_munaqasyah = "Munaqasyah Tahfidz Al Quran (Juz tidak ditemukan)";
            }
        }

        $sheet->setCellValue('I' . $row, $info_munaqasyah);

        // Increment nomor urutan dan baris untuk baris berikutnya
        $row++;
        $number++;
    }

    // Buat objek writer untuk format Xlsx
    $writer = new Xlsx($spreadsheet);

    // Simpan file Excel
    $excel_filename = 'data_munaqosyah.xlsx';
    $writer->save($excel_filename);

    // Set header untuk file Excel yang akan diunduh
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"$excel_filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Baca file Excel dan keluarkan ke output
    readfile($excel_filename);

    // Hapus file Excel setelah diunduh
    unlink($excel_filename);

    // Stop eksekusi PHP setelah menghasilkan file Excel
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Munaqosyah</title>
    <link rel="shortcut icon" href="../../assets/img/logo.png" />
    <link href="../../dist/css/app.css" rel="stylesheet">
    <link href="../../dist/css/table.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .dropdown-item {
            color: white !important;
            /* Set warna teks menjadi putih */
        }

        .dropdown-item:hover {
            color: white !important;
            /* Tetapkan warna teks putih bahkan ketika disorot */
            background-color: #28a745 !important;
            /* Tetapkan warna latar belakang sesuai keinginan Anda */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <?php include '../template/sidenav.php'; ?>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Munaqosyah</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Data Peserta Munaqosyah</h5>

                                    <div class="ms-auto d-flex align-items-center">
                                        <a class="btn btn-success btn-sm rounded-pill dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 5px;">Menu</i></a>
                                        <ul class="dropdown-menu bg-success" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item text-white" href="pengumuman.php" target="_blank"><i class="fas fa-print"></i> Print Peserta</a></li>
                                            <li>
                                                <form method="post">
                                                    <button type="submit" name="download_excel" class="dropdown-item text-white"><i class="fas fa-file-excel"></i> Download Data</button>
                                                </form>
                                            </li>
                                            <li><a class="dropdown-item text-white" href="../no-peserta/index.php"><i class="fas fa-edit"></i> Input Nomor & Kartu</a></li>
                                            <li><a class="dropdown-item text-white" href="../lulus/index.php"><i class="fas fa-edit"></i> Input Lulus</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Modal tambah-->
                                <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-stop"></i> Nomor Dada</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="card-body">
                                                    <!-- Add the filter form -->
                                                    <div class="row g-3">
                                                        <div class="col">
                                                            <form id="filterForm">
                                                                <select class="form-select" aria-label="Default select example" name="kategoriFilter" id="kategoriFilter">
                                                                    <option value="">Pilih Kategori</option>
                                                                    <option value="Tartil">Tartil</option>
                                                                    <option value="Tahfizh">Tahfizh</option>
                                                                </select>
                                                            </form>
                                                        </div>
                                                        <div id="filteredResults" class="mt-2">
                                                            <!-- Display the filtered results here -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir modal tambah -->

                                <!-- Modal edit-->
                                <div class="modal fade" id="editData" tabindex="-1" aria-labelledby="editData" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editData"><i class='fas fa-edit'></i> Edit Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Modal edit menggunakan jquery yang akan di tampilkan value per value pada form-->
                                            <div class="modal-body" id="modal-edit">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir modal edit -->

                                <?php
                                $kategorisQuery = mysqli_query($conn, "SELECT DISTINCT kategori FROM pra_munaqosyah WHERE lembaga = '$lembaga' ORDER BY kategori ASC");
                                $kategoris = mysqli_fetch_all($kategorisQuery, MYSQLI_ASSOC);
                                ?>

                                <div class="card-body py-3" style="margin-top: -20px;">
                                    <p>Silahkan pilih Filter di bawah ini:</p>
                                    <!-- Add the filter form -->
                                    <div class="row g-3">
                                        <div class="col">
                                            <form id="filterForm">
                                                <select class="form-select" aria-label="Default select example" name="kelasFilter2" id="kelasFilter2">
                                                    <option value="">Pilih Kelas</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <form id="filterForm">
                                                <select class="form-select" aria-label="Default select example" name="kategoriFilter2" id="kategoriFilter2">
                                                    <option value="">Pilih Juz</option>
                                                    <?php
                                                    foreach ($kategoris as $kategori) {
                                                        echo "<option value='" . $kategori['kategori'] . "'>" . $kategori['kategori'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <input class="form-control me-2" type="text" id="searchInput" placeholder="Ketikkan nama siswa..." aria-label="Search">
                                        </div>
                                        <div id="mainContent" class="mt-2">
                                            <!-- Display the filtered results here -->
                                        </div>
                                    </div>

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
            // Add event listener for teacherFilter change
            $('#kategoriFilter').change(function() {
                // Get the selected values from both filters
                var selectedKategori = $('#kategoriFilter').val();

                // Call loadData with the selected values
                loadData(selectedKategori);
            });

            // Initial load of data without specific filters
            loadData();

            function loadData(selectedKategori) {
                $.ajax({
                    type: 'POST',
                    url: 'formData.php',
                    data: {
                        kategoriFilter: selectedKategori
                    },
                    success: function(response) {
                        $('#filteredResults').html(response);
                    }
                });
            }
        });
    </script>

    <script>
        var currentSearchTerm = ''; // Variable to store the current search term

        $(document).ready(function() {
            // Add event listener for teacherFilter change
            $('#kelasFilter2, #kategoriFilter2').change(function() {
                // Get the selected values from both filters
                var selectedKelas2 = $('#kelasFilter2').val();
                var selectedKategori2 = $('#kategoriFilter2').val();

                // Call loadData with the selected values
                loadData(selectedKelas2, selectedKategori2, currentSearchTerm);
            });

            // Add event listener for searchInput keyup
            $('#searchInput').keyup(function() {
                var searchTerm = $(this).val();
                currentSearchTerm = searchTerm; // Update the current search term
                var selectedKelas2 = $('#kelasFilter2').val();
                var selectedKategori2 = $('#kategoriFilter2').val();
                loadData(selectedKelas2, selectedKategori2, searchTerm);
            });

            // Initial load of data without specific filters
            loadData();

            function loadData(selectedKelas2, selectedKategori2, searchTerm) {
                $.ajax({
                    type: 'GET',
                    url: 'getData.php',
                    data: {
                        kategoriFilter2: selectedKategori2,
                        kelasFilter2: selectedKelas2,
                        search: searchTerm
                    },
                    success: function(data) {
                        $('#mainContent').html(data);
                    }
                });
            }


            $('#editData').modal({
                keyboard: true,
                backdrop: "static",
                show: false,

            }).on("show.bs.modal", function(event) {
                var button = $(event.relatedTarget);
                var id = $(event.relatedTarget).closest("tr").find("td:eq(0)").text();
                var lembaga = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();
                var nama = $(event.relatedTarget).closest("tr").find("td:eq(3)").text();
                var kelas = $(event.relatedTarget).closest("tr").find("td:eq(4)").text();
                var jenis_kelamin = $(event.relatedTarget).closest("tr").find("td:eq(6)").text();
                var no_hp = $(event.relatedTarget).closest("tr").find("td:eq(7)").text();
                var alamat = $(event.relatedTarget).closest("tr").find("td:eq(8)").text();
                var tempat_lahir = $(event.relatedTarget).closest("tr").find("td:eq(9)").text();
                var tgl_lahir = $(event.relatedTarget).closest("tr").find("td:eq(10)").text();
                var ayah = $(event.relatedTarget).closest("tr").find("td:eq(11)").text();
                var ibu = $(event.relatedTarget).closest("tr").find("td:eq(12)").text();

                $(this).find('#modal-edit').html($(
                    `
                <!-- Form edit -->
                    <form method="post" class="updateData" action="updateData.php" id="formEdit">
                    
                        <input type="hidden" name="id" value="${id}">
                        <input type="hidden" name="lembaga" value="${lembaga}">

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="nama" name="nama" value="${nama}" readonly>
                            <label for="nama">Nama</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="kelas" name="kelas" value="${kelas}" readonly>
                            <label for="kelas">Kelas</label>
                        </div>

                        <div class="form-floating mb-2">
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option selected>${jenis_kelamin}</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="${no_hp}" pattern="^0[0-9]*$" title="Input harus diawali dengan angka 0" inputmode="numeric">
                            <label for="no_hp">No. HP Wali Peserta</label>
                        </div>


                        <div class="form-floating mb-2">
                        <textarea class="form-control" name="alamat" id="alamat" style="height: 100px" maxlength="80" oninput="updateCharacterCount()">${alamat}</textarea>
                        <label for="alamat">Alamat (<span id="characterCount">0</span>/80 characters)</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="${tempat_lahir}">
                        <label for="tempat_lahir">Tempat Lahir</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="${tgl_lahir}" min="1000-01-01" max="9999-12-31">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="ayah" name="ayah" value="${ayah}">
                        <label for="ayah">Nama Lengkap Ayah</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="ibu" name="ibu" value="${ibu}">
                        <label for="ibu">Nama Lengkap Ibu</label>
                    </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="edit" id="edit">Simpan</button>
                        </div>
                    </form>
                    <!-- Akhir form edit -->
                `
                ))

                $('#formEdit').submit(function(e) {
                    e.preventDefault();

                    // Get the selected teacher and evaluasi before submit
                    var selectedKategori2 = $('#kategoriFilter2').val();
                    var selectedkelas2 = $('#kelasFilter2').val();
                    var searchTerm = $('#searchInput').val(); // assuming this is the search input

                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#editData').modal('hide');

                            // Call loadData with the selected teacher and evaluasi after successful edit
                            loadData(selectedKategori2, selectedkelas2, searchTerm);

                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil diubah.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                });

            }).on('hide.bs.modal', function(event) {
                $(this).find('#modal-edit').html("")
            })
        })

        function updateCharacterCount() {
            var input = document.getElementById("alamat");
            var characterCountElement = document.getElementById("characterCount");
            characterCountElement.textContent = input.value.length;
        }
    </script>
</body>

</html>