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
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jilid (Hasil Placement)</th>
                    <th>Hal./Surat/Ayat (Hasil Placement)</th>
                    <th>Catatan (Hasil Placement)</th>
                    <th>Guru</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Get the selected teacher and class from the AJAX request
                $selectedKelas = isset($_POST['kelasFilter']) ? $_POST['kelasFilter'] : '';

                // Check if both teacher and class are selected
                if (!empty($selectedKelas)) {
                    // Query to retrieve student data from the database based on selected teacher and class
                    $query = "SELECT siswa.lembaga, siswa.kelas, placement.nama, placement.jilid, placement.halaman, placement.catatan
                    FROM placement
                    INNER JOIN siswa ON placement.nama = siswa.nama
                    WHERE siswa.lembaga = '$lembaga' AND siswa.kelas LIKE '$selectedKelas%' ORDER BY placement.jilid, siswa.kelas, siswa.nama ASC";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $nomor = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td style='width: 5%;'>{$nomor}</td>";
                            echo "<td style='width: 22%;'><input type='text' class='form-control' name='nama[]' value='" . ucwords(strtolower($row['nama'])) . "' readonly></td>";
                            echo "<td style='width: 8%;'>" . $row['kelas'] . "</td>";
                            echo "<td style='width: 12%;'>" . $row['jilid'] . "</td>";
                            echo "<td style='width: 10%;'>" . $row['halaman'] . "</td>";
                            echo "<td style='width: 25%;'>" . $row['catatan'] . "</td>";

                            echo "<td style='width: 25%;'>
        <select class='form-select' name='guru[]' required>";

                            // Eksekusi query dan buat pilihan
                            $guru = query("SELECT * FROM guru WHERE lembaga = '$lembaga' ORDER BY nama ASC");
                            echo "<option selected></option>";
                            foreach ($guru as $row) {
                                echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                            }

                            echo "</select>
        </td>";


                            echo "</tr>";
                            $nomor++;
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
            $selectedKelas = isset($_POST['kelasFilter']) ? $_POST['kelasFilter'] : '';

            // Periksa apakah kedua guru dan kelas sudah dipilih
            if (!empty($selectedKelas)) {
        ?>
                <button type="submit" class="btn btn-primary col-12">Submit</button>
        <?php
            }
        }
        ?>
    </div>
</form>