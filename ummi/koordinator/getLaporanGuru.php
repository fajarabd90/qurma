<?php
if (isset($_POST['bulan'])) {
    $bulan = $_POST['bulan'];

    // Include your database connection file
    include('../config.php');

    // Initialize a counter
    $no = 1;

    // Query to fetch data based on the selected month
    $sql = mysqli_query($conn, "SELECT DISTINCT kelompok.guru FROM kelompok INNER JOIN laporan ON kelompok.nama = laporan.nama WHERE laporan.bulan = '$bulan'");

    $laporan = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT kelompok.guru FROM kelompok INNER JOIN laporan ON kelompok.nama = laporan.nama WHERE laporan.bulan = '$bulan'"));
    $guru = mysqli_num_rows(mysqli_query($conn, "SELECT nama FROM guru"));

    $jumlah = $guru - $laporan;
?>

    <?php if ($jumlah > 0) : ?>
        <div class='alert alert-danger d-flex justify-content-between align-items-center p-2' role='alert'>
            <span class='me-auto'>Ada <?= $jumlah ?> Guru yang belum input laporan!</span>
        </div>
    <?php endif; ?>
    <table class='table table-striped table-hover table-bordered'>
        <thead>
            <tr>
                <th scope='col'>NO</th>
                <th scope='col'>Nama</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Check if the query was successful
        if ($sql) {
            // Fetch and display data
            while ($data = mysqli_fetch_assoc($sql)) {

                echo "
           
                    <tr>
                        <th scope='row'>{$no}</th>
                        <td>{$data['guru']}</td>
                    </tr>
               ";
                $no++;
            }
        } else {
            // Handle query error
            echo "<tr><td colspan='2'>Error fetching data: " . mysqli_error($conn) . "</td></tr>";
        }
    }
        ?>
        </tbody>
    </table>