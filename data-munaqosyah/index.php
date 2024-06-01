<?php
require '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Munaqosyah | QurMa</title>
    <link rel="shortcut icon" href="../assets/img/logo.png" />
    <link href="../dist/css/app.css" rel="stylesheet">
    <link href="../dist/css/table.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php">
                    <span class="align-middle">Data Munaqosyah</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="index.php">
                            <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">0</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    0 Notifications
                                </div>
                                <div class="list-group">

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Lengkapi Data</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Peserta</h5>
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

                                <?php
                                $lembagaQuery = mysqli_query($conn, "SELECT lembaga FROM pembayaran ORDER BY lembaga ASC");
                                $lembagas = mysqli_fetch_all($lembagaQuery, MYSQLI_ASSOC);
                                ?>

                                <div class="card-body py-3">
                                    <div class="row g-3 mb-2">
                                        <div class="col">
                                            <form id="filterForm">
                                                <select class="form-select" style="margin-top: -20px;" aria-label="Default select example" name="lembagaFilter" id="lembagaFilter">
                                                    <option value="">Pilih Lembaga</option>
                                                    <?php
                                                    foreach ($lembagas as $lembaga) {
                                                        echo "<option value='" . $lembaga['lembaga'] . "'>" . $lembaga['lembaga'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <input style="margin-top: -20px;" class="form-control me-2" type="search" id="searchInput" placeholder="Ketikkan nama siswa..." aria-label="Search">
                                        </div>
                                    </div>
                                    <div id="mainContent"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://qurma.site/" target="_blank">&copy; <strong>QurMa</strong> - 2024</a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-0">
                                <a class="text-muted" href="#">v1.0</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="../dist/js/app.js"></script>

    <script>
        var currentSearchTerm = ''; // Variable to store the current search term

        $(document).ready(function() {
            // Add event listener for lembagaFilter change
            $('#lembagaFilter').change(function() {
                // Get the selected values from both filters
                var selectedLembaga = $(this).val();

                // Call loadData with the selected values
                loadData(selectedLembaga, currentSearchTerm);
            });

            // Initial load of data without specific filters
            loadData();

            // Add event listener for searchInput keyup
            $('#searchInput').keyup(function() {
                var searchTerm = $(this).val();
                currentSearchTerm = searchTerm; // Update the current search term
                var selectedLembaga = $('#lembagaFilter').val();
                loadData(selectedLembaga, searchTerm);
            });


            function loadData(selectedLembaga, searchTerm) {
                // Check if selectedLembaga is empty
                if (!selectedLembaga) {
                    $("#mainContent").html("<p style='color: red; font-size: 16px; text-align: center;'>Pilih lembaga dan ketikkan nama siswa terlebih dahulu.</p>");
                    return; // Stop further execution
                }

                $.ajax({
                    url: 'getData.php',
                    type: 'GET',
                    data: {
                        lembagaFilter: selectedLembaga,
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
                var lembaga = $(event.relatedTarget).closest("tr").find("td:eq(2)").text();
                var nama = $(event.relatedTarget).closest("tr").find("td:eq(3)").text();
                var kelas = $(event.relatedTarget).closest("tr").find("td:eq(4)").text();
                var jenis_kelamin = $(event.relatedTarget).closest("tr").find("td:eq(5)").text();
                var no_hp = $(event.relatedTarget).closest("tr").find("td:eq(6)").text();
                var alamat = $(event.relatedTarget).closest("tr").find("td:eq(7)").text();
                var tempat_lahir = $(event.relatedTarget).closest("tr").find("td:eq(8)").text();
                var tgl_lahir = $(event.relatedTarget).closest("tr").find("td:eq(9)").text();
                var ayah = $(event.relatedTarget).closest("tr").find("td:eq(10)").text();
                var ibu = $(event.relatedTarget).closest("tr").find("td:eq(11)").text();

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

                    var selectedLembaga = $('#lembagaFilter').val();
                    var searchTerm = $('#searchInput').val();

                    // Display a confirmation dialog
                    Swal.fire({
                        title: 'Apakah data sudah benar?',
                        text: 'Setelah menyimpan, data tidak akan bisa dirubah.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, benar!',
                        cancelButtonText: 'Cek Lagi'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, proceed with form submission
                            $.ajax({
                                url: $(this).attr('action'),
                                type: $(this).attr('method'),
                                data: $(this).serialize(),
                                success: function(response) {
                                    $('#editData').modal('hide');
                                    loadData(selectedLembaga, searchTerm);
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Data berhasil diubah.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            });
                        }
                    });
                });



            }).on('hide.bs.modal', function(event) {
                $(this).find('#modal-edit').html("")
            })
        });

        function updateCharacterCount() {
            var input = document.getElementById("alamat");
            var characterCountElement = document.getElementById("characterCount");
            characterCountElement.textContent = input.value.length;
        }
    </script>
</body>

</html>