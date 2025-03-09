<?php
require 'services/auth.php';
require 'config/db.php';

// Récupérer les filtres sélectionnés
$month = $_GET['month'] ?? '';
$day = $_GET['day'] ?? '';

// Construire la requête SQL avec les filtres
$query = "SELECT * FROM employees WHERE 1=1";
$params = [];

if (!empty($month)) {
    $query .= " AND DATE_FORMAT(created_at, '%Y-%m') = ?";
    $params[] = $month;
}

if (!empty($day)) {
    $query .= " AND DATE_FORMAT(created_at, '%Y-%m-%d') = ?";
    $params[] = $day;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Employés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary text-center">📋 Liste des Employés</h2>

        <!-- Formulaire de filtre -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">📅 Filtrer par Mois :</label>
                <input type="month" name="month" class="form-control" value="<?= $month ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">📆 Filtrer par Jour :</label>
                <input type="date" name="day" class="form-control" value="<?= $day ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-50">🔍 Filtrer</button>
                <a href="read.php" class="btn btn-secondary w-50 ms-2">🔄 Réinitialiser</a>
            </div>
        </form>

        <!-- Tableau des employés -->
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Poste</th>
                    <th>Date d'Ajout</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $emp) : ?>
                <tr>
                    <td><?= $emp['id'] ?></td>
                    <td><?= $emp['name'] ?></td>
                    <td><?= $emp['email'] ?></td>
                    <td><?= $emp['position'] ?></td>
                    <td><?= date("d/m/Y", strtotime($emp['created_at'])) ?></td>
                    <td>
                        <a href="update.php?id=<?= $emp['id'] ?>" class="btn btn-warning btn-sm">✏️ Modifier</a>
                        <a href="delete.php?id=<?= $emp['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet employé ?')">❌ Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary">🏠 Retour au Dashboard</a>
    </div>
</body>
</html>

