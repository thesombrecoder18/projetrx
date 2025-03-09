<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Assurez-vous que l'autoload de PHPMailer est disponible
require 'vendor/autoload.php';

/**
 * Envoie une notification par e-mail en fonction de l'action effectuée.
 *
 * @param string $action 'create', 'update' ou 'delete'
 * @param string $entity Type d'entité ("employé" ou "utilisateur")
 * @param string $name Nom de l'entité concernée
 * @param string $email Email de l'entité concernée
 * @return bool True si l'e-mail a été envoyé avec succès, sinon false.
 */
function sendNotification($action, $entity, $name, $email) {
    $mail = new PHPMailer(true);
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Helo = 'mail.smarttech.sn'; // Forcer l'identité EHLO
        $mail->Host       = 'mail.smarttech.sn'; // Domaine de votre serveur mail
        $mail->SMTPAuth   = true;
        $mail->Username   = 'postmaster@mail.smarttech.sn'; 
        $mail->Password   = 'passer'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPAutoTLS = false;
        // Désactivation de la vérification SSL pour un environnement interne/test
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'      => false,
                'verify_peer_name' => false,
                'allow_self_signed'=> true
            )
        );
        
        // Définir l'expéditeur
        $mail->setFrom('postmaster@mail.smarttech.sn', 'Admin');

        // Définir le destinataire de la notification (adresse d'admin)
        $mail->addAddress('notification@mail.smarttech.sn');

        // Définir le sujet et le corps du message en fonction de l'action
        switch ($action) {
            case 'create':
                $subject = "Création de {$entity}: {$name}";
                $body = "L'{$entity} <strong>" . htmlspecialchars($name) . "</strong> (Email: " . htmlspecialchars($email) . ") a été créé.";
                break;
            case 'update':
                $subject = "Modification de {$entity}: {$name}";
                $body = "L'{$entity} <strong>" . htmlspecialchars($name) . "</strong> (Email: " . htmlspecialchars($email) . ") a été modifié.";
                break;
            case 'delete':
                $subject = "Suppression de {$entity}: {$name}";
                $body = "L'{$entity} <strong>" . htmlspecialchars($name) . "</strong> (Email: " . htmlspecialchars($email) . ") a été supprimé.";
                break;
            default:
                $subject = "Notification {$entity}";
                $body = "Une action a été effectuée sur l'{$entity} <strong>" . htmlspecialchars($name) . "</strong> (Email: " . htmlspecialchars($email) . ").";
        }
        
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body    = $body;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur d'envoi de notification: " . $mail->ErrorInfo);
        return false;
    }
}
?>

