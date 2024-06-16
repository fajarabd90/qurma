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

date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu menjadi Waktu Indonesia Barat (WIB)

function tentukan_semester($bulan)
{
    if ($bulan >= 1 && $bulan <= 6) { // Januari sampai Juni
        return "Genap";
    } elseif ($bulan >= 7 && $bulan <= 12) { // Juli sampai Desember
        return "Ganjil";
    } else {
        return "Bulan tidak valid";
    }
}

$bulan_sekarang = intval(date('n')); // Ambil nomor bulan saat ini

// Mendapatkan tanggal saat ini
$tanggal = date("d");
// Mendapatkan nama bulan saat ini
$bulan = date("F");
// Mendapatkan tahun saat ini
$tahun = date("Y");

$sql = mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' ORDER BY kelas, nama ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Dan Nilai Tahfizh</title>
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
            font-size: 10px;
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
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- HTML untuk tampilan setiap kelas -->
        <div class="title">DAFTAR HADIR & PENILAIAN PEMBELAJARAN TAHFIZH AL-QUR'AN METODE UMMI - <?= $lembaga; ?></div>

        <div class="card-body">

            <table class="no-margin">
                <tr>
                    <td>T.A. : <?= $tahun_ajaran['tahun_ajaran']; ?></td>
                    <td style="text-align: center;">Semester : <?php echo tentukan_semester($bulan_sekarang); ?></td>
                    <td style="text-align: center;">Bulan : <?= $bulan ?></td>
                    <td style="text-align: end;">Jilid : ..............</td>
                </tr>
            </table>

            <table style="margin-bottom: 10px;">
                <thead>
                    <tr class="custom-border" style="height: 15px;">
                        <th colspan="4" style="text-align: left;">Tanggal</th>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                    </tr>
                    <tr class="custom-border" style="height: 15px;">
                        <th colspan="4" style="text-align: left;">Muroja'ah Ba'id</th>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="height: 10px;"></td>
                    </tr>
                    <tr class="custom-border" style="text-align: center;">
                        <th style="width: 15px;">No</th>
                        <th style="width: 15px;">Kls</th>
                        <th style="width: 240px;">Nama Siswa</th>
                        <th style="width: 15px;">Juz</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 15; $i++) { ?>
                        <tr class="custom-border" style="height: 17px;">
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

            <table style="margin-bottom: 10px;">
                <thead>
                    <tr class="custom-border" style="height: 15px;">
                        <th colspan="4" style="text-align: left;">Tanggal</th>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                        <td colspan="2" style="width: 72px;"></td>
                    </tr>
                    <tr class="custom-border" style="height: 15px;">
                        <th colspan="4" style="text-align: left;">Muroja'ah Ba'id</th>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="height: 10px;"></td>
                    </tr>
                    <tr class="custom-border" style="text-align: center;">
                        <th style="width: 15px;">No</th>
                        <th style="width: 15px;">Kls</th>
                        <th style="width: 240px;">Nama Siswa</th>
                        <th style="width: 15px;">Juz</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                        <th style="width: 60px;">Surat</th>
                        <th style="width: 30px;">Ayat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 15; $i++) { ?>
                        <tr class="custom-border" style="height: 17px;">
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
        </div>
    </div>



    <!-- Menggunakan Bootstrap 5 JS (opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>