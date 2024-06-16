<?php
$paket = $conn_pdo->prepare("SELECT * FROM `paket` WHERE lembaga = '$lembaga'");
$paket->execute();
$paket = $paket->fetch(PDO::FETCH_ASSOC);
$pilih_paket = $paket['paket'];
?>

<style>
    .custom-button {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 10px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: #3085d6;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .custom-button:hover {
        background-color: #2565a8;
    }
</style>

<a class="sidebar-brand" href="../index.php">
    <span class="align-middle">QurMa (<?= $user['lembaga']; ?>)</span>
</a>

<ul class="sidebar-nav">

    <li class="sidebar-item">
        <a class="sidebar-link" href="../index.php" style="margin-top: -10px;">
            <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
        </a>

    </li>

    <li class="sidebar-header" style="margin-top: -20px;">
        Administrasi & Laporan
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="../placement-test/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">Placement Test</span>
        </a>
        <a class="sidebar-link" href="../data-kelompok/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Data Kelompok</span>
        </a>
        <?php

        if ($pilih_paket == 'Standar') {
            echo '<a class="sidebar-link" href="#" style="margin-top: -5px;" id="pro-link">
            <i class="align-middle" data-feather="trending-up"></i>
            <span class="align-middle">Laporan Bulanan</span>
            <sup style="font-size: smaller; vertical-align: super; background-color: red; color: white; padding: 2px 4px; border-radius: 3px;">Pro</sup>
          </a>';
        } else {
            echo '<a class="sidebar-link" href="../laporan-bulanan/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="trending-up"></i> 
            <span class="align-middle">Laporan Bulanan</span>
          </a>';
        }
        ?>
    </li>

    <li class="sidebar-header" style="margin-top: -20px;">
        Tes Kenaikan Tingkat
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="../tes-jilid/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Tes Jilid</span>
        </a>
        <a class="sidebar-link" href="../tes-tahfizh/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="heart"></i> <span class="align-middle">Tes Tahfizh</span>
        </a>
    </li>
    <li class="sidebar-header" style="margin-top: -20px;">
        Tahapan Munaqosyah
    </li>
    <li class="sidebar-item mb-4">
        <a class="sidebar-link" href="../pra-munaqosyah/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="bookmark"></i> <span class="align-middle">Pra Munaqosyah</span>
        </a>
        <a class="sidebar-link" href="../munaqosyah/index.php" style="margin-top: -5px;">
            <i class="align-middle" data-feather="award"></i> <span class="align-middle">Munaqosyah</span>
        </a>
    </li>
</ul>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var proLink = document.getElementById('pro-link');
        if (proLink) {
            proLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link action
                Swal.fire({
                    icon: 'warning',
                    title: 'Paket Pro Diperlukan',
                    html: 'Anda harus berlangganan paket pro.<br><br><a href="../harga.php" class="custom-button">Langganan Sekarang</a>',
                    showConfirmButton: false,
                });
            });
        }
    });
</script>