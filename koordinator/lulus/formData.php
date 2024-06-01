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
                    $query = "SELECT * FROM pra_munaqosyah
                    WHERE lembaga = '$lembaga' AND keterangan_pra = 'Lolos' AND kategori LIKE '$selectedKategori%'
                    ORDER BY kelas, nama ASC";
                    $result = mysqli_query($conn, $query);

                    if ($result) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td style='width: 5%;'><input type='text' class='form-control' name='id_tes[]' value='" . $row['id_tes'] . "'></td>";
                            echo "<td style='width: 22%;'><input type='text' class='form-control' name='nama[]' value='" . ucwords(strtolower($row['nama'])) . "' readonly></td>";
                            echo "<td style='width: 8%;'>" . $row['kelas'] . "</td>";
                            echo "<td style='width: 12%;'>
    <input type='text' class='form-control' name='kategori[]' value='" . htmlspecialchars($row['kategori'], ENT_QUOTES, 'UTF-8');
                            if (!empty($row['juz'])) {
                                echo " Juz " . htmlspecialchars($row['juz'], ENT_QUOTES, 'UTF-8');
                            }
                            echo "'></td>";

                            echo "<td style='width: 10%;'>

                            <select class='form-select' aria-label='Default select example' name='keterangan_mun[]'>
                                <option selected></option>
                                <option value='Lulus'>Lulus</option>
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