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
    <title>Kelompok</title>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Kelompok</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Data Kelompok</h5>
                                    <div class="ms-auto d-flex align-items-center">
                                        <button type="button" class="btn btn-primary rounded-pill btn-sm" data-bs-toggle="modal" data-bs-target="#addData" style="margin-right: 5px;"><i class="fas fa-edit me-1"></i>Tambah</button>
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#addMassal">
                                            <i data-feather="users"></i> Atur Kelompok
                                        </button>
                                        <button class="btn btn-sm btn-danger rounded-pill" id="hapusDataButton"><i class="fas fa-trash"></i> Reset</button>
                                    </div>
                                </div>

                                <div class="card-body py-3">
                                    <input style="margin-top: -20px;" class="form-control me-2 mb-2" type="text" id="searchInput" placeholder="Filter nama siswa, Guru atau kelas" aria-label="Search">
                                    <div id="mainContent"></div>

                                    <!-- Modal tambah-->
                                    <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-plus"></i> Tambah Siswa Ke Kelompok</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <!-- Form tambah -->
                                                    <form method="post" action="insertData.php" id="formTambah">

                                                        <?php $siswa = query("SELECT * FROM siswa WHERE lembaga = '$lembaga' ORDER BY nama ASC") ?>
                                                        <input class="form-control mb-2" list="datalistOptions" id="nama" placeholder="Nama Siswa" name="nama[]" required>
                                                        <datalist id="datalistOptions">
                                                            <?php foreach ($siswa as $row) : ?>
                                                                <option value="<?= $row["nama"]; ?>">
                                                                <?php endforeach; ?>
                                                        </datalist>

                                                        <div class="form-floating mb-2">
                                                            <select class="form-select" id="guru" name="guru[]" required>
                                                                <?php $guru = query("SELECT * FROM guru WHERE lembaga = '$lembaga' ORDER BY nama ASC") ?>
                                                                <option selected></option>
                                                                <?php foreach ($guru as $row) : ?>
                                                                    <option><?= $row["nama"]; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <label for="guru">Guru</label>
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

                                    <!-- Modal Massal-->
                                    <div class="modal fade" id="addMassal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-users"></i> Atur Kelompok</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <p class="me-3">Silahkan pilih Kelas terlebih dahulu:</p>
                                                        </div>
                                                        <!-- Add the filter form -->
                                                        <div class="row g-3">
                                                            <div class="col">
                                                                <form id="filterForm">
                                                                    <select class="form-select" aria-label="Default select example" name="kelasFilter" id="kelasFilter">
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
                                                            <div id="filteredResults" class="mt-2">
                                                                <!-- Display the filtered results here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir modal Massal -->

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
        $(document).ready(function() {
            // Add event listener for teacherFilter change
            $('#kelasFilter').change(function() {
                // Get the selected values from both filters
                var selectedKelas = $('#kelasFilter').val();

                // Call loadData with the selected values
                loadData(selectedKelas);
            });

            // Initial load of data without specific filters
            loadData();

            function loadData(selectedKelas) {
                $.ajax({
                    type: 'POST',
                    url: 'formData.php',
                    data: {
                        kelasFilter: selectedKelas
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
                        $('#nama').val('');
                        $('#guru').val('');
                        $('#addData').modal('hide');
                        loadData();

                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Proses berhasil, namun jika ada data nama siswa yang sama, data tidak bisa disimpan.',
                            showConfirmButton: false
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
                var nama = $(event.relatedTarget).closest("tr").find("td:eq(3)").text();
                var guru = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();

                $(this).find('#modal-edit').html($(
                    `
                <!-- Form edit -->
                    <form method="post" class="updateData" action="updateData.php" id="formEdit">
                    
                        <input type="hidden" name="id" value="${id}">

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="nama" name="nama" value="${nama}" required>
                            <label for="nama">Nama</label>
                        </div>

                        <div class="form-floating mb-2">
                            <select class="form-select" id="guru" name="guru[]" required>
                                <?php $guru = query("SELECT * FROM guru WHERE lembaga = '$lembaga' ORDER BY nama ASC") ?>
                                <option selected>${guru}</option>
                                <?php foreach ($guru as $row) : ?>
                                    <option><?= $row["nama"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="guru">Guru</label>
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