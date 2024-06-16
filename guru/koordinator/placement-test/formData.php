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
                    <th>Jilid</th>
                    <th>Hal./Surat/Ayat</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Get the selected teacher and class from the AJAX request
                $selectedKelas = isset($_POST['kelasFilter']) ? $_POST['kelasFilter'] : '';

                // Check if both teacher and class are selected
                if (!empty($selectedKelas)) {
                    // Query to retrieve student data from the database based on selected teacher and class
                    $query = "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '$selectedKelas%' ORDER BY kelas, nama ASC";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $nomor = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td style='width: 5%;'>{$nomor}</td>";
                            echo "<td style='width: 30%;'><input type='text' class='form-control' name='nama[]' value='" . ucwords(strtolower($row['nama'])) . "'></td>";
                            echo "<td style='width: 15%;'>

                        <select class='form-select' aria-label='Default select example' name='jilid[]'>
                            <option selected></option>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='Al Quran'>Al Quran</option>
                            <option value='Ghorib'>Ghorib</option>
                            <option value='Tajwid'>Tajwid</option>
                            <option value='Tahfizh'>Tahfizh</option>
                            <option value='Turjuman'>Turjuman</option>
                            <option value='KBQ'>KBQ</option>
                        </select>
                        
                        </td>";

                            echo "<td style='width: 10%;'><input type='text' class='form-control' name='halaman[]'></td>";
                            echo "<td style='width: 40%;'><input type='text' class='form-control' name='catatan[]'></td>";
                            echo "<input type='hidden' class='form-control' name='guru[]'>";
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