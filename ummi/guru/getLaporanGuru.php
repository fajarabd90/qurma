<?php
if (isset($_POST['bulan'])) {
    $bulan = $_POST['bulan'];

    // Include your database connection file
    include('../config.php');
    session_start();
    $id = $_SESSION['guru'];

    if (!isset($id)) {
        header('location:../index.php');
    }

    $user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
    $user->execute([$id]);
    $user = $user->fetch(PDO::FETCH_ASSOC);
    $guru = $user['nama'];
}

if (isset($_POST['bulan'])) {
    $bulan = $_POST['bulan'];

    // Query to fetch data based on the selected month
    $laporan = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT kelompok.guru FROM kelompok INNER JOIN laporan ON kelompok.nama = laporan.nama WHERE laporan.bulan = '$bulan' AND kelompok.guru = '$guru'"));
?>

    <?php if ($laporan == 1) : ?>
        <div class='alert alert-success d-flex justify-content-between align-items-center p-2' role='alert'>
            <span class='me-auto'>Anda sudah mengisi laporan bulan ini!</span>
        </div>
    <?php else : ?>
        <div class='alert alert-danger d-flex justify-content-between align-items-center p-2' role='alert'>
            <span class='me-auto'>Anda belum mengisi laporan bulan ini!</span>
        </div>
    <?php endif; ?>


<?php
}
?>
</tbody>
</table>