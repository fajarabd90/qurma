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

$sql = mysqli_query($conn, "SELECT kelompok.id, siswa.lembaga, kelompok.nama, siswa.kelas, placement.jilid,  placement.halaman, placement.catatan, kelompok.guru
 FROM siswa
 INNER JOIN placement ON siswa.nama = placement.nama
 INNER JOIN kelompok ON kelompok.nama = placement.nama
 WHERE siswa.lembaga = '$lembaga' ORDER BY siswa.kelas, kelompok.nama ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cetak Pengumuman Kelompok</title>
    <link rel="shortcut icon" href="../../assets/img/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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

        table,
        td,
        th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 10px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">
            <img src="../../administrator/logo/img/<?= $lembaga ?>.png" alt="Logo Lembaga" height="80"><br><br> DAFTAR KELOMPOK KBM TAHSIN-TAHFIZH METODE UMMI <br> <?= $lembaga ?>
        </div>

        <div class="tableFixHead" style="height: 400px;">
            <table class="table table-bordered border-dark" id="example">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Kelompok/Guru</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($sql)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                            <td><?php echo $data['kelas']; ?></td>
                            <td><?php echo $data['guru']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>