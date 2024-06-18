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
    <title>Administrasi</title>
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

                    <h1 class="h1 mb-3" style="margin-top: -10px;">Administrasi</h1>

                    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-print"></i> Cetak Form Placement Tes</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <center>
                                        <div class="card">
                                            <div class="card-header">
                                                Pilih kelas yang ingin dicetak...
                                            </div>
                                            <div class="card-body">
                                                <button onclick="printKelas1()" class="btn btn-primary mb-2">Kelas 1</button>
                                                <button onclick="printKelas2()" class="btn btn-primary mb-2">Kelas 2</button>
                                                <button onclick="printKelas3()" class="btn btn-primary mb-2">Kelas 3</button>
                                                <button onclick="printKelas4()" class="btn btn-primary mb-2">Kelas 4</button>
                                                <button onclick="printKelas5()" class="btn btn-primary mb-2">Kelas 5</button>
                                                <button onclick="printKelas6()" class="btn btn-primary mb-2">Kelas 6</button>
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Administrasi</h5>
                                </div>

                                <div class="card-body py-3" style="margin-top: -10px;">
                                    <div class="tableFixHead" style="height: 400px;">
                                        <table class="table table-bordered border-dark">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Target</td>
                                                    <td>
                                                        <a href="Target Pembelajaran 1 Tahun.docx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Kalender Al Quran</td>
                                                    <td>
                                                        <a href="Kalender Akademik 1 Tahun.xlsx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Program Semester</td>
                                                    <td>
                                                        <a href="Program Semester.xlsx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Placement Tes</td>
                                                    <td>
                                                        <a href="Placement Tes.xlsx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>

                                                        <button class="btn btn-success btn-sm rounded-pill" style="margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#form"><i class="fas fa-print"></i> Print Terisi Nama Siswa</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Tata Cara Pembelajaran</td>
                                                    <td>
                                                        <a href="Tata Cara Pembelajaran.docx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Jurnal Harian</td>
                                                    <td>
                                                        <a href="jurnal.php" target="_blank"><button type="button" class="btn btn-success btn-sm rounded-pill">
                                                                <i data-feather="printer"></i> Print
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Presensi & Nilai Harian Tartil, Turjuman, KBQ</td>
                                                    <td>
                                                        <a href="fashohah-tartil.php" target="_blank"><button type="button" class="btn btn-success btn-sm rounded-pill">
                                                                <i data-feather="printer"></i> Print
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Presensi & Nilai Harian Ghorib/Tajwid</td>
                                                    <td>
                                                        <a href="ghorib-tajwid.php" target="_blank"><button type="button" class="btn btn-success btn-sm rounded-pill">
                                                                <i data-feather="printer"></i> Print
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Presensi & Nilai Harian Tahfizh</td>
                                                    <td>
                                                        <a href="tahfizh.php" target="_blank"><button type="button" class="btn btn-success btn-sm rounded-pill">
                                                                <i data-feather="printer"></i> Print
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Form Supervisi Guru</td>
                                                    <td>
                                                        <a href="Form Supervisi Guru.docx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                        <a href="Rubrik Penilaian Supervisi.docx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download Rubrik Penilaian
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>Form Pembinaan Rutin Pekanan</td>
                                                    <td>
                                                        <a href="Pembinaan Rutin Pekanan.xlsx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>Laporan Perkembangan Siswa</td>
                                                    <td>
                                                        <a href="Data Perkembangan Siswa.docx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
        function printKelas1() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-kelas1.php')
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

        function printKelas2() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-kelas2.php')
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

        function printKelas3() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-kelas3.php')
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

        function printKelas4() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-kelas4.php')
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

        function printKelas5() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-kelas5.php')
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

        function printKelas6() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('form-kelas6.php')
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