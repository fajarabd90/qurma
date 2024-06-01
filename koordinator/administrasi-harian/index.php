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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header d-flex">
                                    <h5 class="card-title mb-0" style="font-size: 16px;">Daftar Administrasi</h5>
                                </div>

                                <div class="card-body py-3" style="margin-top: -20px;">
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
                                                    <td>Tata Cara Pembelajaran</td>
                                                    <td>
                                                        <a href="Tata Cara Pembelajaran.docx"><button type="button" class="btn btn-primary btn-sm rounded-pill">
                                                                <i data-feather="download"></i> Download
                                                            </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Jurnal Harian</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm rounded-pill" onclick="printJurnal()">
                                                            <i data-feather="printer"></i> Print
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Presensi dan Nilai Harian Fashohah-Tartil</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm rounded-pill" onclick="printTartil()">
                                                            <i data-feather="printer"></i> Print
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Presensi dan Nilai Harian Ghorib/Tajwid</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm rounded-pill" onclick="printGhorib()">
                                                            <i data-feather="printer"></i> Print
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Presensi dan Nilai Harian Tahfizh</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm rounded-pill" onclick="printTahfizh()">
                                                            <i data-feather="printer"></i> Print
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Presensi dan Nilai Harian Turjuman/KBQ</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm rounded-pill" onclick="printTurjuman()">
                                                            <i data-feather="printer"></i> Print
                                                        </button>
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
        function printJurnal() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('jurnal.php')
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

            fetch('fashohah-tartil.php')
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

            fetch('ghorib-tajwid.php')
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

        function printTahfizh() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('tahfizh.php')
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

        function printTurjuman() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';

            document.body.appendChild(iframe);

            fetch('turjuman-kbq.php')
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