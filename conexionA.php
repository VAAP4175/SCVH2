<?php
$host = 'localhost';
$dbname = 'sala de computo';
$user = 'root';
$password = '';


$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
