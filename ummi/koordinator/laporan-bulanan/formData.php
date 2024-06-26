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
    <select class="form-select mb-2" aria-label="Default select example" id='bulan-pilih'>
        <option value="">Pilih Bulan</option>
        <option value="Januari">Januari</option>
        <option value="Februari">Februari</option>
        <option value="Maret">Maret</option>
        <option value="April">April</option>
        <option value="Mei">Mei</option>
        <option value="Juni">Juni</option>
        <option value="Juli">Juli</option>
        <option value="Agustus">Agustus</option>
        <option value="September">September</option>
        <option value="Oktober">Oktober</option>
        <option value="November">November</option>
        <option value="Desember">Desember</option>
    </select>

    <div class="tableFixHead" style="height: 500px;">
        <table class="table table-bordered border-dark ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Capaian Jilid</th>
                    <th>Capaian Halaman/ Ayat</th>
                    <th>Ketuntasan Tartil</th>
                    <th>Capaian Juz Tahfizh</th>
                    <th>Capaian Surat/Ayat Tahfizh</th>
                    <th>Ketuntasan Tahfizh</th>
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

                            // Pastikan $data['nama'] telah didefinisikan sebelum digunakan
                            $namaValue = ucwords(strtolower($row['nama']));

                            echo "<td style='width: 23%;'>";
                            echo "<input type='text' class='form-control' name='nama[]' value='" . $namaValue . "'>";
                            echo "</td>";

                            echo "<td style='width: 5%;'>" . $row['kelas'] . "</td>";

                            echo "<td style='width: 14%; display: none;'>
                                <input type='hidden' class='bulan-input' name='bulan[]'>
                                <span class='bulan-display'></span>
                            </td>";

                            echo "<td style='width: 15%;'>
                                <select class='form-select' aria-label='Default select example' name='jilid[]' required>";
                            echo "<option selected>Pilih Jilid</option>";
                            echo "<option value='1'>1</option>";
                            echo "<option value='2'>2</option>";
                            echo "<option value='3'>3</option>";
                            echo "<option value='4'>4</option>";
                            echo "<option value='5'>5</option>";
                            echo "<option value='6'>6</option>";
                            echo "<option value='Al Quran'>Al Quran</option>";
                            echo "<option value='Ghorib'>Ghorib</option>";
                            echo "<option value='Tajwid'>Tajwid</option>";
                            echo "<option value='Tahfizh'>Tahfizh</option>";
                            echo "<option value='Turjuman'>Turjuman</option>";
                            echo "<option value='KBQ'>KBQ</option>";
                            echo "</select>
                            </td>";

                            echo "<td style='width: 8%;'><input type='text' class='form-control' name='halaman[]'></td>";
                            echo "<td style='width: 10%;'>
                                <select class='form-select' aria-label='Default select example' name='ketuntasan_tartil[]' required>";
                            echo "<option selected>Pilih Status</option>";
                            echo "<option value='Tuntas'>Tuntas</option>";
                            echo "<option value='Belum Tuntas'>Belum Tuntas</option>";
                            echo "</select>
                            </td>";
                            echo "<td style='width: 10%;'>
                                <select class='form-select' aria-label='Default select example' name='juz[]' required>";
                            echo "<option selected>Pilih Juz</option>";
                            for ($i = 1; $i <= 30; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            echo "</select>
                            </td>";
                            echo "<td style='width: 20%;'><input type='text' oninput='showAlert(this)' class='form-control' name='surat[]'></td>";
                            echo "<td style='width: 10%;'>
                                <select class='form-select' aria-label='Default select example' name='ketuntasan_tahfizh[]' required>";
                            echo "<option selected>Pilih Status</option>";
                            echo "<option value='Tuntas'>Tuntas</option>";
                            echo "<option value='Belum Tuntas'>Belum Tuntas</option>";
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

<script>
    document.getElementById('bulan-pilih').addEventListener('change', function() {
        var selectedBulan = this.value;
        var bulanInputs = document.querySelectorAll('.bulan-input');
        var bulanDisplays = document.querySelectorAll('.bulan-display');
        bulanInputs.forEach(function(input) {
            input.value = selectedBulan;
        });
        bulanDisplays.forEach(function(display) {
            display.textContent = selectedBulan;
        });
    });
</script>