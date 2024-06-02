<?php
if (isset($_POST['bulan'])) {
    $bulan = $_POST['bulan'];

    // Include your database connection file
    include('../config.php');

    // Initialize a counter
    $no = 1;

    // Query to fetch data based on the selected month
    $sql = mysqli_query($conn, "SELECT DISTINCT kelompok.guru FROM kelompok INNER JOIN laporan ON kelompok.nama = laporan.nama WHERE laporan.bulan = '$bulan'");

    // Check if the query was successful
    if ($sql) {
        // Fetch and display data
        while ($data = mysqli_fetch_assoc($sql)) {

            echo "<tr>
                    <th scope='row'>{$no}</th>
                    <td>{$data['guru']}</td>
                  </tr>";
            $no++;
        }
    } else {
        // Handle query error
        echo "<tr><td colspan='2'>Error fetching data: " . mysqli_error($conn) . "</td></tr>";
    }
}
