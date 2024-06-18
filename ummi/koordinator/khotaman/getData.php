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

$sql = mysqli_query($conn, "SELECT siswa.lembaga, siswa.nama, siswa.kelas, lulus.kategori, lulus.keterangan_mun,
siswa.jenis_kelamin, siswa.ayah, siswa.ibu, siswa.tempat_lahir, siswa.tgl_lahir
FROM siswa
LEFT JOIN lulus ON siswa.nama = lulus.nama
WHERE siswa.lembaga = '$lembaga'
AND ('$selectedKategori2' = '' OR lulus.kategori = '$selectedKategori2')
AND siswa.kelas LIKE '$selectedKelas2%'
AND siswa.nama LIKE '%$searchTerm%'
AND lulus.keterangan_mun = 'Lulus'
ORDER BY siswa.kelas, siswa.nama ASC");
?>

<div class="tableFixHead" style="height: 400px;">
    <table class="table table-bordered border-dark" id="example">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Kategori</th>
                <th scope="col">TTL</th>
                <th scope="col">Bin/ti</th>
                <th scope="col">Ayah</th>
                <th scope="col">Ibu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($sql)) {
            ?>
                <tr>
                    <td style="display:none;"><?php echo $data['id']; ?></td>
                    <td><?php echo $no++; ?></td>
                    <td style="display:none;"><?php echo $data['lembaga']; ?></td>
                    <td><?php echo ucwords(strtolower($data['nama'])); ?></td>
                    <td><?php echo $data['kelas']; ?></td>
                    <td><?php echo $data['kategori']; ?></td>
                    <td>
                        <?php
                        echo htmlspecialchars($data['tempat_lahir']);

                        // Check if 'tgl_lahir' is set and in the correct format
                        if (isset($data['tgl_lahir']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['tgl_lahir'])) {
                            // Memisahkan tanggal, bulan, dan tahun
                            list($tahun, $bulan, $tanggal) = explode('-', $data['tgl_lahir']);

                            // Mengubah bulan dari angka menjadi nama bulan
                            $nama_bulan = '';
                            switch ($bulan) {
                                case '01':
                                    $nama_bulan = 'Januari';
                                    break;
                                case '02':
                                    $nama_bulan = 'Februari';
                                    break;
                                case '03':
                                    $nama_bulan = 'Maret';
                                    break;
                                case '04':
                                    $nama_bulan = 'April';
                                    break;
                                case '05':
                                    $nama_bulan = 'Mei';
                                    break;
                                case '06':
                                    $nama_bulan = 'Juni';
                                    break;
                                case '07':
                                    $nama_bulan = 'Juli';
                                    break;
                                case '08':
                                    $nama_bulan = 'Agustus';
                                    break;
                                case '09':
                                    $nama_bulan = 'September';
                                    break;
                                case '10':
                                    $nama_bulan = 'Oktober';
                                    break;
                                case '11':
                                    $nama_bulan = 'November';
                                    break;
                                case '12':
                                    $nama_bulan = 'Desember';
                                    break;
                            }

                            // Menampilkan hasil dengan tanda baca koma
                            echo ", " . htmlspecialchars("$tanggal $nama_bulan $tahun");
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        echo empty($data['jenis_kelamin']) ? '' : (($data['jenis_kelamin'] === 'L') ? 'Bin' : 'Binti');
                        ?>
                    </td>

                    <td><?php echo $data['ayah']; ?></td>
                    <td><?php echo $data['ibu']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>