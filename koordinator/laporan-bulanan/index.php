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
    <title>Laporan Bulanan</title>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Laporan Bulanan</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Data Masuk</h5>
                                </div>

                                <?php
                                $teachersQuery = mysqli_query($conn, "SELECT nama FROM guru WHERE lembaga = '$lembaga' ORDER BY nama ASC");
                                $teachers = mysqli_fetch_all($teachersQuery, MYSQLI_ASSOC);
                                ?>

                                <div class="card-body" style="margin-top: -20px;">
                                    <p>Silahkan pilih Filter di bawah ini:</p>
                                    <!-- Add the filter form -->
                                    <div class="row g-3">
                                        <div class="col">
                                            <form>
                                                <select class="form-select" aria-label="Default select example" name="bulanFilter2" id="bulanFilter2">
                                                    <option value="">Pilih Bulan</option>
                                                    <option value="Januari">Januari</option>
                                                    <option value="Februari">Februari</option>
                                                    <option value="Maret">Maret</option>
                                                    <option value="April">April</option>
                                                    <option value="Mei">Mei</option>
                                                    <option value="Juni">Juni</option>
                                                    <option value="Juli">Juli</option>
                                                    <option value="Agustus">Agustus</option>
                                                    <option value="September">September</option>
                                                    <option value="Oktober">Oktober</option>
                                                    <option value="November">November</option>
                                                    <option value="Desember">Desember</option>
                                                </select>

                                            </form>
                                        </div>
                                        <div class="col">
                                            <form id="filterForm">
                                                <select class="form-select" aria-label="Default select example" name="teacherFilter2" id="teacherFilter2">
                                                    <option value="">Pilih Guru</option>
                                                    <?php
                                                    foreach ($teachers as $teacher) {
                                                        echo "<option value='" . $teacher['nama'] . "'>" . $teacher['nama'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </div>
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
                                            <input class="form-control me-2" type="text" id="searchInput" placeholder="Ketikkan nama siswa..." aria-label="Search">
                                        </div>
                                        <div id="mainContent" class="mt-2">
                                            <!-- Display the filtered results here -->
                                        </div>
                                    </div>
                                </div>

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
            </main>

            <footer class="footer">
                <?php include '../template/footer.php'; ?>
            </footer>
        </div>
    </div>

    <script src="../../dist/js/app.js"></script>

    <script>
        function showAlert(input) {
            var value = input.value;
            if (value.includes("'")) {
                alert("Input jangan menggunakan tanda petik satu.");
                input.value = value.replace("'", "");
            }
        }
    </script>

    <script>
        var currentSearchTerm = ''; // Variable to store the current search term

        $(document).ready(function() {
            // Add event listener for teacherFilter change
            $('#teacherFilter2, #kelasFilter2, #bulanFilter2').change(function() {
                // Get the selected values from both filters
                var selectedTeacher = $('#teacherFilter2').val();
                var selectedKelas = $('#kelasFilter2').val();
                var selectedBulan = $('#bulanFilter2').val();

                // Call loadData with the selected values
                loadData(selectedTeacher, selectedKelas, selectedBulan, currentSearchTerm);
            });

            // Add event listener for searchInput keyup
            $('#searchInput').keyup(function() {
                var searchTerm = $(this).val();
                currentSearchTerm = searchTerm; // Update the current search term
                var selectedTeacher = $('#teacherFilter2').val();
                var selectedKelas = $('#kelasFilter2').val();
                var selectedBulan = $('#bulanFilter2').val();
                loadData(selectedTeacher, selectedKelas, selectedBulan, searchTerm);
            });

            // Initial load of data without specific filters
            loadData();

            function loadData(selectedTeacher, selectedKelas, selectedBulan, searchTerm) {
                $.ajax({
                    type: 'GET',
                    url: 'getData.php',
                    data: {
                        bulanFilter: selectedBulan,
                        teacherFilter: selectedTeacher,
                        kelasFilter: selectedKelas,
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
                var nama = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();
                var bulan = $(event.relatedTarget).closest("tr").find("td:eq(5)").text();
                var jilid = $(event.relatedTarget).closest("tr").find("td:eq(6)").text();
                var halaman = $(event.relatedTarget).closest("tr").find("td:eq(7)").text();
                var ketuntasan_tartil = $(event.relatedTarget).closest("tr").find("td:eq(8)").text();
                var juz = $(event.relatedTarget).closest("tr").find("td:eq(9)").text();
                var surat = $(event.relatedTarget).closest("tr").find("td:eq(10)").text();
                var ketuntasan_tahfizh = $(event.relatedTarget).closest("tr").find("td:eq(11)").text();
                var catatan = $(event.relatedTarget).closest("tr").find("td:eq(12)").text();

                $(this).find('#modal-edit').html($(
                    `
                <!-- Form edit -->
                    <form method="post" class="updateData" action="updateData.php" id="formEdit">
                    
                    <input type="hidden" name="id" value="${id}">
                    <input type="hidden" name="bulan" value="${bulan}">

                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="nama" name="nama" value="${nama}" required>
                        <label for="nama">Nama Siswa</label>
                    </div>

                    <div class="form-floating mb-2">
                        <select class="form-select" id="jilid" name="jilid" required>
                            <option selected>${jilid}</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="Al Quran">Al Quran</option>
                            <option value="Ghorib">Ghorib</option>
                            <option value="Tajwid">Tajwid</option>
                            <option value="Turjuman A">Turjuman A</option>
                            <option value="Turjuman B">Turjuman B</option>
                            <option value="KBQ">KBQ</option>
                        </select>
                        <label for="jilid">Capaian Jilid</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="halaman" name="halaman" value="${halaman}" required>
                        <label for="halaman">Capaian Halaman</label>
                    </div>

                    <div class="form-floating mb-2">
                        <select class="form-select" id="ketuntasan_tartil" name="ketuntasan_tartil" required>
                            <option selected>${ketuntasan_tartil}</option>
                            <option value="Tuntas">Tuntas</option>
                            <option value="Belum Tuntas">Belum Tuntas</option>
                        </select>
                        <label for="ketuntasan_tartil">Ketuntasan Tartil</label>
                    </div>

                    <div class="form-floating mb-2">
                        <select class="form-select" id="juz" name="juz" required>
                            <option selected>${juz}</option>
                            <?php
                            for ($i = 1; $i <= 30; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                        <label for="juz">Capaian Juz Hafalan</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="surat" oninput='showAlert(this)' name="surat" value="${surat}">
                        <label for="surat">Capaian Surat/Ayat Hafalan</label>
                    </div>

                    <div class="form-floating mb-2">
                        <select class="form-select" id="ketuntasan_tahfizh" name="ketuntasan_tahfizh" required>
                            <option selected>${ketuntasan_tahfizh}</option>
                            <option value="Tuntas">Tuntas</option>
                            <option value="Belum Tuntas">Belum Tuntas</option>
                        </select>
                        <label for="ketuntasan_tahfizh">Ketuntasan Tahfizh</label>
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

                    // Get the selected teacher and evaluasi before submit
                    var selectedBulan2 = $('#bulanFilter2').val();
                    var selectedTeacher2 = $('#teacherFilter2').val();
                    var selectedkelas2 = $('#kelasFilter2').val();
                    var searchTerm = $('#searchInput').val(); // assuming this is the search input

                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#editData').modal('hide');

                            // Call loadData with the selected teacher and evaluasi after successful edit
                            loadData(selectedBulan2, selectedTeacher2, selectedkelas2, searchTerm);

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

        });
    </script>



</body>

</html>