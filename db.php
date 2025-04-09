<?php

$host = 'localhost';
$db = 'agendeja';
$user = 'root'; // altere conforme necessário
$pass = ''; // altere conforme necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>