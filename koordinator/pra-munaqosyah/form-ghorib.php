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
    <title>Cetak Form Ghorib Pra Munaqosyah</title>
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
        <div class="title">DAFTAR NILAI GHORIB <br> PRA MUNAQOSAH AL-QUR'AN METODE UMMI <br> <?= $lembaga ?><br></div>

        <div class="card-body">
            <table class="mb-3">
                <thead>
                    <tr class="custom-border" style="background-color: yellow;">
                        <th scope="col" rowspan="3">No</th>
                        <th scope="col" rowspan="3">Nama</th>
                        <th scope="col" rowspan="3">Kls</th>
                        <th scope="col" colspan="10">Aspek Nilai</th>
                        <th scope="col" rowspan="3">Total Nilai</th>
                        <th scope="col" rowspan="3">Rata-rata</th>
                    </tr>
                    <tr class="custom-border" style="background-color: yellow;">
                        <th scope="col" colspan="2">Soal Ayat 1 (2)</th>
                        <th scope="col" colspan="2">Soal Ayat 2 (2)</th>
                        <th scope="col" colspan="2">Soal Ayat 3 (2)</th>
                        <th scope="col" colspan="4">Soal Evaluasi Ghorib</th>
                    </tr>
                    <tr class="custom-border" style="background-color: yellow;">
                        <th scope="col" style="width: 7%;">Kesalahan</th>
                        <th scope="col" style="width: 5%;">Nilai</th>
                        <th scope="col" style="width: 7%;">Kesalahan</th>
                        <th scope="col" style="width: 5%;">Nilai</th>
                        <th scope="col" style="width: 7%;">Kesalahan</th>
                        <th scope="col" style="width: 5%;">Nilai</th>
                        <th scope="col" style="width: 5%;">1</th>
                        <th scope="col" style="width: 5%;">2</th>
                        <th scope="col" style="width: 5%;">3</th>
                        <th scope="col" style="width: 5%;">4</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = mysqli_query($conn, "SELECT * FROM pra_munaqosyah WHERE lembaga = '$lembaga' AND kategori = 'Tartil' ORDER BY kelas, nama ASC");
                    while ($data = mysqli_fetch_assoc($sql)) {
                    ?>
                        <tr class="custom-border">
                            <td><?php echo $no++; ?></td>
                            <td style="text-align: left;"><?php echo ucwords(strtolower($data['nama'])); ?></td>
                            <td><?php echo $data['kelas']; ?></td>
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