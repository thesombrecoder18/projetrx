<?php
// Inclusion manuelle des fichiers PHPMailer
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->SMTPDebug = 1;         
$mail->isSMTP();
$mail->Host       = '10.106.106.71'; // Adresse IP de ton serveur iRedMail
$mail->SMTPAuth   = true;
$mail->Username   = 'notification@mail.smarttech.sn'; 
$mail->Password   = 'P@sser123';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
$mail->SMTPAutoTLS = false;          // Désactive l'auto-TLS si nécessaire

// Désactiver la vérification du certificat SSL/TLS
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true
    )
);

$mail->setFrom('notification@mail.smarttech.sn', 'SmartTech test envoi');
$mail->addAddress('postmaster@mail.smarttech.sn', 'Smarttech');

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
