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
    <title>Cetak Kartu Munaqosyah Tahfizh</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">
    <style>
        .nametag-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
            /* Atur jarak antar nametag */
        }

        .nametag {
            position: relative;
            width: 243px;
            /* Sesuaikan lebar sesuai kebutuhan Selisih 77*/
            height: 330px;
            /* Sesuaikan tinggi sesuai kebutuhan */
            background-image: url('../../assets/img/kartu-tahfizh.png');
            /* Ganti dengan path gambar latar belakang */
            background-size: contain;
            /* Mengunci ukuran gambar */
            background-position: center;
            /* Menengahkan gambar */
            text-align: center;
            padding: 0px;
            box-sizing: border-box;
            margin-bottom: 5px;
            /* Sesuaikan jarak antar nametag */
            font-weight: bold;
            /* Menjadikan teks tebal */
        }


        .nametag-info {
            margin-top: 40px;
            /* Geser ke bawah */
        }

        .nametag p {
            margin: 0;
            /* Hilangkan margin bawaan */
            color: black;
            /* Warna teks */
            font-size: 12px;
            /* Ukuran font */
        }
    </style>
</head>

<body>
    <div class="nametag-container">
        <?php
        // Mengambil data siswa dari database
        $query = "SELECT pra_munaqosyah.lembaga, nomor.nama, nomor.nomor, pra_munaqosyah.kategori, pra_munaqosyah.kelas
        FROM nomor
        INNER JOIN pra_munaqosyah ON nomor.id_tes = pra_munaqosyah.id_tes
        WHERE pra_munaqosyah.lembaga = '$lembaga' AND pra_munaqosyah.kategori LIKE 'Tahfizh%' ORDER BY pra_munaqosyah.kelas, nomor.nama ASC";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>

            <div class="nametag">

                <div class="nametag-info">
                    <div style="display: flex; align-items: center;">
                        <img src="../../assets/img/logo.png" alt="" height="43" style="margin-right: 22px; margin-left: 10px; margin-top: -21px">
                        <p style="font-size: 15px; color: #088030; margin-top: 2px;">
                            <?php echo $row['kategori']; ?>
                        </p>
                    </div>

                    <p style="margin-left: 83px; text-align: left; margin-top: 17px;"><?= $row['nomor']; ?></p>
                    <p style="margin-left: 83px; text-align: left; margin-top: -2px; display: flex; align-items: center; width: 150px; justify-content: left; height: 40px;">
                        <?= ucwords(strtolower($row['nama'])); ?>
                    </p>
                    <p style="margin-left: 83px; text-align: left; margin-top: -2px;"><?= $row['kelas']; ?></p>
                </div>
            </div>

        <?php
        }

        // Menutup koneksi
        mysqli_close($conn);
        ?>
    </div>
</body>

</html>