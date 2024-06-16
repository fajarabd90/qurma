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
    <title>Logo Lembaga</title>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Logo Lembaga</h1>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Logo</h5>
                                    <div class="ms-auto d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadedPhotosModal">
                                            <i class="fa fa-download"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body py-3">
                                    <!-- Modal -->
                                    <div class="modal fade" id="uploadedPhotosModal" tabindex="-1" aria-labelledby="uploadedPhotosModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadedPhotosModalLabel">Upload Foto</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Form untuk mengunggah foto -->
                                                    <form action="insertData.php" method="post" enctype="multipart/form-data" id="uploadFormModal">
                                                        <div class="mb-3">
                                                            <label for="uploadInputModal" class="form-label">Pilih Foto:</label>
                                                            <input type="file" class="form-control" id="uploadInputModal" name="files[]" multiple>
                                                            <small id="fileHelp" class="form-text text-muted">Anda dapat memilih maksimal 20 file foto.</small>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" name="submit">Upload</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="album py-3 bg-light" style="margin-top: -20px;">
                                        <div class="container">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3">
                                                <?php
                                                // Loop through the photos in the folder and display them
                                                $folder = "img/"; // Your photo folder path
                                                $files = scandir($folder);
                                                foreach ($files as $file) {
                                                    if ($file !== '.' && $file !== '..') {
                                                ?>
                                                        <div class="col">
                                                            <div class="card shadow-sm">
                                                                <img src="<?php echo $folder . $file; ?>" class="card-img-top" alt="<?php echo $file; ?>">
                                                                <div class="card-body">
                                                                    <p class="card-text"><?php echo $file; ?></p>
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="btn-group">
                                                                            <a href="updateData.php?filename=<?php echo urlencode($file); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="hapusFoto('<?php echo urlencode($file); ?>')"><i class="fas fa-trash"></i></button>
                                                                            <a href="<?php echo $folder . $file; ?>" download="<?php echo $file; ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
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
        function hapusFoto(filename) {
            if (confirm("Apakah Anda yakin ingin menghapus foto ini?")) {
                // Mengirimkan permintaan AJAX ke skrip PHP penghapusan
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "deleteData.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Memperbarui halaman setelah penghapusan berhasil
                        location.reload();
                    }
                };
                xhr.send("filename=" + filename);
            }
        }
    </script>

    <script>
        // Fungsi untuk memeriksa jumlah file yang dipilih sebelum mengirim formulir
        document.getElementById("uploadFormModal").addEventListener("submit", function(event) {
            var files = document.getElementById("uploadInputModal").files;
            if (files.length > 20) {
                alert("Anda hanya dapat mengunggah maksimal 20 file foto.");
                event.preventDefault(); // Mencegah formulir untuk di-submit
            }
        });
    </script>
</body>

</html>