<?php
include_once '../../config.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga LIKE '%$searchTerm%' OR nama LIKE '%$searchTerm%' ORDER BY lembaga, kelas, nama ASC");
?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark">
        <thead>
            <tr>
                <th style="display:none;">Id</th>
                <th scope="col">No</th>
                <th scope="col">Lembaga</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
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
                    <td><?php echo $data['lembaga']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td style="display:none;"><?php echo $data['jenis_kelamin']; ?></td>
                    <td style="display:none;"><?php echo $data['no_hp']; ?></td>
                    <td style="display:none;"><?php echo $data['alamat']; ?></td>
                    <td style="display:none;"><?php echo $data['tempat_lahir']; ?></td>
                    <td style="display:none;"><?php echo $data['tanggal_lahir']; ?></td>
                    <td style="display:none;"><?php echo $data['kategori']; ?></td>
                    <td style="display:none;"><?php echo $data['no_peserta']; ?></td>
                    <td><?php echo "<center>$link_update $link_delete</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>