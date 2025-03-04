<?php
require 'services/auth.php';
require 'config/db.php';


$adminUsername = $_SESSION['admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    if (!empty($new_username) && !empty($new_password)) {
        $hashed_password = hash("sha256", $new_password);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$new_username, $hashed_password]);
        $message = "✅ Nouvel admin ajouté avec succès.";
    } else {
        $error = "❌ Tous les champs sont obligatoires.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$adminUsername]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && hash("sha256", $old_password) === $admin['password']) {
        if ($new_password === $confirm_password) {
            $hashed_new_password = hash("sha256", $new_password);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->execute([$hashed_new_password, $adminUsername]);
            $message = "✅ Mot de passe changé avec succès.";
        } else {
            $error = "❌ Les nouveaux mots de passe ne correspondent pas.";
        }
    } else {
        $error = "❌ Ancien mot de passe incorrect.";
    }
}


if (isset($_GET['delete_id'])) {
    $countAdmins = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

    if ($countAdmins > 1) {
        $id = $_GET['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: manage_admins.php");
        exit();
    } else {
        $error = "❌ Impossible de supprimer : Il doit y avoir au moins un administrateur.";
    }
}


$admins = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Admins</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary text-center">🔐 Gestion des Administrateurs</h2>

        <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <!-- Formulaire d'ajout d'un nouvel admin -->
        <form method="POST" class="bg-white p-4 rounded shadow w-50 mx-auto">
            <h4>➕ Ajouter un Administrateur</h4>
            <div class="mb-3">
                <label class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="add_admin" class="btn btn-primary w-100">Ajouter</button>
        </form>

        <!-- Formulaire de changement de mot de passe -->
        <form method="POST" class="bg-white p-4 rounded shadow w-50 mx-auto mt-5">
            <h4>🔑 Changer le Mot de Passe</h4>
            <div class="mb-3">
                <label class="form-label">Ancien Mot de Passe</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nouveau Mot de Passe</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmer Nouveau Mot de Passe</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-warning w-100">Modifier</button>
        </form>

        
        <h4 class="mt-5">📋 Liste des Administrateurs</h4>
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin) : ?>
                <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><?= htmlspecialchars($admin['username']) ?></td>
                    <td>
                        <a href="manage_admins.php?delete_id=<?= $admin['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Supprimer cet administrateur ?')">❌ Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary">🏠 Retour au Dashboard</a>
    </div>
</body>
</html>

