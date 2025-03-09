<?php
require 'notification.php';
require 'services/auth.php';
require 'config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID employé invalide.");
}

// Récupérer les infos de l'employé
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employee) {
    die("Employé non trouvé.");
}

$error = ""; // Initialisation de l'erreur

// Mettre à jour l'employé si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $position = trim($_POST['position']); // Récupérer la valeur du menu déroulant

    if (!empty($name) && !empty($email) && !empty($position)) {
        $stmt = $pdo->prepare("UPDATE employees SET name = ?, email = ?, position = ? WHERE id = ?");
        if ($stmt->execute([$name, $email, $position, $id])) {
            // Envoi de la notification après mise à jour réussie
            sendNotification('update', 'employé', $name, $email);
            header("Location: read.php");
            exit();
        } else {
            $error = "Erreur lors de la mise à jour de l'employé.";
        }
    } else {
        $error = "Tous les champs sont obligatoires !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Employé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary text-center">✏️ Modifier un Employé</h2>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($employee['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($employee['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Poste</label>
                <select name="position" class="form-control">
                    <option value="Employé" <?= $employee['position'] == 'Employé' ? 'selected' : '' ?>>Employé</option>
                    <option value="Admin" <?= $employee['position'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning w-100">Mettre à Jour</button>
        </form>
        <br>
        <a href="read.php" class="btn btn-secondary">🔙 Retour à la Liste</a>
    </div>
</body>
</html>

