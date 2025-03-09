<?php
// ftp_upload.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['ftpfile'])) {
    $ftp_server = "10.106.106.71";
    $ftp_user = "ftpuser";
    $ftp_pass = "passer"; // Remplacez par le mot de passe réel

    // Chemin local du fichier temporaire et nom distant dans le dossier "uploads"
    $local_file = $_FILES['ftpfile']['tmp_name'];
    $remote_file = "uploads/" . basename($_FILES['ftpfile']['name']);

    // Connexion au serveur FTP
    $conn_id = ftp_connect($ftp_server) or die("Impossible de se connecter à $ftp_server");

    // Authentification
    if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
        // Mode passif (souvent nécessaire)
        ftp_pasv($conn_id, true);
        // Upload du fichier en mode binaire
        if (ftp_put($conn_id, $remote_file, $local_file, FTP_BINARY)) {
            $message = "Fichier uploadé avec succès : " . htmlspecialchars(basename($_FILES['ftpfile']['name']));
        } else {
            $message = "Erreur lors de l'upload du fichier.";
        }
    } else {
        $message = "Échec de la connexion FTP.";
    }
    ftp_close($conn_id);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Upload FTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Uploader un fichier</h2>
        <?php if(isset($message)) { echo "<div class='alert alert-info'>" . $message . "</div>"; } ?>
        <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label for="ftpfile" class="form-label">Sélectionnez un fichier</label>
                <input type="file" name="ftpfile" id="ftpfile" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Uploader</button>
        </form>
        <br>
        <a href="ftp_list.php" class="btn btn-secondary">Voir les fichiers</a>
    </div>
</body>
</html>
