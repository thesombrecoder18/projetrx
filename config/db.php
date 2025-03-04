<?php
$host = '127.0.0.1';
$dbname = 'smarttech';
$port = "3306"; 
$username = 'root';
$password = 'passer';


try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

