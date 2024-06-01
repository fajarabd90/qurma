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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tes Tahfizh</title>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Tes Tahfizh</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Tes</h5>
                                    <div class="ms-auto d-flex align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#addData">
                                            <i data-feather="edit"></i> Catat Tes
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body py-3">
                                    <input style="margin-top: -20px;" class="form-control me-2 mb-2" type="text" id="searchInput" placeholder="Filter nama siswa, Guru atau hasil tes..." aria-label="Search">
                                    <div id="mainContent"></div>

                                    <!-- Modal tambah-->
                                    <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-plus"></i> Catat Tes</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="row justify-content-center align-items-center">
                                                        <div class="col-auto">
                                                            <p class="text-center">Masukkan angka baris yang diinginkan :</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="number" class="form-control mb-2" id="inputAngka" min="0" value="0" style="width: 80px;">
                                                        </div>
                                                    </div>


                                                    <!-- Form tambah -->
                                                    <form action="insertData.php" method="post">
                                                        <div class="tableFixHead" style="height: 500px;">

                                                            <table class="table table-bordered border-dark" id="dataTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Nama</th>
                                                                        <th>Juz</th>
                                                                        <th>Surat</th>
                                                                        <th>Nilai</th>
                                                                        <th>Catatan</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!-- Akhir form tambah -->
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
        // Fungsi untuk menambahkan baris baru
        function tambahBaris() {
            var table = document.getElementById("dataTable").getElementsByTagName('tbody')[0];
            var rowCount = table.rows.length; // Jumlah total baris yang ada

            var row = table.insertRow(rowCount); // Insert di akhir tabel, indeks rowCount

            // Kolom nomor urut
            var cellNo = row.insertCell(0);
            cellNo.innerHTML = rowCount + 1; // Nomor urut dimulai dari 1
            cellNo.style.width = "5px"; // Atur lebar sel menjadi 150px

            // Kolom nama
            var cellNama = row.insertCell(1);
            cellNama.style.width = "250px";

            // Menggunakan AJAX untuk mengambil data dari server
            $.ajax({
                url: "getSiswa.php", // Ganti dengan URL ke file PHP yang akan mengambil data dari database
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Jika pengambilan data berhasil
                        var options = "<input class='form-control' list='datalistOptions' placeholder='Nama Siswa' name='nama[]' required> <datalist id='datalistOptions'>";
                        // Menambahkan opsi kosong pertama
                        options += "<option value=''>Pilih Nama</option>";
                        // Loop melalui setiap nama dan tambahkan ke dalam opsi dropdown
                        $.each(response.data, function(index, value) {
                            options += "<option value='" + value + "'>" + value + "</option>";
                        });
                        options += "</datalist>";
                        // Memasukkan opsi dropdown ke dalam sel
                        cellNama.innerHTML = options;
                    } else {
                        // Jika ada kesalahan dalam pengambilan data
                        console.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan dalam melakukan AJAX: " + error);
                }
            });

            var cellJilid = row.insertCell(2);
            cellJilid.innerHTML = "<input type='hidden' class='form-control' name='jilid[]'>";
            cellJilid.style.display = "none";

            var cellJuz = row.insertCell(3);
            var selectOptions = "<select class='form-select' name='juz[]' required>" +
                "<option selected></option>";

            for (var i = 1; i <= 30; i++) {
                selectOptions += "<option value='" + i + "'>" + i + "</option>";
            }

            selectOptions += "</select>";

            cellJuz.innerHTML = selectOptions;
            cellJuz.style.width = "120px";

            var cellSurat = row.insertCell(4);
            cellSurat.innerHTML = "<input type='text' class='form-control' name='surat[]'>";
            cellSurat.style.width = "350px";

            var cellNilai1 = row.insertCell(5);
            cellNilai1.innerHTML = "<input type='text' class='form-control' name='nilai1[]'>";
            cellNilai1.style.width = "100px";

            var cellNilai2 = row.insertCell(6);
            cellNilai2.innerHTML = "<input type='hidden' class='form-control' name='nilai2[]'>";
            cellNilai2.style.display = "none";

            var cellNilai3 = row.insertCell(7);
            cellNilai3.innerHTML = "<input type='hidden' class='form-control' name='nilai3[]'>";
            cellNilai3.style.display = "none";

            var cellCatatan = row.insertCell(8);
            cellCatatan.innerHTML = "<input type='text' class='form-control' name='catatan[]'>";
            cellCatatan.style.width = "280px";

            var cellKeterangan = row.insertCell(9);
            cellKeterangan.innerHTML = "<select class='form-select' name='keterangan[]' required>" +
                "<option selected></option>" +
                "<option value='Belum'>Belum</option>" +
                "<option value='Lulus'>Lulus</option>" +
                "<option value='Ke Pra Munaqosyah'>Ke Pra Munaqosyah</option>" +
                "</select>";
            cellKeterangan.style.width = "130px";

            var cellKategori = row.insertCell(10);
            cellKategori.innerHTML = "<input type='hidden' class='form-control' name='kategori[]' value='Tahfizh'>";
            cellKategori.style.display = "none";
        }

        // Fungsi untuk menangani perubahan nilai input angka
        function handleInputChange() {
            var table = document.getElementById("dataTable").getElementsByTagName('tbody')[0];
            var rowCount = table.rows.length; // Jumlah total baris yang ada

            var inputValue = parseInt(this.value); // Mendapatkan nilai input sebagai integer

            if (inputValue > rowCount) {
                // Jika nilai input lebih besar dari jumlah baris, tambahkan baris sebanyak nilai input - jumlah baris
                for (var i = rowCount; i < inputValue; i++) {
                    tambahBaris(); // Panggil fungsi untuk menambah baris
                }
            } else if (inputValue < rowCount) {
                // Jika nilai input lebih kecil dari jumlah baris, hapus baris dari indeks ke-n hingga akhir
                for (var i = rowCount - 1; i >= inputValue; i--) {
                    table.deleteRow(i);
                }
            }
        }

        // Ambil elemen input angka
        var inputAngka = document.getElementById("inputAngka");

        // Tambahkan event listener untuk menangani perubahan nilai input
        inputAngka.addEventListener("change", handleInputChange);
    </script>

    <script>
        var currentSearchTerm = ''; // Variable to store the current search term

        $(document).ready(function() {
            loadData()

            $('#searchInput').keyup(function() {
                var searchTerm = $(this).val();
                currentSearchTerm = searchTerm; // Update the current search term
                loadData(searchTerm);
            });

            function loadData(searchTerm = '') {
                $.ajax({
                    url: 'getData.php',
                    type: 'GET',
                    data: {
                        search: searchTerm
                    },
                    success: function(data) {
                        $("#mainContent").html(data);
                        $('.hapusData').click(function(e) {
                            e.preventDefault();

                            Swal.fire({
                                title: 'Apakah Anda yakin untuk hapus data?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: 'GET',
                                        url: $(this).attr('href'),
                                        success: function() {
                                            loadData();
                                        }
                                    });

                                    Swal.fire(
                                        'Terhapus!',
                                        'Data telah terhapus',
                                        'success'
                                    )
                                }
                            });
                        });
                    }
                })
            }

            $('#editData').modal({
                keyboard: true,
                backdrop: "static",
                show: false,

            }).on("show.bs.modal", function(event) {
                var button = $(event.relatedTarget);
                var id = $(event.relatedTarget).closest("tr").find("td:eq(0)").text();
                var waktu = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();
                var nama = $(event.relatedTarget).closest("tr").find("td:eq(3)").text();
                var jilid = $(event.relatedTarget).closest("tr").find("td:eq(6)").text();
                var juz = $(event.relatedTarget).closest("tr").find("td:eq(7)").text();
                var surat = $(event.relatedTarget).closest("tr").find("td:eq(8)").text();
                var nilai1 = $(event.relatedTarget).closest("tr").find("td:eq(9)").text();
                var nilai2 = $(event.relatedTarget).closest("tr").find("td:eq(10)").text();
                var nilai3 = $(event.relatedTarget).closest("tr").find("td:eq(11)").text();
                var catatan = $(event.relatedTarget).closest("tr").find("td:eq(12)").text();
                var keterangan = $(event.relatedTarget).closest("tr").find("td:eq(13)").text();
                var kategori = $(event.relatedTarget).closest("tr").find("td:eq(14)").text();

                $(this).find('#modal-edit').html($(
                    `
                <!-- Form edit -->
                    <form method="post" class="updateData" action="updateData.php" id="formEdit">
                    
                    <input type="hidden" name="id" value="${id}">
                    <input type="hidden" name="waktu" value="${waktu}">
                    <input type="hidden" name="kategori" value="${kategori}">
                    <input type="hidden" name="jilid" value="${juz}">

                    <?php $siswa = query("SELECT * FROM siswa WHERE lembaga = '$lembaga'") ?>
                    <input class="form-control mb-2" list="datalistOptions" id="nama" placeholder="Nama Siswa" name="nama" value="${nama}" required>
                    <datalist id="datalistOptions">
                        <?php foreach ($siswa as $row) : ?>
                            <option value="<?= $row["nama"]; ?>">
                            <?php endforeach; ?>
                    </datalist>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="juz" name="juz" value="${juz}">
                                <label for="juz">Juz</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="surat" name="surat" value="${surat}">
                                <label for="surat">Surat</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="nilai1" name="nilai1" value="${nilai1}">
                                <label for="nilai1">Nilai</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-2">
                                <select class="form-select" id="keterangan" name="keterangan" required>
                                    <option selected>${keterangan}</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Belum">Belum</option>
                                    <option value="Ke Pra Munaqosyah">Ke Pra Munaqosyah</option>
                                </select>
                                <label for="keterangan">Keterangan</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-2">
                        <textarea class="form-control" name="catatan" id="catatan" style="height: 120px">${catatan}</textarea>
                        <label for="catatan">Catatan</label>
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
                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#editData').modal('hide');
                            if (currentSearchTerm === '') {
                                loadData(); // Load data without search term
                            } else {
                                loadData(currentSearchTerm); // Load data with the current search term
                            }

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
    </script>
</body>

</html>