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

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT lulus.id, lulus.id_tes, siswa.lembaga, tes.nama, siswa.kelas, tes.juz, tes.kategori, lulus.keterangan_mun
FROM lulus
LEFT JOIN siswa ON lulus.nama = siswa.nama
LEFT JOIN tes ON lulus.id_tes = tes.id
WHERE siswa.lembaga = '$lembaga' AND (tes.nama LIKE '%$searchTerm%' OR siswa.kelas LIKE '%$searchTerm%' OR tes.kategori LIKE '%$searchTerm%') 
ORDER BY siswa.kelas, tes.nama ASC");
?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark" id="example">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Kategori</th>
                <th scope="col">Keterangan</th>
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
                    <td style="display:none;"><?php echo $data['lembaga']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td>
                        <?php echo $data['kategori']; ?>
                        <?php if (!empty($data['juz'])) : ?>
                            Juz <?php echo $data['juz']; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $data['keterangan_mun']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>