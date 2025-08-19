<?php
$host = 'localhost';
$user = 'root';
$pass = '@Awaldige785143'; // sua senha do MySQL
$dbname = 'biblioteca';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>

