<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Instructions d'accès distant</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
      <h2 class="text-center">Instructions d'accès distant</h2>
      <div class="card mb-3">
          <div class="card-body">
              <h5 class="card-title">Accès SSH</h5>
              <p class="card-text">
                Pour accéder via SSH, utilisez un client SSH (comme PuTTY ou le terminal) et connectez-vous à l'adresse IP du serveur (par exemple, <code>10.106.106.71</code>) avec vos identifiants.
              </p>
          </div>
      </div>
      <div class="card mb-3">
          <div class="card-body">
              <h5 class="card-title">Accès VNC/NoVNC</h5>
              <p class="card-text">
                Pour l'accès graphique via VNC/NoVNC, connectez-vous à l'adresse <code>http://10.106.106.71:6080</code> (ou selon la configuration) avec votre client VNC.
              </p>
          </div>
      </div>
      <div class="card mb-3">
          <div class="card-body">
              <h5 class="card-title">Accès RDP</h5>
              <p class="card-text">
                Pour l'accès via RDP, utilisez le client Remote Desktop (sur Windows) ou un client RDP sur Linux et connectez-vous à l'adresse <code>10.106.106.71</code>.
              </p>
          </div>
      </div>
      <a href="employee_interface.php" class="btn btn-secondary">Retour à l'interface employé</a>
  </div>
</body>
</html>
