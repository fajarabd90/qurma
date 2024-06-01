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

$tahun_ajaran = $conn_pdo->prepare("SELECT * FROM `tahun_ajaran`");
$tahun_ajaran->execute();
$tahun_ajaran = $tahun_ajaran->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Dan Nilai Fashohah-Tartil | QurMa</title>
    <link rel="shortcut icon" href="../../assets/img/logo.png" />
    <!-- Menggunakan Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            /* Lebar container penuh */
            max-width: 330mm;
            /* Lebar maksimum */
            height: 100vh;
            /* Tinggi container penuh */
            justify-content: center;
            /* Memusatkan horizontal */
            align-items: center;
            /* Memusatkan vertikal */
            padding: 10px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table.no-margin {
            margin-bottom: 0px;
        }

        tr.custom-border {
            border: none;
        }

        tr.custom-border th,
        tr.custom-border td {
            border: 1px solid black;
            /* You can customize the border color */
            border-collapse: collapse;
            text-align: center;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- HTML untuk tampilan setiap kelas -->
        <div class="title">DAFTAR HADIR & PENILAIAN PEMBELAJARAN AL-QUR'AN METODE UMMI - <?= $lembaga; ?></div>

        <div class="card-body">

            <table class="no-margin">
                <tr>
                    <td>T.A. : <?= $tahun_ajaran['tahun_ajaran']; ?></td>
                    <td style="text-align: center;">Semester : ....</td>
                    <td style="text-align: end;">Bulan : ....</td>
                </tr>
            </table>

            <table style="margin-bottom: 5px;">
                <tr class="custom-border">
                    <th style="width: 366px; text-align: left;">Tanggal</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="custom-border">
                    <th style="width: 352px; text-align: left;">Peraga/Surat & Ayat</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <table style="margin-bottom: 10px;">
                <thead>
                    <tr class="custom-border" style="text-align: center;">
                        <th style="width: 15px;">No</th>
                        <th style="width: 15px;">Kls</th>
                        <th style="width: 240px;">Nama Siswa</th>
                        <th style="width: 80px;">Jilid</th>
                        <th colspan="25">Halaman/Nilai untuk Jilid (Nilai saja untuk Al Quran)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 15; $i++) { ?>
                        <tr class="custom-border" style="height: 30px;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <center>
                <table class="no-margin" style="margin-bottom: 400px;">
                    <tr>
                        <td align="center">Koordinator Al Quran</td>
                        <td></td>
                        <td align="center">Guru</td>
                    </tr>
                    <tr style="visibility: hidden;">
                        <td>Oke</td>
                    </tr>
                    <tr style="visibility: hidden;">
                        <td>Oke</td>
                    </tr>
                    <tr>
                        <td align="center"><u>.......................................................</u></td>
                        <td></td>
                        <td align="center"><u>.......................................................</u></td>
                    </tr>
                </table>
            </center>
        </div>
    </div>



    <!-- Menggunakan Bootstrap 5 JS (opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>