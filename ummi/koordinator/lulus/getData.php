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

$sql = mysqli_query($conn, "SELECT lulus.id, lulus.id_tes, siswa.lembaga, lulus.nama, siswa.kelas, lulus.kategori, lulus.keterangan_mun
FROM lulus
LEFT JOIN siswa ON lulus.nama = siswa.nama
WHERE siswa.lembaga = '$lembaga' AND lulus.nama LIKE '%$searchTerm%' 
ORDER BY siswa.kelas, lulus.nama ASC");
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example td').each(function() {
            if ($(this).text() == 'Belum') {
                $(this).parent("tr").css('background-color', '#F1948A');
                $(this).parent("tr").find("td").css('color', 'white'); // Mengubah warna teks semua sel dalam baris
            }

            if ($(this).text() == 'Lulus') {
                $(this).parent("tr").css('background-color', '#ABEBC6');
                $(this).parent("tr").find("td").css('color', 'black'); // Mengubah warna teks semua sel dalam baris
            }
        });
    });
</script>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark" id="example">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Kategori</th>
                <th scope="col">Keterangan</th>
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
                    <td><?php echo $data['kategori']; ?></td>
                    <td><?php echo $data['keterangan_mun']; ?></td>
                    <td><?php echo "<center>$link_update</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>