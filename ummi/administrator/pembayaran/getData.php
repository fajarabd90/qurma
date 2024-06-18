<?php
include_once '../../config.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = mysqli_query($conn, "SELECT * FROM pembayaran WHERE lembaga LIKE '%$searchTerm%' ORDER BY lembaga ASC");
?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark">
        <thead>
            <tr>
                <th style="display:none;">Id</th>
                <th scope="col">No</th>
                <th scope="col">Lembaga</th>
                <th scope="col">Tanggal Bayar</th>
                <th scope="col">Metode Bayar</th>
                <th scope="col">Jumlah Bayar</th>
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
                    <td style="display:none;"><?php echo $data['tgl_bayar']; ?></td>
                    <td>
                        <?php
                        // Extract the datetime value from the row
                        $tanggal_asal = $data['tgl_bayar'];

                        // Mengubah format menggunakan strtotime() dan strftime()
                        $tanggal_dan_waktu = strftime("%A, %d %B %Y", strtotime($tanggal_asal));

                        // Array untuk mengganti nama hari
                        $hari_replace = array(
                            'Sunday' => 'Minggu',
                            'Monday' => 'Senin',
                            'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis',
                            'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu'
                        );

                        // Array untuk mengganti nama bulan
                        $bulan_replace = array(
                            'January' => 'Januari',
                            'February' => 'Februari',
                            'March' => 'Maret',
                            'April' => 'April',
                            'May' => 'Mei',
                            'June' => 'Juni',
                            'July' => 'Juli',
                            'August' => 'Agustus',
                            'September' => 'September',
                            'October' => 'Oktober',
                            'November' => 'November',
                            'December' => 'Desember'
                        );

                        // Mengganti nama hari dan bulan
                        $tanggal_dan_waktu = strtr($tanggal_dan_waktu, $hari_replace);
                        $tanggal_dan_waktu = strtr($tanggal_dan_waktu, $bulan_replace);

                        // Menampilkan tanggal dan waktu dalam format baru
                        echo "$tanggal_dan_waktu";
                        ?>
                    </td>
                    <td><?php echo $data['metode_bayar']; ?></td>
                    <td><?php echo $data['jumlah']; ?></td>
                    <td><?php echo "<center>$link_update $link_delete</center>"; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>