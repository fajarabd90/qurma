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
    <title>Logo Lembaga | QurMa</title>
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4 mb-4">Ubah Foto Siswa</h1>
                    <div class="card mb-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <?php
                            // Ambil nama file dari parameter GET
                            if (isset($_GET['filename'])) {
                                $filename = $_GET['filename'];
                                $folder = "img/";
                                $fullPath = $folder . $filename;
                                $timestamp = time();

                                // Jika tombol "Save Changes" diklik
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['new_file'])) {
                                    $newFile = $_FILES['new_file']['name'];
                                    $newFileTmp = $_FILES['new_file']['tmp_name'];

                                    // Pindahkan file yang diunggah ke folder tujuan
                                    if (move_uploaded_file($newFileTmp, $folder . $newFile)) {
                                        // Ubah nama file lama dengan yang baru
                                        if (rename($fullPath, $folder . $newFile)) {
                                            // echo "Photo changed successfully!";
                                            // Ganti dengan SweetAlert
                                            echo '<script>';
                                            echo 'Swal.fire("Success", "Photo changed successfully!", "success");';
                                            echo '</script>';
                                            $filename = $newFile; // Update nama file
                                            $fullPath = $folder . $newFile; // Update path file
                                        } else {
                                            // echo "Failed to change photo.";
                                            // Ganti dengan SweetAlert
                                            echo '<script>';
                                            echo 'Swal.fire("Error", "Failed to change photo.", "error");';
                                            echo '</script>';
                                        }
                                    } else {
                                        // echo "Failed to upload new photo.";
                                        // Ganti dengan SweetAlert
                                        echo '<script>';
                                        echo 'Swal.fire("Error", "Failed to upload new photo.", "error");';
                                        echo '</script>';
                                    }
                                } ?>
                                <div class="profile-info">
                                    <i class="fas fa-edit me-1"></i>
                                    Ubah Foto: <?= $filename ?>
                                </div>
                                <a href="index.php"><button type="button" class="btn btn-sm btn-danger rounded-pill">
                                        <i class="fa fa-arrow-circle-left"></i>
                                    </button></a>
                        </div>

                        <div class="container mt-2 mb-2">
                            <div class="row justify-content-center">
                                <div class="col-md-4 order-md-first">
                                    <div style="text-align: center;">
                                        <img src='<?= $fullPath ?>?timestamp=<?= $timestamp ?>' alt='<?= $filename ?>' style='max-width: 180px; border: 2px solid grey; padding: 5px;'>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-circle	me-1"></i>Nama File foto yang diganti harus sama dengan nama File foto pengganti!
                                    </div>
                                    <form action="updateData.php?filename=<?= urlencode($filename) ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                                        <div class="mb-3">
                                            <label for="new_file" class="form-label">New File:</label>
                                            <input type="file" class="form-control" id="new_file" name="new_file" required>
                                            <div class="invalid-feedback">
                                                Please choose a file.
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php
                            } else {
                                echo "File not found.";
                            }

                    ?>

                    </div>
                </div>
            </main>

            <footer class="footer">
                <?php include '../template/footer.php'; ?>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../dist/js/app.js"></script>
</body>

</html>