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

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT kelompok.id, siswa.lembaga, kelompok.nama, siswa.kelas, placement.jilid,  placement.halaman, placement.catatan, kelompok.guru
 FROM siswa
 INNER JOIN placement ON siswa.nama = placement.nama
 INNER JOIN kelompok ON kelompok.nama = placement.nama
 WHERE siswa.lembaga = '$lembaga' AND (siswa.kelas LIKE '%$searchTerm%' OR kelompok.nama LIKE '%$searchTerm%' OR kelompok.guru LIKE '%$searchTerm%') ORDER BY kelompok.guru, placement.jilid, siswa.kelas, kelompok.nama ASC");
?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark">
        <thead>
            <tr>
                <th style="display:none;">Id</th>
                <th scope="col">No</th>
                <th scope="col">Kelompok/Guru</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Jilid (Hasil Placement)</th>
                <th scope="col">Hal./ Surat/ Ayat (Hasil Placement)</th>
                <th scope="col">Catatan</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($sql)) {
                $link_update = "<a class='badge bg-warning rounded-pill mb-1 updateData' data-bs-toggle='modal' data-bs-target='#editData' href='updateData.php?id=" . $data['id'] . "'><i class='fas fa-edit'></i></a>";
            ?>
                <tr>
                    <td style="display:none;"><?php echo $data['id']; ?></td>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['guru']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td><?php echo $data['jilid']; ?></td>
                    <td><?php echo $data['halaman']; ?></td>
                    <td><?php echo $data['catatan']; ?></td>
                    <td><?php echo "<center>$link_update</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>