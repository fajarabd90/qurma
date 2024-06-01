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

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT tes.id, siswa.lembaga, tes.waktu, tes.nama, siswa.kelas, tes.jilid, tes.juz, tes.surat, tes.nilai1, tes.nilai2, tes.nilai3, tes.catatan, tes.keterangan, tes.kategori
FROM tes
INNER JOIN siswa ON tes.nama = siswa.nama
INNER JOIN kelompok ON tes.nama = kelompok.nama
WHERE siswa.lembaga = '$lembaga' AND kelompok.guru = '$guru' AND (tes.nama LIKE '%$searchTerm%' OR tes.keterangan LIKE '%$searchTerm%') AND tes.kategori = 'Tartil' ORDER BY waktu DESC");
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

            if ($(this).text() == 'Ke Pra Munaqosyah') {
                $(this).parent("tr").css('background-color', '#3b7ddd');
                $(this).parent("tr").find("td").css('color', 'white'); // Mengubah warna teks semua sel dalam baris
            }
        });
    });
</script>



<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark" id="example">
        <thead>
            <tr>
                <th style="display:none;">Id</th>
                <th scope="col">No</th>
                <th scope="col">Hari/Tanggal</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Jilid</th>
                <th scope="col">Catatan</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($sql)) {
                $link_delete = "<a class='badge bg-danger rounded-pill mb-1 hapusData' href='deleteData.php?id=" . $data['id'] . "'><i class='fas fa-trash'></i></a>";
                $link_update = "<a class='badge bg-warning rounded-pill mb-1 updateData' data-bs-toggle='modal' data-bs-target='#editData' href='updateData.php?id=" . $data['id'] . "'><i class='fas fa-edit'></i></a>";
            ?>
                <tr>
                    <td style="display:none;"><?php echo $data['id']; ?></td>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['waktu']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td><?php echo $data['jilid']; ?></td>
                    <td style="display:none;"><?php echo $data['juz']; ?></td>
                    <td style="display:none;"><?php echo $data['surat']; ?></td>
                    <td style="display:none;"><?php echo $data['nilai1']; ?></td>
                    <td style="display:none;"><?php echo $data['nilai2']; ?></td>
                    <td style="display:none;"><?php echo $data['nilai3']; ?></td>
                    <td><?php echo $data['catatan']; ?></td>
                    <td><?php echo $data['keterangan']; ?></td>
                    <td style="display:none;"><?php echo $data['kategori']; ?></td>
                    <td><?php echo "<center>$link_update $link_delete</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>