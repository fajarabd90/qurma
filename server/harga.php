<!doctype html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">

    <meta name="generator" content="Hugo 0.104.2">

    <title>Harga</title>

    <link rel="shortcut icon" href="assets/img/logo.png" />

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/pricing/">

    <link href="qurma/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>



    <style>

        .bd-placeholder-img {

            font-size: 1.125rem;

            text-anchor: middle;

            -webkit-user-select: none;

            -moz-user-select: none;

            user-select: none;

        }



        @media (min-width: 768px) {

            .bd-placeholder-img-lg {

                font-size: 3.5rem;

            }

        }



        .b-example-divider {

            height: 3rem;

            background-color: rgba(0, 0, 0, .1);

            border: solid rgba(0, 0, 0, .15);

            border-width: 1px 0;

            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);

        }



        .b-example-vr {

            flex-shrink: 0;

            width: 1.5rem;

            height: 100vh;

        }



        .bi {

            vertical-align: -.125em;

            fill: currentColor;

        }



        .nav-scroller {

            position: relative;

            z-index: 2;

            height: 2.75rem;

            overflow-y: hidden;

        }



        .nav-scroller .nav {

            display: flex;

            flex-wrap: nowrap;

            padding-bottom: 1rem;

            margin-top: -1px;

            overflow-x: auto;

            text-align: center;

            white-space: nowrap;

            -webkit-overflow-scrolling: touch;

        }



        .centered {

            display: flex;

            justify-content: center;

            align-items: center;

            height: 100vh;

            /* Untuk membuatnya terpusat secara vertikal */

        }

    </style>

</head>



<body>



    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

        <symbol id="check" viewBox="0 0 16 16">

            <title>Check</title>

            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />

        </symbol>

    </svg>



    <div class="container py-3">

        <header>

            <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">

                <a href="/" class="d-flex align-items-center text-dark text-decoration-none">

                    <img src="qurma/assets/img/logo.png" alt="" height="50" class="me-2">

                    <span class="fs-4">Qur-Ma</span>

                </a>



                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">

                    <a class="me-3 py-2 text-dark text-decoration-none" href="index.php">Fitur</a>

                    <a class="me-3 py-2 text-dark text-decoration-none" href="harga.php">Harga</a>

                    <a class="py-2 text-dark text-decoration-none" href="about.php">Tentang Kami</a>

                </nav>

            </div>



            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">

                <img src="qurma/assets/img/logo-ummi.png" alt="" height="100" class="mb-2">

                <h1 class="display-4 fw-normal">LMS Metode UMMI</h1>

                <p class="fs-5 text-muted">Solusi mudah administrasi Anda</p>

            </div>

        </header>



        <main>



            <h2 class="display-6 text-center mb-4">Harga</h2>



            <div class="row row-cols-1 row-cols-md-2 mb-3 text-center">

                <div class="col">

                    <div class="card mb-4 rounded-3 shadow-sm">

                        <div class="card-header py-3">

                            <h4 class="my-0 fw-normal">Standar</h4>

                        </div>

                        <div class="card-body">

                            <h1 class="card-title pricing-card-title">Infaq<small class="text-muted fw-light">/bulan</small></h1>

                            <ul class="list-unstyled mt-3 mb-4">

                                <li>Domain Standar</li>

                                <li>Fitur Standar</li>

                                <li>Slow Maintenance</li>

                            </ul>

                            <a href="about.php"><button type="button" class="w-100 btn btn-lg btn-outline-primary">Hubungi Kami</button></a>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card mb-4 rounded-3 shadow-sm border-primary">

                        <div class="card-header py-3 text-bg-primary border-primary">

                            <h4 class="my-0 fw-normal">Pro (Free Trial 3 bulan)</h4>

                        </div>

                        <div class="card-body">

                            <h1 class="card-title pricing-card-title">Rp. 10.000<small class="text-muted fw-light">/siswa/tahun</small></h1>

                            <ul class="list-unstyled mt-3 mb-4">

                                <li>Domain Khusus</li>

                                <li>Fitur Lengkap</li>

                                <li>Fast Maintenance</li>

                            </ul>

                            <a href="about.php"><button type="button" class="w-100 btn btn-lg btn-primary">Hubungi Kami</button></a>

                        </div>

                    </div>

                </div>

            </div>



            <h2 class="display-6 text-center mb-4">Perbandingan Fitur</h2>



            <div class="table-responsive">

                <table class="table text-center">

                    <thead>

                        <tr>

                            <th style="width: 34%;"></th>

                            <th style="width: 22%;">Standar</th>

                            <th style="width: 22%;">Pro</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <th scope="row" class="text-start">Dashboard Laporan Perkembangan</th>

                            <td></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Pengelolaan Data Guru</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                    </tbody>



                    <tbody>

                        <tr>

                            <th scope="row" class="text-start">Pengelolaan Data Siswa</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Pengelolaan Placement Test</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Pengelolaan Data Kelompok</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Print Administrasi</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Laporan Bulanan</th>

                            <td></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Pengelolaan Tes Jilid</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Pengelolaan Tes Tahfizh</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Input Pra Munaqosyah</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Form Pra Munaqosyah</th>

                            <td></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Input Data Munaqosyah</th>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Excel Otomatis Pendaftaran Munaqosyah ke SIM UF</th>

                            <td></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Print Otomatis Nomor Peserta & Kartu Munaqosyah</th>

                            <td></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start">Excel Otomatis Data Khotaman</th>

                            <td></td>

                            <td><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg></td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start text-danger">Laporan Harian ke Orang Tua</th>

                            <td></td>

                            <td class="text-danger"><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg> Dengan tambahan biaya Add-on</td>

                        </tr>

                        <tr>

                            <th scope="row" class="text-start text-danger">Raport Tengah & Akhir Semester</th>

                            <td></td>

                            <td class="text-danger"><svg class="bi" width="24" height="24">

                                    <use xlink:href="#check" />

                                </svg> Dengan tambahan biaya Add-on</td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="card">

                <div class="card-body text-center bg-success text-white" style="font-size: 30px;">

                    Keamanan data 100%

                </div>

            </div>

        </main>



        <center>

            <footer class="pt-4 my-md-5 pt-md-5 border-top">

                <div class="row">

                    <div class="col-12 col-md">

                        <img class="mb-2" src="qurma/assets/img/logo.png" alt="" height="30">

                        <small class="d-block mb-3 text-muted">&copy; 2024</small>

                    </div>

                </div>

            </footer>

        </center>

    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script>

        function togglePasswordVisibility() {

            var passwordField = document.getElementById("password");

            var toggleButton = document.getElementById("togglePassword");



            if (passwordField.type === "password") {

                passwordField.type = "text";

                toggleButton.innerHTML = "<i class='far fa-eye-slash'></i>";

            } else {

                passwordField.type = "password";

                toggleButton.innerHTML = "<i class='far fa-eye'></i>";

            }

        }

    </script>

</body>



</html>