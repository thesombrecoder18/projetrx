<?php
session_start();
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'config/db.php';  // Ce fichier définit l'objet PDO $pdo
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, password FROM employees WHERE email = ?");
        $stmt->execute([$email]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        // Comparaison en clair pour cet exemple ; en production, utilisez password_verify()
        if ($employee && $employee['password'] === $password) {
            $_SESSION['employee_id'] = $employee['id'];
            $_SESSION['employee_email'] = $email;
            $_SESSION['employee_logged_in'] = true;
            header("Location: employee_interface.php");
            exit();
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Employé</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    html, body { height: 100%; margin: 0; }
    .center-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }
    .form-container { width: 100%; max-width: 400px; }
  </style>
</head>
<body class="bg-light">
  <div class="center-container">
    <div class="form-container bg-white p-4 rounded shadow">
      <h2 class="text-center mb-4">Connexion Employé</h2>
      <?php if ($error): ?>
          <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>
      <form method="POST">
          <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Se connecter</button>
      </form>
    </div>
  </div>
</body>
</html>

