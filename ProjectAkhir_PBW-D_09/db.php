<?php
$host = 'localhost';
$db = 'agenda_planner';
$user = 'root'; // sesuaikan dengan konfigurasi XAMPP
$pass = '';     // default password XAMPP kosong

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
