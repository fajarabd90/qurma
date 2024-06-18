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

$sql = mysqli_query($conn, "SELECT siswa.id, siswa.lembaga, siswa.nama, siswa.kelas, pra_munaqosyah.kategori, pra_munaqosyah.keterangan_pra,
siswa.jenis_kelamin, siswa.no_hp, siswa.alamat, siswa.tempat_lahir, siswa.tgl_lahir, siswa.ayah, siswa.ibu,
    CASE
        WHEN siswa.jenis_kelamin <> '' AND siswa.no_hp <> '' AND siswa.alamat <> '' AND siswa.tempat_lahir <> '' AND siswa.tgl_lahir <> '' AND siswa.ayah <> '' AND siswa.ibu <> '' THEN 'Lengkap'
        ELSE 'Belum Lengkap'
    END AS status_lengkap
FROM siswa
LEFT JOIN pra_munaqosyah ON siswa.nama = pra_munaqosyah.nama
WHERE siswa.lembaga = '$lembaga'
AND ('$selectedKategori2' = '' OR pra_munaqosyah.kategori = '$selectedKategori2')
AND pra_munaqosyah.kelas LIKE '$selectedKelas2%'
AND siswa.nama LIKE '%$searchTerm%'
AND pra_munaqosyah.keterangan_pra = 'Lolos'
ORDER BY siswa.kelas, siswa.nama ASC");
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example td').each(function() {
            if ($(this).text() == 'Belum Lengkap') {
                $(this).parent("tr").css('background-color', '#F1948A');
                $(this).parent("tr").find("td").css('color', 'white'); // Mengubah warna teks semua sel dalam baris
            }

            if ($(this).text() == 'Lengkap') {
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
                <th scope="col">JK</th>
                <th scope="col">No. HP Wali Peserta</th>
                <th scope="col">Alamat Peserta</th>
                <th scope="col">Tempat Lahir</th>
                <th scope="col">Tanggal Lahir</th>
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
                    <td style="display:none;"><?php echo $data['lembaga']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td><?php echo $data['kategori']; ?></td>
                    <td><?php echo $data['jenis_kelamin']; ?></td>
                    <td><?php echo $data['no_hp']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td><?php echo $data['tempat_lahir']; ?></td>
                    <td><?php echo $data['tgl_lahir']; ?></td>
                    <td style="display:none;"><?php echo $data['ayah']; ?></td>
                    <td style="display:none;"><?php echo $data['ibu']; ?></td>
                    <td><?php echo $data['status_lengkap']; ?></td>
                    <td><?php echo "<center>$link_update</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>