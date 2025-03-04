<?php
require 'services/auth.php';
require 'config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID employé invalide.");
}
$stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
$stmt->execute([$id]);
header("Location: read.php");
exit();
?>
