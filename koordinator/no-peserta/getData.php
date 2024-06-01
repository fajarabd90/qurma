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

$sql = mysqli_query($conn, "SELECT nomor.id, nomor.id_tes, pra_munaqosyah.lembaga, nomor.nama, pra_munaqosyah.kelas, pra_munaqosyah.kategori, nomor.nomor
FROM nomor
LEFT JOIN pra_munaqosyah ON nomor.id_tes = pra_munaqosyah.id_tes
WHERE pra_munaqosyah.lembaga = '$lembaga' AND nomor.nama LIKE '%$searchTerm%' 
ORDER BY pra_munaqosyah.kategori, pra_munaqosyah.kelas, nomor.nama ASC");
?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark" id="example">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Kategori</th>
                <th scope="col">No. Peserta</th>
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
                    <td style="display:none;"><?php echo $data['id_tes']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td>
                        <?php echo $data['kategori']; ?>
                        <?php if (!empty($data['juz'])) : ?>
                            Juz <?php echo $data['juz']; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $data['nomor']; ?></td>
                    <td><?php echo "<center>$link_update</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>