<?php
if (isset($_POST['bulan'])) {
    $bulan = $_POST['bulan'];

    // Include your database connection file
    include('../config.php');
    session_start();
    $id = $_SESSION['koordinator'];

    if (!isset($id)) {
        header('location:../index.php');
    }

    $user = $conn_pdo->prepare("SELECT * FROM `user` WHERE id = ?");
    $user->execute([$id]);
    $user = $user->fetch(PDO::FETCH_ASSOC);
    $lembaga = $user['lembaga'];

    //Total siswa
    $kelas1_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '1%'"));
    $kelas2_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '2%'"));
    $kelas3_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '3%'"));
    $kelas4_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '4%'"));
    $kelas5_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '5%'"));
    $kelas6_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa WHERE lembaga = '$lembaga' AND kelas LIKE '6%'"));

    //Total tuntas
    $kelas1_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND ketuntasan_tahfizh = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas2_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND ketuntasan_tahfizh = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas3_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND ketuntasan_tahfizh = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas4_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND ketuntasan_tahfizh = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas5_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND ketuntasan_tahfizh = 'Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas6_tuntas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND ketuntasan_tahfizh = 'Tuntas' AND laporan.bulan = '$bulan'"));

    //Total belum tuntas
    $kelas1_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND ketuntasan_tahfizh = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas2_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND ketuntasan_tahfizh = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas3_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND ketuntasan_tahfizh = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas4_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND ketuntasan_tahfizh = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas5_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND ketuntasan_tahfizh = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));
    $kelas6_belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND ketuntasan_tahfizh = 'Belum Tuntas' AND laporan.bulan = '$bulan'"));

    //Total juz 30
    $kelas1_30 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND juz = '30' AND laporan.bulan = '$bulan'"));
    $kelas2_30 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND juz = '30' AND laporan.bulan = '$bulan'"));
    $kelas3_30 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND juz = '30' AND laporan.bulan = '$bulan'"));
    $kelas4_30 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND juz = '30' AND laporan.bulan = '$bulan'"));
    $kelas5_30 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND juz = '30' AND laporan.bulan = '$bulan'"));
    $kelas6_30 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND juz = '30' AND laporan.bulan = '$bulan'"));

    //Total juz 29
    $kelas1_29 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND juz = '29' AND laporan.bulan = '$bulan'"));
    $kelas2_29 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND juz = '29' AND laporan.bulan = '$bulan'"));
    $kelas3_29 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND juz = '29' AND laporan.bulan = '$bulan'"));
    $kelas4_29 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND juz = '29' AND laporan.bulan = '$bulan'"));
    $kelas5_29 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND juz = '29' AND laporan.bulan = '$bulan'"));
    $kelas6_29 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND juz = '29' AND laporan.bulan = '$bulan'"));

    //Total juz 28
    $kelas1_28 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND juz = '28' AND laporan.bulan = '$bulan'"));
    $kelas2_28 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND juz = '28' AND laporan.bulan = '$bulan'"));
    $kelas3_28 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND juz = '28' AND laporan.bulan = '$bulan'"));
    $kelas4_28 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND juz = '28' AND laporan.bulan = '$bulan'"));
    $kelas5_28 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND juz = '28' AND laporan.bulan = '$bulan'"));
    $kelas6_28 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND juz = '28' AND laporan.bulan = '$bulan'"));

    //Total juz 1
    $kelas1_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND juz = '1' AND laporan.bulan = '$bulan'"));
    $kelas2_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND juz = '1' AND laporan.bulan = '$bulan'"));
    $kelas3_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND juz = '1' AND laporan.bulan = '$bulan'"));
    $kelas4_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND juz = '1' AND laporan.bulan = '$bulan'"));
    $kelas5_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND juz = '1' AND laporan.bulan = '$bulan'"));
    $kelas6_1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND juz = '1' AND laporan.bulan = '$bulan'"));

    //Total juz 2
    $kelas1_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND juz = '2' AND laporan.bulan = '$bulan'"));
    $kelas2_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND juz = '2' AND laporan.bulan = '$bulan'"));
    $kelas3_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND juz = '2' AND laporan.bulan = '$bulan'"));
    $kelas4_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND juz = '2' AND laporan.bulan = '$bulan'"));
    $kelas5_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND juz = '2' AND laporan.bulan = '$bulan'"));
    $kelas6_2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND juz = '2' AND laporan.bulan = '$bulan'"));

    //Total juz 3
    $kelas1_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND juz = '3' AND laporan.bulan = '$bulan'"));
    $kelas2_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND juz = '3' AND laporan.bulan = '$bulan'"));
    $kelas3_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND juz = '3' AND laporan.bulan = '$bulan'"));
    $kelas4_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND juz = '3' AND laporan.bulan = '$bulan'"));
    $kelas5_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND juz = '3' AND laporan.bulan = '$bulan'"));
    $kelas6_3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND juz = '3' AND laporan.bulan = '$bulan'"));

    // Total juz lainnya
    $kelas1_lain = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '1%' AND juz NOT IN ('1', '2', '3', '28', '29', '30') AND laporan.bulan = '$bulan'"));
    $kelas2_lain = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '2%' AND juz NOT IN ('1', '2', '3', '28', '29', '30') AND laporan.bulan = '$bulan'"));
    $kelas3_lain = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '3%' AND juz NOT IN ('1', '2', '3', '28', '29', '30') AND laporan.bulan = '$bulan'"));
    $kelas4_lain = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '4%' AND juz NOT IN ('1', '2', '3', '28', '29', '30') AND laporan.bulan = '$bulan'"));
    $kelas5_lain = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '5%' AND juz NOT IN ('1', '2', '3', '28', '29', '30') AND laporan.bulan = '$bulan'"));
    $kelas6_lain = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM laporan INNER JOIN siswa ON laporan.nama = siswa.nama WHERE lembaga = '$lembaga' AND kelas LIKE '6%' AND juz NOT IN ('1', '2', '3', '28', '29', '30') AND laporan.bulan = '$bulan'"));


    // Check if the query was successful
    for ($i = 1; $i <= 6; $i++) {
        // Dynamically creating variable names
        $kelas_siswa = ${"kelas" . $i . "_siswa"};
        $kelas_tuntas = ${"kelas" . $i . "_tuntas"};
        $kelas_belum = ${"kelas" . $i . "_belum"};
        $kelas_30 = ${"kelas" . $i . "_30"};
        $kelas_29 = ${"kelas" . $i . "_29"};
        $kelas_28 = ${"kelas" . $i . "_28"};
        $kelas_1 = ${"kelas" . $i . "_1"};
        $kelas_2 = ${"kelas" . $i . "_2"};
        $kelas_3 = ${"kelas" . $i . "_3"};
        $kelas_lain = ${"kelas" . $i . "_lain"};
?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $kelas_siswa ?: '' ?></td>
            <td><?= $kelas_tuntas ?: '' ?></td>
            <td><?= $kelas_belum ?: '' ?></td>
            <td><?= $kelas_30 ?: '' ?></td>
            <td><?= $kelas_29 ?: '' ?></td>
            <td><?= $kelas_28 ?: '' ?></td>
            <td><?= $kelas_1 ?: '' ?></td>
            <td><?= $kelas_2 ?: '' ?></td>
            <td><?= $kelas_3 ?: '' ?></td>
            <td><?= $kelas_lain ?: '' ?></td>
        </tr>
<?php
    }
} else {
    // Handle query error
    echo "<tr><td colspan='16'>Error fetching data: " . mysqli_error($conn) . "</td></tr>";
}
?>