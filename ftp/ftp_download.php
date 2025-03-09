<?php
// ftp_download.php
if (!isset($_GET['file']) || empty($_GET['file'])) {
    die("Aucun fichier spécifié.");
}

$file = $_GET['file'];
$remote_file = "uploads/" . $file;

$ftp_server = "10.106.106.71";
$ftp_user = "ftpuser";
$ftp_pass = "passer"; // Remplacez par le mot de passe réel

$conn_id = ftp_connect($ftp_server) or die("Impossible de se connecter à $ftp_server");
if (!ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    die("Échec de la connexion FTP.");
}
ftp_pasv($conn_id, true);

// Créer un fichier temporaire local pour récupérer le fichier distant
$temp_file = tempnam(sys_get_temp_dir(), 'FTP');
if (ftp_get($conn_id, $temp_file, $remote_file, FTP_BINARY)) {
    // Envoyer le fichier au navigateur pour téléchargement
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($remote_file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($temp_file));
    readfile($temp_file);
    unlink($temp_file);
} else {
    echo "Erreur lors du téléchargement du fichier.";
}
ftp_close($conn_id);
?>
