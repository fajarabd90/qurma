<?php
require '../../config.php';
session_start();
$id = $_SESSION['guru'];

if (!isset($id)) {
    header('location:../../index.php');
}

$user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
$lembaga = $user['lembaga'];
$guru = $user['nama'];

// Get the selected teacher from the AJAX request
$selectedBulan = isset($_GET['bulanFilter']) ? $_GET['bulanFilter'] : '';
$selectedKelas = isset($_GET['kelasFilter']) ? $_GET['kelasFilter'] : '';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT laporan.id, siswa.lembaga, laporan.nama, siswa.kelas, kelompok.guru, laporan.bulan, laporan.jilid, laporan.halaman, laporan.ketuntasan_tartil, laporan.juz, laporan.surat, laporan.ketuntasan_tahfizh
FROM siswa
INNER JOIN laporan ON siswa.nama = laporan.nama
INNER JOIN kelompok ON siswa.nama = kelompok.nama 
WHERE siswa.lembaga = '$lembaga' 
  AND ('$selectedBulan' = '' OR laporan.bulan = '$selectedBulan') 
  AND kelompok.guru = '$guru'
  AND siswa.kelas LIKE '$selectedKelas%' 
  AND siswa.nama LIKE '%$searchTerm%'
ORDER BY siswa.kelas, laporan.nama ASC");

?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Guru</th>
                <th scope="col">Bulan</th>
                <th scope="col">Capaian Jilid</th>
                <th scope="col">Hal./ Ayat</th>
                <th scope="col">Ketuntasan Tartil</th>
                <th scope="col">Capaian Tahfizh Juz</th>
                <th scope="col">Surat/Ayat</th>
                <th scope="col">Ketuntasan Tahfizh</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($sql)) {
                $link_update = "<a class='badge bg-warning mb-1 rounded-pill updateData' data-bs-toggle='modal' data-bs-target='#editData' href='updateData.php?id=" . $data['id'] . "'><i class='fas fa-edit'></i></a>";
            ?>
                <tr>
                    <td style="display:none;"><?php echo $data['id']; ?></td>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td><?php echo $data['guru']; ?></td>
                    <td><?php echo $data['bulan']; ?></td>
                    <td><?php echo $data['jilid']; ?></td>
                    <td><?php echo $data['halaman']; ?></td>
                    <td><?php echo $data['ketuntasan_tartil']; ?></td>
                    <td><?php echo $data['juz']; ?></td>
                    <td><?php echo $data['surat']; ?></td>
                    <td><?php echo $data['ketuntasan_tahfizh']; ?></td>
                    <td><?php echo "<center>$link_update</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>