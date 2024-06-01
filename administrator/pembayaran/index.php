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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pembayaran | QurMa</title>
    <link rel="shortcut icon" href="../../assets/img/logo.png" />
    <link href="../../dist/css/app.css" rel="stylesheet">
    <link href="../../dist/css/table.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="../index.php">
                    <span class="align-middle">QurMa (<?= $user['lembaga']; ?>)</span>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Pembayaran</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Pembayaran</h5>
                                    <div class="ms-auto d-flex align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addData">
                                            <i data-feather="plus-circle"></i> Tambah
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body py-3">
                                    <input style="margin-top: -20px;" class="form-control me-2 mb-2" type="search" id="searchInput" placeholder="Search..." aria-label="Search">
                                    <div id="mainContent"></div>

                                    <!-- Modal tambah-->
                                    <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-plus"></i> Tambah Data</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <!-- Form tambah -->
                                                    <form method="post" action="insertData.php" id="formTambah">

                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="lembaga" name="lembaga" required>
                                                            <label for="lembaga">Nama Lembaga</label>
                                                        </div>

                                                        <div class="form-floating mb-2">
                                                            <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar" required>
                                                            <label for="tgl_bayar">Tanggal Bayar</label>
                                                        </div>

                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="metode_bayar" name="metode_bayar" required>
                                                            <label for="metode_bayar">Metode Bayar</label>
                                                        </div>

                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="jumlah" name="jumlah" required>
                                                            <label for="jumlah">Jumlah Bayar</label>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
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
                });
            }

            $('#formTambah').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        $('[type=text]').val('');
                        $('[type=date]').val('');
                        $('#addData').modal('hide');
                        loadData();

                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan.',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }
                });
            });

            $('#editData').modal({
                keyboard: true,
                backdrop: "static",
                show: false,

            }).on("show.bs.modal", function(event) {
                var button = $(event.relatedTarget);
                var id = $(event.relatedTarget).closest("tr").find("td:eq(0)").text();
                var lembaga = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();
                var tgl_bayar = $(event.relatedTarget).closest("tr").find("td:eq(3)").text();
                var metode_bayar = $(event.relatedTarget).closest("tr").find("td:eq(5)").text();
                var jumlah = $(event.relatedTarget).closest("tr").find("td:eq(6)").text();

                $(this).find('#modal-edit').html($(
                    `
                <!-- Form edit -->
                    <form method="post" class="updateData" action="updateData.php" id="formEdit">
                    
                        <input type="hidden" name="id" value="${id}">

                        <div class="form-floating mb-2">
                            <input type="text" value="${lembaga}" class="form-control" id="lembaga" name="lembaga" required>
                            <label for="lembaga">Nama Lembaga</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="date" value="${tgl_bayar}" class="form-control" id="tgl_bayar" name="tgl_bayar" required>
                            <label for="tgl_bayar">Tanggal Bayar</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="text" value="${metode_bayar}" class="form-control" id="metode_bayar" name="metode_bayar" required>
                            <label for="metode_bayar">Metode Bayar</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="text" value="${jumlah}" class="form-control" id="jumlah" name="jumlah" required>
                            <label for="jumlah">Jumlah Bayar</label>
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

    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var toggleButton = document.getElementById("togglePassword");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.innerHTML = "<i class='far fa-eye-slash'></i>";
            } else {
                passwordField.type = "password";
                toggleButton.innerHTML = "<i class='far fa-eye'></i>";
            }
        }

        function togglePasswordVisibilityEdit() {
            var passwordField = document.getElementById("passwordEdit");
            var toggleButton = document.getElementById("togglePasswordEdit");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.innerHTML = "<i class='far fa-eye-slash'></i>";
            } else {
                passwordField.type = "password";
                toggleButton.innerHTML = "<i class='far fa-eye'></i>";
            }
        }
    </script>


</body>

</html>