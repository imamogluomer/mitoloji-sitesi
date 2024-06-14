<?php
$servername = "localhost";
$username = "root"; // XAMPP varsayılan kullanıcısı
$password = ""; // XAMPP varsayılan parolası
$dbname = "my_site";

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
