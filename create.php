<?php
require 'services/auth.php';
require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position']; // Récupère la valeur du menu déroulant

    if (!empty($name) && !empty($email) && !empty($position)) {
        $stmt = $pdo->prepare("INSERT INTO employees (name, email, position) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $position]);
        header("Location: read.php");
        exit();
    } else {
        $error = "Tous les champs sont obligatoires !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Employé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary text-center">➕ Ajouter un Employé</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        
        <form method="POST" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Poste</label>
                <select name="position" class="form-control">
                    <option value="Employé" selected>Employé</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Ajouter</button>
        </form>
        
        <br>
        <a href="read.php" class="btn btn-secondary">🔙 Retour à la Liste</a>
    </div>
</body>
</html>
