<?php
session_start();
require 'config/db.php'; // Fichier de connexion qui définit l'objet PDO $pdo

if (!isset($_SESSION['employee_id'])) {
    header("Location: employee_login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
    } else {
        $stmt = $pdo->prepare("SELECT password FROM employees WHERE id = ?");
        $stmt->execute([$_SESSION['employee_id']]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$employee) {
            $error = "Employé non trouvé.";
        } else {
            // Comparaison en clair pour cet exemple (en production, utiliser password_verify())
            if ($employee['password'] !== $current_password) {
                $error = "Le mot de passe actuel est incorrect.";
            } else {
                $stmt = $pdo->prepare("UPDATE employees SET password = ? WHERE id = ?");
                if ($stmt->execute([$new_password, $_SESSION['employee_id']])) {
                    $success = "Mot de passe mis à jour avec succès.";
                } else {
                    $error = "Erreur lors de la mise à jour du mot de passe.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier mon mot de passe</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    .center-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }
    .form-container {
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body class="bg-light">
  <div class="center-container">
    <div class="form-container bg-white p-4 rounded shadow">
      <h2 class="text-center mb-4">Modifier mon mot de passe</h2>
      <?php if ($error): ?>
          <div class="alert alert-danger"><?= $error ?></div>
      <?php elseif ($success): ?>
          <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>
      <form method="POST">
          <div class="mb-3">
              <label class="form-label">Mot de passe actuel</label>
              <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
              <label class="form-label">Nouveau mot de passe</label>
              <input type="password" name="new_password" class="form-control" required>
          </div>
          <div class="mb-3">
              <label class="form-label">Confirmer le nouveau mot de passe</label>
              <input type="password" name="confirm_password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
      </form>
      <br>
      <a href="employee_interface.php" class="btn btn-secondary w-100">Retour à l'interface employé</a>
    </div>
  </div>
</body>
</html>

