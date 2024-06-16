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
    <title>Cetak Form Hafalan 1 Pra Munaqosyah</title>
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
        <div class="title">DAFTAR NILAI HAFALAN <br> PRA MUNAQOSAH AL-QUR'AN METODE UMMI <br> <?= $lembaga ?></div>

        <div class="card-body">
            <table class="mb-3">
                <thead>
                    <tr class="custom-border" style="background-color: yellow;">
                        <th scope="col" style="height: 50px;">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kls</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الفاتحة</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الناس</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الفلق</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الاخلاص</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">اللهب</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">النصر</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الكافرون</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الكوثر</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الماعون</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">قريش</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الفيل</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الهمزة</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">العصر</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">التكاثر</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">القارعة</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">العاديات</th>
                        <th scope="col" style="transform: rotate(-90deg); width: 4%;">الزلزلة</th>
                        <th scope="col">Total Nilai</th>
                        <th scope="col">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = mysqli_query($conn, "SELECT siswa.nama, siswa.kelas
                    FROM siswa
                    INNER JOIN tes ON siswa.nama = tes.nama
                    WHERE siswa.lembaga = '$lembaga' AND tes.kategori = 'Tartil' AND tes.keterangan = 'Ke Pra Munaqosyah' ORDER BY siswa.kelas, siswa.nama ASC");
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