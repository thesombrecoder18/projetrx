<?php
require 'notification.php';
require 'services/auth.php';
require 'config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID employé invalide.");
}

// Récupérer les informations de l'employé avant suppression
$stmt = $pdo->prepare("SELECT name, email FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employee) {
    die("Employé non trouvé.");
}

$name = $employee['name'];
$email = $employee['email'];

// Supprimer l'employé
$stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
if ($stmt->execute([$id])) {
    // Envoyer la notification après suppression réussie
    sendNotification('delete', 'employe', $name, $email);
    header("Location: read.php");
    exit();
} else {
    die("Erreur lors de la suppression de l'employé.");
}
?>

