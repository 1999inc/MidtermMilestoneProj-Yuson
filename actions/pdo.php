<?php
$username = 'root';
$password = '';
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=cookbook;charset=utf8mb4', $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);


?>