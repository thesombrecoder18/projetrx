<?php
require 'services/auth.php';
require 'config/db.php';

$roles = $pdo->query("SELECT position, COUNT(*) as count FROM employees GROUP BY position")->fetchAll(PDO::FETCH_ASSOC);


$history = $pdo->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM employees GROUP BY month ORDER BY month")->fetchAll(PDO::FETCH_ASSOC);


$labelsRoles = [];
$valuesRoles = [];
$colors = ['#007bff', '#28a745'];

foreach ($roles as $role) {
    $labelsRoles[] = $role['position'];
    $valuesRoles[] = $role['count'];
}

$labelsHistory = [];
$valuesHistory = [];

foreach ($history as $entry) {
    $labelsHistory[] = $entry['month'];
    $valuesHistory[] = $entry['count'];
}

$labelsRolesJson = json_encode($labelsRoles);
$valuesRolesJson = json_encode($valuesRoles);
$labelsHistoryJson = json_encode($labelsHistory);
$valuesHistoryJson = json_encode($valuesHistory);
$colorsJson = json_encode($colors);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
	<div class="text-center mt-4">
    		<a href="services/logout.php" class="btn btn-danger">🚪 Déconnexion</a>
	</div>
    <div class="container mt-5">
        <h2 class="text-primary text-center">📊 Dashboard - Gestion des Employés</h2>

        <div class="row mt-4">
            <!-- Graphique Répartition des Employés -->
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h4 class="card-title">👥 Répartition des Employés</h4>
                        <canvas id="roleChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Graphique Évolution des Employés -->
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h4 class="card-title">📈 Évolution des Employés</h4>
                        <canvas id="historyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Accès à la liste des employés -->
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h4 class="card-title">📋 Voir la Liste</h4>
                        <a href="read.php" class="btn btn-primary w-100">Accéder à la Liste</a>
                    </div>
                </div>
            </div>

            <!-- Ajouter un Employé -->
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h4 class="card-title">➕ Ajouter un Employé</h4>
                        <a href="create.php" class="btn btn-success w-100">Ajouter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row mt-4">
    
    <div class="col-md-6 mx-auto">
        <div class="card shadow">
            <div class="card-body text-center">
                <h4 class="card-title">🔐 Gérer les Admins</h4>
                <a href="manage_admins.php" class="btn btn-dark w-100">Administrateurs</a>
            </div>
        </div>
    </div>
</div>

	
   
    <script>
       
        var ctx1 = document.getElementById('roleChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: <?= $labelsRolesJson ?>,
                datasets: [{
                    data: <?= $valuesRolesJson ?>,
                    backgroundColor: <?= $colorsJson ?>
                }]
            }
        });

        
        var ctx2 = document.getElementById('historyChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: <?= $labelsHistoryJson ?>,
                datasets: [{
                    label: 'Nombre d\'Employés',
                    data: <?= $valuesHistoryJson ?>,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>

