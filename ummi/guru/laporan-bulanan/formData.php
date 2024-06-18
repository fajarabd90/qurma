<?php
require '../../config.php';
session_start();
$id = $_SESSION['guru'];

if (!isset($id)) {
    header('location:../../index.php');
}

$user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);
$lembaga = $user['lembaga'];
$guru = $user['nama'];
?>


<form action="insertData.php" method="post">

    <div class="tableFixHead" style="height: 500px;">
        <table class="table table-bordered border-dark ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Capaian Jilid <br>(<input type='checkbox' class='form-check-input' id='allJilid'> Sama Semua)</th>
                    <th>Capaian Halaman/ Ayat <br>(<input type='checkbox' class='form-check-input' id='allHalaman'> Sama Semua)</th>
                    <th>Ketuntasan Tartil <br>(<input type='checkbox' class='form-check-input' id='allTuntasTartil'> Tuntas Semua)</th>
                    <th>Capaian Juz Tahfizh <br>(<input type='checkbox' class='form-check-input' id='allJuz'> Sama Semua)</th>
                    <th>Capaian Surat/Ayat Tahfizh <br>(<input type='checkbox' class='form-check-input' id='allSurat'> Sama Semua)</th>
                    <th>Ketuntasan Tahfizh <br>(<input type='checkbox' class='form-check-input' id='allTuntasTahfizh'> Tuntas Semua)</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $selectedKelas = isset($_POST['kelasFilter']) ? $_POST['kelasFilter'] : '';

                if (!empty($selectedKelas)) {
                    // Query to retrieve student data from the database based on selected teacher and class
                    $query = "SELECT siswa.lembaga, siswa.nama, siswa.kelas, kelompok.guru
                FROM siswa
                INNER JOIN kelompok ON siswa.nama = kelompok.nama
                 WHERE lembaga = '$lembaga' AND guru = '$guru' AND kelas LIKE '$selectedKelas%' ORDER BY kelas, nama ASC";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $nomor = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td style='width: 5%;'>{$nomor}</td>";

                            // Pastikan $data['nama'] telah didefinisikan sebelum digunakan
                            $namaValue = ucwords(strtolower($row['nama']));

                            echo "<td style='width: 20%;'>";
                            echo "<input type='text' class='form-control' name='nama[]' value='" . $namaValue . "'>";
                            echo "</td>";

                            echo "<td style='width: 5%;'>" . $row['kelas'] . "</td>";

                            echo "<td style='display: none;'>
                            <input type='hidden' class='bulan-input' name='bulan[]'>
                            <span class='bulan-display'></span>
                        </td>";

                            echo "<td style='width: 10%;'>
                            <select class='form-select jilid' aria-label='Default select example' name='jilid[]' required>";
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

                            echo "<td style='width: 8%;'><input type='text' class='form-control halaman' name='halaman[]'></td>";
                            echo "<td style='width: 10%;'>
                            <select class='form-select ketuntasan_tartil' aria-label='Default select example' name='ketuntasan_tartil[]' required>";
                            echo "<option selected>Pilih Status</option>";
                            echo "<option value='Tuntas'>Tuntas</option>";
                            echo "<option value='Belum Tuntas'>Belum Tuntas</option>";
                            echo "</select>
                        </td>";
                            echo "<td style='width: 10%;'>
                            <select class='form-select juz' aria-label='Default select example' name='juz[]' required>";
                            echo "<option selected>Pilih Juz</option>";
                            for ($i = 1; $i <= 30; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            echo "</select>
                        </td>";
                            echo "<td style='width: 10%;'><input type='text' oninput='showAlert(this)' class='form-control surat' name='surat[]'></td>";
                            echo "<td style='width: 10%;'>
                            <select class='form-select ketuntasan_tahfizh' aria-label='Default select example' name='ketuntasan_tahfizh[]' required>";
                            echo "<option selected>Pilih Status</option>";
                            echo "<option value='Tuntas'>Tuntas</option>";
                            echo "<option value='Belum Tuntas'>Belum Tuntas</option>";
                            echo "</select>
                        </td>";
                            echo "<td style='width: 10%;'><input type='text' class='form-control' name='catatan[]'></td>";
                            echo "<td style='display: none;'><input type='text' class='form-control' name='guru[]' value='" . $guru . "'></td>";
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

    //Centang jilid

    document.getElementById('allJilid').addEventListener('change', function() {
        const allJilid = this.checked;
        const jilidElements = document.querySelectorAll('.jilid');

        if (allJilid && jilidElements.length > 0) {
            const firstJilidValue = jilidElements[0].value;
            jilidElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = firstJilidValue;
                }
            });
        } else {
            jilidElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = 'Pilih Jilid'; // Reset to default option
                }
            });
        }
    });

    document.querySelectorAll('.jilid').forEach((selectElement, index) => {
        selectElement.addEventListener('change', function() {
            if (index === 0 && document.getElementById('allJilid').checked) {
                const firstJilidValue = this.value;
                document.querySelectorAll('.jilid').forEach((el, idx) => {
                    if (idx !== 0) { // Skip the first element
                        el.value = firstJilidValue;
                    }
                });
            }
        });
    });

    //Centang halaman

    document.getElementById('allHalaman').addEventListener('change', function() {
        const allHalaman = this.checked;
        const halamanElements = document.querySelectorAll('.halaman');

        if (allHalaman && halamanElements.length > 0) {
            const firstHalamanValue = halamanElements[0].value;
            halamanElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = firstHalamanValue;
                }
            });
        } else {
            halamanElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = ''; // Reset to default option
                }
            });
        }
    });

    document.querySelectorAll('.halaman').forEach((selectElement, index) => {
        selectElement.addEventListener('change', function() {
            if (index === 0 && document.getElementById('allHalaman').checked) {
                const firstHalamanValue = this.value;
                document.querySelectorAll('.halaman').forEach((el, idx) => {
                    if (idx !== 0) { // Skip the first element
                        el.value = firstHalamanValue;
                    }
                });
            }
        });
    });

    //Centang ketuntasan tartil

    document.getElementById('allTuntasTartil').addEventListener('change', function() {
        const allTuntasTartil = this.checked;
        const tuntasTartilElements = document.querySelectorAll('.ketuntasan_tartil');

        if (allTuntasTartil && tuntasTartilElements.length > 0) {
            tuntasTartilElements.forEach((selectElement, index) => {
                selectElement.value = 'Tuntas';
            });
        } else {
            tuntasTartilElements.forEach((selectElement, index) => {
                selectElement.value = 'Pilih Status'; // Reset to default option
            });
        }
    });

    document.querySelectorAll('.ketuntasan_tartil').forEach((selectElement, index) => {
        selectElement.addEventListener('change', function() {
            if (index === 0 && document.getElementById('allTuntasTartil').checked) {
                const firstTuntasTartilValue = this.value;
                document.querySelectorAll('.ketuntasan_tartil').forEach((el, idx) => {
                    el.value = firstTuntasTartilValue;
                });
            }
        });
    });


    //Centang Juz

    document.getElementById('allJuz').addEventListener('change', function() {
        const allJuz = this.checked;
        const juzElements = document.querySelectorAll('.juz');

        if (allJuz && juzElements.length > 0) {
            const firstJuzValue = juzElements[0].value;
            juzElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = firstJuzValue;
                }
            });
        } else {
            juzElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = 'Pilih Juz'; // Reset to default option
                }
            });
        }
    });

    document.querySelectorAll('.juz').forEach((selectElement, index) => {
        selectElement.addEventListener('change', function() {
            if (index === 0 && document.getElementById('allJuz').checked) {
                const firstJuzValue = this.value;
                document.querySelectorAll('.juz').forEach((el, idx) => {
                    if (idx !== 0) { // Skip the first element
                        el.value = firstJuzValue;
                    }
                });
            }
        });
    });

    //Centang surat

    document.getElementById('allSurat').addEventListener('change', function() {
        const allSurat = this.checked;
        const suratElements = document.querySelectorAll('.surat');

        if (allSurat && suratElements.length > 0) {
            const firstSuratValue = suratElements[0].value;
            suratElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = firstSuratValue;
                }
            });
        } else {
            suratElements.forEach((selectElement, index) => {
                if (index !== 0) { // Skip the first element
                    selectElement.value = ''; // Reset to default option
                }
            });
        }
    });

    document.querySelectorAll('.halaman').forEach((selectElement, index) => {
        selectElement.addEventListener('change', function() {
            if (index === 0 && document.getElementById('allHalaman').checked) {
                const firstHalamanValue = this.value;
                document.querySelectorAll('.halaman').forEach((el, idx) => {
                    if (idx !== 0) { // Skip the first element
                        el.value = firstHalamanValue;
                    }
                });
            }
        });
    });

    //Centang ketuntasan tahfizh

    document.getElementById('allTuntasTahfizh').addEventListener('change', function() {
        const allTuntasTahfizh = this.checked;
        const tuntasTahfizhElements = document.querySelectorAll('.ketuntasan_tahfizh');

        if (allTuntasTahfizh && tuntasTahfizhElements.length > 0) {
            tuntasTahfizhElements.forEach((selectElement, index) => {
                selectElement.value = 'Tuntas';
            });
        } else {
            tuntasTahfizhElements.forEach((selectElement, index) => {
                selectElement.value = 'Pilih Status'; // Reset to default option
            });
        }
    });

    document.querySelectorAll('.ketuntasan_tahfizh').forEach((selectElement, index) => {
        selectElement.addEventListener('change', function() {
            if (index === 0 && document.getElementById('allTuntasTahfizh').checked) {
                const firstTuntasTahfizhValue = this.value;
                document.querySelectorAll('.ketuntasan_tahfizh').forEach((el, idx) => {
                    el.value = firstTuntasTahfizhValue;
                });
            }
        });
    });
</script>