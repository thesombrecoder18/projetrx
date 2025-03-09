<?php
// ftp_list.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ftp_server = "10.106.106.71";
$ftp_user   = "ftpuser";
$ftp_pass   = "passer";

// Connexion au serveur FTP
$conn_id = ftp_connect($ftp_server);
if (!$conn_id) {
    die("Erreur : impossible de se connecter au serveur FTP $ftp_server");
}
echo "Connexion FTP réussie.<br>";

// Authentification
if (!ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    die("Erreur : authentification FTP échouée pour l'utilisateur $ftp_user");
}
echo "Authentification réussie pour $ftp_user.<br>";

// Activer le mode passif (souvent nécessaire derrière un firewall)
if (ftp_pasv($conn_id, true)) {
    echo "Mode passif activé.<br>";
} else {
    echo "Attention : l'activation du mode passif a échoué.<br>";
}

// Récupérer la liste des fichiers dans le dossier "uploads"
// Si le dossier "uploads" n'existe pas ou n'est pas accessible, cela retournera false.
$files = ftp_nlist($conn_id, "uploads");
if ($files === false) {
    $files = array(); // On initialise comme tableau vide si aucun fichier n'est trouvé
}
echo "Liste récupérée.<br>";

ftp_close($conn_id);
echo "Connexion FTP fermée.<br>";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des fichiers FTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Fichiers sur le serveur FTP</h2>
        <?php if (!empty($files) && is_array($files)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom du fichier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($files as $file): ?>
                        <tr>
                            <td><?= htmlspecialchars(basename($file)) ?></td>
                            <td>
                                <a href="ftp_download.php?file=<?= urlencode(basename($file)) ?>" class="btn btn-sm btn-primary">Télécharger</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun fichier trouvé dans le dossier FTP.</p>
        <?php endif; ?>
        <a href="ftp_upload.php" class="btn btn-secondary">Uploader un nouveau fichier</a>
    </div>
</body>
</html>

