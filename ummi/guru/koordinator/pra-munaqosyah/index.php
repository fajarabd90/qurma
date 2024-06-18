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
    <title>Pra Munaqosyah</title>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Pra Munaqosyah</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Peserta Lolos</h5>

                                    <div class="ms-auto d-flex align-items-center">
                                        <a href="peserta.php" target="_blank"><button type="button" class="btn btn-primary btn-sm rounded-pill" style="margin-right: 5px;">
                                                <i data-feather="printer"></i> Peserta
                                            </button></a>
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#form">
                                            <i data-feather="printer"></i> Form Penilaian
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#addData">
                                            <i data-feather="edit"></i> Catat Hasil
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal tambah-->
                                <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-edit"></i> Catat Hasil</h1>
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

                                <div class="card-body" style="margin-top: -20px;">
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
                                                    <option value="">Pilih Kategori</option>
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

                                    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-print"></i> Cetak Form Penilaian Pra Munaqosyah</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <center>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                Form Pra Munaqosyah Tartil
                                                            </div>
                                                            <div class="card-body">
                                                                <a onclick="printFashohah()" class="btn btn-primary mb-2">Form Fashohah</a>
                                                                <a onclick="printTartil()" class="btn btn-primary mb-2">Form Tartil</a>
                                                                <a onclick="printGhorib()" class="btn btn-primary mb-2">Form Ghorib</a>
                                                                <a onclick="printTajwid()" class="btn btn-primary mb-2">Form Tajwid</a>
                                                                <a onclick="printHafalan1()" class="btn btn-primary mb-2">Form Hafalan 1</a>
                                                                <a onclick="printHafalan2()" class="btn btn-primary mb-2">Form Hafalan 2</a>
                                                            </div>
                                                        </div>
                                                    </center>

                                                    <center>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                Form Pra Munaqosyah Tahfizh
                                                            </div>
                                                            <div class="card-body">
                                                                <a onclick="printJuz30Tahfizh1()" class="btn btn-primary mb-2">Form Juz 30 (Tahfizh 1)</a>
                                                                <a onclick="printJuz30Tahfizh2()" class="btn btn-primary mb-2">Form Juz 30 (Tahfizh 2)</a>
                                                                <a onclick="printJuz30Tahfizh3()" class="btn btn-primary mb-2">Form Juz 30 (Tahfizh 3)</a>
                                                                <a onclick="printJuz30Tahfizh4()" class="btn btn-primary mb-2">Form Juz 30 (Tahfizh 4)</a>
                                                                <a onclick="printJuz29Tahfizh1()" class="btn btn-primary mb-2">Form Juz 29 (Tahfizh 1)</a>
                                                                <a onclick="printJuz29Tahfizh2()" class="btn btn-primary mb-2">Form Juz 29 (Tahfizh 2)</a>
                                                                <a onclick="printJuz28()" class="btn btn-primary mb-2">Form Juz 28</a>
                                                                <a onclick="printJuz1()" class="btn btn-primary mb-2">Form Juz 1</a>
                                                                <a onclick="printJuz2()" class="btn btn-primary mb-2">Form Juz 2</a>
                                                                <a onclick="printJuz3()" class="btn btn-primary mb-2">Form Juz 3</a>
                                                                <a onclick="printJuzLain()" class="btn btn-primary mb-2">Form Juz Lainnya (Tanpa nama siswa)</a>
                                                            </div>
                                                        </div>
                                                    </center>
                                                </div>
                                            </div>
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
                var id_tes = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();
                var lembaga = $(event.relatedTarget).closest("tr").find("td:eq(3)").text();
                var nama = $(event.relatedTarget).closest("tr").find("td:eq(4)").text();
                var kelas = $(event.relatedTarget).closest("tr").find("td:eq(5)").text();
                var kategori = $(event.relatedTarget).closest("tr").find("td:eq(6)").text();
                var catatan = $(event.relatedTarget).closest("tr").find("td:eq(7)").text();
                var keterangan_pra = $(event.relatedTarget).closest("tr").find("td:eq(8)").text();

                $(this).find('#modal-edit').html($(
                    `
                <!-- Form edit -->
                    <form method="post" class="updateData" action="updateData.php" id="formEdit">
                    
                        <input type="hidden" name="id" value="${id}">
                        <input type="hidden" name="id_tes" value="${id_tes}">
                        <input type="hidden" name="lembaga" value="${lembaga}">

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="nama" name="nama" value="${nama}" required>
                            <label for="nama">Nama</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="kelas" name="kelas" value="${kelas}" required>
                            <label for="kelas">Kelas</label>
                        </div>

                        <div class="form-floating mb-2">
                            <select class="form-select" id="kategori" name="kategori" required>
                                <?php $juzs = query("SELECT DISTINCT juz FROM tes ORDER BY juz ASC") ?>
                                <option selected>${kategori}</option>
                                <?php foreach ($juzs as $row) : ?>
                                    <option><?php
                                            if (empty($row["juz"])) {
                                                echo "Tartil";
                                            } else {
                                                echo "Tahfizh Juz " . $row["juz"];
                                            }
                                            ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="kategori">Kategori</label>
                        </div>

                        <div class="form-floating mb-2">
                        <textarea class="form-control" name="catatan" id="catatan" style="height: 120px">${catatan}</textarea>
                        <label for="catatan">Catatan</label>
                        </div>

                        <div class="form-floating mb-2">
                                <select class="form-select" id="keterangan_pra" name="keterangan_pra" required>
                                    <option selected>${keterangan_pra}</option>
                                    <option value="Belum">Belum</option>
                                    <option value="Lolos">Lolos</option>
                                </select>
                                <label for="keterangan_pra">Keterangan</label>
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

        function printFashohah() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-fashohah.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printTartil() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-tartil.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printGhorib() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-ghorib.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printTajwid() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-tajwid.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printHafalan1() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-hafalan1.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printHafalan2() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-hafalan2.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz30Tahfizh1() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz30-tahfizh1.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz30Tahfizh2() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz30-tahfizh2.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz30Tahfizh3() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz30-tahfizh3.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz30Tahfizh4() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz30-tahfizh4.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz29Tahfizh1() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz29-tahfizh1.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz29Tahfizh2() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz29-tahfizh2.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz28() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz28.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz1() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz1.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz2() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz2.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuz3() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juz3.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }

        function printJuzLain() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-juzLain.php')
                .then(response => response.text())
                .then(htmlContent => {
                    iframe.contentDocument.write(htmlContent);
                    iframe.contentDocument.close();

                    // Wait for content to load (adjust the delay as needed)
                    setTimeout(() => {
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 1000);
                })
                .catch(error => console.error('Error fetching content:', error));
        }
    </script>
</body>

</html>