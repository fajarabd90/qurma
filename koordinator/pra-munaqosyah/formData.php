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
?>


<form action="insertData.php" method="post">
    <div class="tableFixHead" style="height: 500px;">

        <table class="table table-bordered border-dark ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Kategori</th>
                    <th>Catatan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Get the selected teacher and class from the AJAX request
                $selectedKategori = isset($_POST['kategoriFilter']) ? $_POST['kategoriFilter'] : '';

                // Check if both teacher and class are selected
                if (!empty($selectedKategori)) {
                    // Query to retrieve student data from the database based on selected teacher and class
                    $query = "SELECT tes.id, siswa.lembaga, siswa.nama, siswa.kelas, tes.jilid, tes.juz, tes.keterangan, tes.kategori
                    FROM siswa
                    INNER JOIN tes ON siswa.nama = tes.nama
                    WHERE siswa.lembaga = '$lembaga' AND tes.keterangan = 'Ke Pra Munaqosyah' AND tes.kategori = '$selectedKategori'
                    ORDER BY siswa.kelas, siswa.nama ASC";
                    $result = mysqli_query($conn, $query);

                    if ($result) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td style='width: 5%; display: none;'><input type='text' class='form-control' name='lembaga[]' value='" . $row['lembaga'] . "'></td>";
                            echo "<td style='width: 5%;'><input type='text' class='form-control' name='id_tes[]' value='" . $row['id'] . "'></td>";
                            echo "<td style='width: 22%;'><input type='text' class='form-control' name='nama[]' value='" . ucwords(strtolower($row['nama'])) . "' readonly></td>";
                            echo "<td style='width: 8%;'><input type='text' class='form-control' name='kelas[]' value='" . $row['kelas'] . "'></td>";
                            echo "<td style='width: 12%;'>";
                            echo "<input type='text' class='form-control' name='kategori[]' value='" . $row['kategori'];
                            if (!empty($row['juz'])) {
                                echo " Juz " . $row['juz'];
                            }
                            echo "'>";
                            echo "</td>";

                            echo "<td style='width: 25%;'><input type='text' class='form-control' name='catatan[]'></td>";
                            echo "<td style='width: 10%;'>

                            <select class='form-select' aria-label='Default select example' name='keterangan_pra[]'>
                                <option selected></option>
                                <option value='Lolos'>Lolos</option>
                                <option value='Belum'>Belum</option>
                            </select>
                            
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Gagal mengambil data siswa dari database.";
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
        // Periksa jika ada pengiriman formulir POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Ambil nilai dari formulir
            $selectedKategori = isset($_POST['kategoriFilter']) ? $_POST['kategoriFilter'] : '';

            // Periksa apakah kedua guru dan kelas sudah dipilih
            if (!empty($selectedKategori)) {
        ?>
                <button type="submit" class="btn btn-primary col-12">Submit</button>
        <?php
            }
        }
        ?>
    </div>
</form>