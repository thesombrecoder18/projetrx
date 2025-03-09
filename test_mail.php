<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail.smarttech.sn';
    $mail->SMTPAuth = true; 
    $mail->Username = 'postmaster@mail.smarttech.sn'; 
    $mail->Password = 'passer'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port = 587;

    // Désactiver la vérification SSL
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->setFrom('postmaster@mail.smarttech.sn', 'Admin');
    $mail->addAddress('notification@mail.smarttech.sn');

    $mail->Subject = 'Test PHPMailer';
    $mail->Body = 'Ceci est un test d\'envoi d\'email via PHPMailer';

    $mail->send();
    echo '✅ Email envoyé avec succès';
} catch (Exception $e) {
    echo "❌ Erreur : {$mail->ErrorInfo}";
}
