<?php
$servername = "localhost";
$username = "root"; // HeidiSQL'de kullanılan MySQL kullanıcı adı
$password = ""; // HeidiSQL'de kullanılan MySQL şifresi
$dbname = "my_site"; // Oluşturduğunuz veritabanı adı

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlantı sağlanamadı: " . $conn->connect_error);
}
?>
