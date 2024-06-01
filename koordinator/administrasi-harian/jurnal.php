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

$sql = mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' ORDER BY kelas, nama ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal | QurMa</title>
    <link rel="shortcut icon" href="../../assets/img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <div style="margin-left: 15px; margin-right: 15px;">

        <div class="title">JURNAL HARIAN PENGAJARAN METODE UMMI <br> <?= $lembaga; ?> <br> TAHUN AJARAN <?= $tahun_ajaran['tahun_ajaran']; ?></div>

        <table style="margin-bottom: 20px">
            <thead>
                <tr>
                    <td></td>
                    <td colspan="3">Kelas : ....</td>
                    <td colspan="3">Bulan : ....</td>
                    <td colspan="3">Jilid : ....</td>
                    <td colspan="3">Tempat : ....</td>
                </tr>
                <tr class="custom-border">
                    <th scope="col" rowspan="2">TM</th>
                    <th scope="col" rowspan="2">Tanggal</th>
                    <th scope="col" rowspan="2">Muroja'ah</th>
                    <th scope="col" colspan="2">Hafalan</th>
                    <th scope="col" colspan="3">UMMI/Al Quran</th>
                    <th scope="col" colspan="2">Ghorib/Tajwid</th>
                    <th scope="col" colspan="2">Turjuman/KBQ</th>
                    <th scope="col" rowspan="2">Paraf</th>
                </tr>
                <tr class="custom-border">
                    <th scope="col">Surat</th>
                    <th scope="col">Ayat</th>
                    <th scope="col">Jilid/Surat</th>
                    <th scope="col">Hal/Ayat</th>
                    <th scope="col">Juz</th>
                    <th scope="col">Hal</th>
                    <th scope="col">Materi</th>
                    <th scope="col">Hal</th>
                    <th scope="col">Materi</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 25; $i++) { ?>
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
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <center>
            <table class="no-margin">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>