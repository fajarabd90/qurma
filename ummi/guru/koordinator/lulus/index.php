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
    <title>Lulus Munaqosyah</title>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Lulus Munaqosyah</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Peserta Lulus</h5>

                                    <div class="ms-auto d-flex align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#addData">
                                            <i data-feather="edit"></i> Catat Hasil
                                        </button>
                                        <a class="btn btn-success btn-sm rounded-pill dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 5px;">Lainnya</i></a>
                                        <ul class="dropdown-menu bg-success" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item text-white" href="pengumuman.php" target="_blank"><i class="fas fa-print"></i> Print Pengumuman Lulus</a></li>
                                            <li><a class="dropdown-item text-white" href="../munaqosyah/index.php"><i class="fa fa-arrow-circle-left"></i> Kembali Ke Data</a></li>
                                        </ul>

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

                                <div class="card-body py-3">
                                    <input style="margin-top: -20px;" class="form-control me-2 mb-2" type="text" id="searchInput" placeholder="Filter nama siswa..." aria-label="Search">
                                    <div id="mainContent"></div>
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

            $('#editData').modal({
                keyboard: true,
                backdrop: "static",
                show: false,

            }).on("show.bs.modal", function(event) {
                var button = $(event.relatedTarget);
                var id = $(event.relatedTarget).closest("tr").find("td:eq(0)").text();
                var id_tes = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();
                var nama = $(event.relatedTarget).closest("tr").find("td:eq(3)").text();
                var kategori = $(event.relatedTarget).closest("tr").find("td:eq(5)").text();
                var keterangan_mun = $(event.relatedTarget).closest("tr").find("td:eq(6)").text();

                $(this).find('#modal-edit').html($(
                    `
                <!-- Form edit -->
                    <form method="post" class="updateData" action="updateData.php" id="formEdit">
                    
                        <input type="hidden" name="id" value="${id}">
                        <input type="hidden" name="id_tes" value="${id_tes}">

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="nama" name="nama" value="${nama}" required>
                            <label for="nama">Nama</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="kategori" value="${kategori}" disabled readonly>
                            <label for="kategori">Kategori</label>
                        </div>

                        <div class="form-floating mb-2">
                                <select class="form-select" id="keterangan_mun" name="keterangan_mun" required>
                                    <option selected>${keterangan_mun}</option>
                                    <option value="Belum">Belum</option>
                                    <option value="Lulus">Lulus</option>
                                </select>
                                <label for="keterangan_mun">Keterangan</label>
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