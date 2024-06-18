<?php

//Koneksi Database

$server = "localhost";
$db_name_conn = "qurk4279_lms";
$db_name_pdo = 'mysql:host=localhost;dbname=qurk4279_lms';
$username = "qurk4279_fajar";
$password = "fajarabd90";
$conn = mysqli_connect($server, $username, $password, $db_name_conn);
$conn_pdo = new PDO($db_name_pdo, $username, $password);

//Index

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
