<?php
// Inclusion manuelle des fichiers PHPMailer (ajuste le chemin si nécessaire)
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->SMTPDebug = 3;  // Niveau de débogage pour voir les échanges SMTP
$mail->isSMTP();

// Forcer l'identité EHLO à utiliser le nom d'hôte correct
$mail->Helo = 'mail.smarttech.sn';

// Configuration du serveur SMTP
$mail->Host       = '10.106.106.71'; // IP de ton serveur iRedMail
$mail->SMTPAuth   = true;
$mail->Username   = 'notification@mail.smarttech.sn'; 
$mail->Password   = 'P@sser123';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
$mail->SMTPAutoTLS = false;  // Désactive l'auto-TLS si nécessaire

// Désactivation de la vérification du certificat SSL/TLS (pour les tests en interne)
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true
    )
);

// Définir l'expéditeur et le destinataire
$mail->setFrom('notification@mail.smarttech.sn', 'SmartTech Test Envoi');
$mail->addAddress('notification@mail.smarttech.sn', 'SmartTech'); // Utilisation d'une adresse alternative pour le test

// Configuration du contenu du mail
$mail->isHTML(true);
$mail->Subject = 'Test Email depuis SmartTech';
$mail->Body    = 'Ceci est un test d\'envoi d\'email via le serveur iRedMail sur Ubuntu (IP: 10.106.106.71).';

try {
    if ($mail->send()) {
        echo 'Message envoyé avec succès';
    } else {
        echo 'L\'envoi a échoué.';
    }
} catch (Exception $e) {
    echo "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
}
?>

