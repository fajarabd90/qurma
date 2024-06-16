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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Form Juz Lainnya Pra Munaqosyah</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">
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

        tr.custom-border {
            border: none;
        }

        tr.custom-border th,
        tr.custom-border td {
            border: 1px solid black;
            /* You can customize the border color */
            border-collapse: collapse;
            text-align: center;
            padding: 10px;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">DAFTAR NILAI HAFALAN JUZ .... <br> PRA MUNAQOSAH AL-QUR'AN METODE UMMI <br> <?= $lembaga ?></div>

        <div class="card-body">
            <table class="mb-3">
                <thead>
                    <tr class="custom-border" style="background-color: yellow;">
                        <th scope="col" style="height: 100px;">No</th>
                        <th scope="col" style="width: 500px;">Nama</th>
                        <th scope="col">Kls</th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col" style="width: 6%;"></th>
                        <th scope="col">Total Nilai</th>
                        <th scope="col">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 1; $i <= 15; $i++) {
                        echo '<tr class="custom-border">';
                        echo '<td style="height: 25px;"></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

            </table>

            <div style="column-count: 2;">
                <center>
                    <p style="margin-top: -2px;"><br> Mengesahkan, <br> Koordinator Al Quran<br><br><br> <u>...................................</u></p>
                    <p> ................., ............................................... <br><br> Penguji <br><br><br> <u>...................................</u></p>
                </center>
            </div>

        </div>
    </div>

    <!-- Menggunakan Bootstrap 5 JS (opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>