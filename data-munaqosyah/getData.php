<?php
require '../config.php';

$selectedLembaga = isset($_GET['lembagaFilter']) ? $_GET['lembagaFilter'] : '';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT siswa.id, siswa.lembaga, siswa.nama, siswa.kelas, pra_munaqosyah.kategori, pra_munaqosyah.keterangan_pra,
    siswa.jenis_kelamin, siswa.no_hp, siswa.alamat, siswa.tempat_lahir, siswa.tgl_lahir,  siswa.ayah,  siswa.ibu,
    CASE
        WHEN siswa.jenis_kelamin <> '' AND siswa.no_hp <> '' AND siswa.alamat <> '' AND siswa.tempat_lahir <> '' AND siswa.tgl_lahir <> '' AND siswa.ayah <> '' AND siswa.ibu <> '' THEN 'Lengkap'
        ELSE 'Belum lengkap'
    END AS status_lengkap
FROM siswa
LEFT JOIN pra_munaqosyah ON siswa.nama = pra_munaqosyah.nama
WHERE ('$selectedLembaga' = '' OR siswa.lembaga = '$selectedLembaga') AND pra_munaqosyah.nama LIKE '%$searchTerm%' AND pra_munaqosyah.keterangan_pra = 'Lolos'
GROUP BY siswa.id
ORDER BY pra_munaqosyah.kelas, pra_munaqosyah.nama ASC");


?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark" id="example">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;

            while ($data = mysqli_fetch_assoc($sql)) {
                $link_update = "<a class='badge bg-warning mb-1 rounded-pill updateData' data-bs-toggle='modal' data-bs-target='#editData' href='updateData.php?id=" . $data['id'] . "'><i class='fas fa-edit'></i></a>";
                $status_lengkap = $data['status_lengkap'];
            ?>
                <tr>
                    <td style="display:none;"><?php echo $data['id']; ?></td>
                    <td><?php echo $no++; ?></td>
                    <td style="display:none;"><?php echo $data['lembaga']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td style="display:none;"><?php echo $data['jenis_kelamin']; ?></td>
                    <td style="display:none;"><?php echo $data['no_hp']; ?></td>
                    <td style="display:none;"><?php echo $data['alamat']; ?></td>
                    <td style="display:none;"><?php echo $data['tempat_lahir']; ?></td>
                    <td style="display:none;"><?php echo $data['tgl_lahir']; ?></td>
                    <td style="display:none;"><?php echo $data['ayah']; ?></td>
                    <td style="display:none;"><?php echo $data['ibu']; ?></td>
                    <td><?php echo $data['status_lengkap']; ?></td>
                    <td>
                        <?php
                        if ($status_lengkap !== 'Lengkap') {
                            echo "<center>$link_update</center>";
                        }
                        ?>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>