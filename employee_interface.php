<?php
session_start();
if (!isset($_SESSION['employee_logged_in']) || $_SESSION['employee_logged_in'] !== true) {
    header("Location: employee_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Interface Employé</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Font Awesome pour les icônes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-t7vtKXJXcAmJ3f3OM2c5OPjbTa6v1CfQF96bLuH2sMk5+4wD2I1LvU9T7o9lpFzAHLFKqlOZkCkWvIg2+ySwRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background: linear-gradient(135deg, #f0f2f5, #d9e2ec);
      min-height: 100vh;
    }
    .header {
      margin-bottom: 2rem;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .interface-icon {
      font-size: 48px;
      color: #0d6efd;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="text-center header pt-5">
      <h1 class="display-5">Bienvenue dans Smarttech</h1>
      <p class="lead">Accédez à vos services et gérez vos ressources en toute simplicité.</p>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <!-- Carte FTP -->
      <div class="col">
        <div class="card h-100 text-center shadow-sm">
          <div class="card-body">
            <div class="interface-icon mb-3">
              <i class="fa-solid fa-file-upload"></i>
            </div>
            <h5 class="card-title">Gestion des fichiers FTP</h5>
            <p class="card-text">Accédez à vos documents, uploadez et téléchargez vos fichiers via le serveur FTP.</p>
            <a href="ftp/ftp_list.php" class="btn btn-primary">Accéder aux fichiers</a>
          </div>
        </div>
      </div>
      <!-- Carte Accès Distant -->
      <div class="col">
        <div class="card h-100 text-center shadow-sm">
          <div class="card-body">
            <div class="interface-icon mb-3">
              <i class="fa-solid fa-desktop"></i>
            </div>
            <h5 class="card-title">Accès distant</h5>
            <p class="card-text">Consultez les instructions pour accéder à distance via SSH, VNC/NoVNC ou RDP.</p>
            <a href="instructions_distant.php" class="btn btn-primary">Voir instructions</a>
          </div>
        </div>
      </div>
      <!-- Carte Modifier mot de passe -->
      <div class="col">
        <div class="card h-100 text-center shadow-sm">
          <div class="card-body">
            <div class="interface-icon mb-3">
              <i class="fa-solid fa-key"></i>
            </div>
            <h5 class="card-title">Modifier mon mot de passe</h5>
            <p class="card-text">Changez votre mot de passe pour sécuriser votre compte.</p>
            <a href="employee_change_password.php" class="btn btn-primary">Changer le mot de passe</a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center mt-5">
      <a href="employee_logout.php" class="btn btn-danger">Déconnexion</a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

