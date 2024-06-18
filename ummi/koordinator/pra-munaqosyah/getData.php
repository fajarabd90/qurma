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

// Get the selected teacher from the AJAX request
$selectedKategori2 = isset($_GET['kategoriFilter2']) ? $_GET['kategoriFilter2'] : '';
$selectedKelas2 = isset($_GET['kelasFilter2']) ? $_GET['kelasFilter2'] : '';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT pra_munaqosyah.id, pra_munaqosyah.id_tes, siswa.lembaga, tes.nama, siswa.kelas, pra_munaqosyah.kategori, pra_munaqosyah.catatan, pra_munaqosyah.keterangan_pra, tes.keterangan
FROM tes
LEFT JOIN siswa ON tes.nama = siswa.nama
LEFT JOIN pra_munaqosyah ON tes.id = pra_munaqosyah.id_tes
WHERE siswa.lembaga = '$lembaga'
AND ('$selectedKategori2' = '' OR tes.kategori = '$selectedKategori2')
AND siswa.kelas LIKE '$selectedKelas2%'
AND tes.nama LIKE '%$searchTerm%'
AND tes.keterangan = 'Ke Pra Munaqosyah'
ORDER BY siswa.kelas, siswa.nama ASC");
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example td').each(function() {
            if ($(this).text() == 'Belum') {
                $(this).parent("tr").css('background-color', '#F1948A');
                $(this).parent("tr").find("td").css('color', 'white'); // Mengubah warna teks semua sel dalam baris
            }

            if ($(this).text() == 'Lolos') {
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
                <th scope="col">Catatan</th>
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
                    <td style="display:none;"><?php echo $data['lembaga']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td><?php echo $data['kategori']; ?></td>
                    <td><?php echo $data['catatan']; ?></td>
                    <td><?php echo $data['keterangan_pra']; ?></td>
                    <td><?php if (!empty($data['id'])) {
                            echo "<center>$link_update</center>";
                        } ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>