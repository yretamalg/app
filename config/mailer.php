<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->configure();
    }

    private function configure() {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = $_ENV['MAIL_HOST'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $_ENV['MAIL_USERNAME'];
            $this->mail->Password = $_ENV['MAIL_PASSWORD'];
            $this->mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $this->mail->Port = $_ENV['MAIL_PORT'];
            $this->mail->CharSet = 'UTF-8';
            
            $this->mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        } catch (Exception $e) {
            error_log("Mailer configuration error: " . $e->getMessage());
        }
    }

    public function sendWelcomeEmail($to, $name, $password = null) {
        try {
            $this->mail->addAddress($to, $name);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Bienvenido al Sistema de Rifas Chile';
            
            $body = $this->getWelcomeTemplate($name, $password);
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error sending welcome email: " . $e->getMessage());
            return false;
        } finally {
            $this->mail->clearAddresses();
        }
    }

    public function sendPasswordReset($to, $name, $resetToken) {
        try {
            $this->mail->addAddress($to, $name);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Recuperación de Contraseña - Rifas Chile';
            
            $resetUrl = $_ENV['APP_URL'] . '/recuperar-password?token=' . $resetToken;
            $body = $this->getPasswordResetTemplate($name, $resetUrl);
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error sending password reset email: " . $e->getMessage());
            return false;
        } finally {
            $this->mail->clearAddresses();
        }
    }

    public function sendSaleNotification($to, $rifaName, $numbers, $total) {
        try {
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Confirmación de Compra - ' . $rifaName;
            
            $body = $this->getSaleNotificationTemplate($rifaName, $numbers, $total);
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error sending sale notification: " . $e->getMessage());
            return false;
        } finally {
            $this->mail->clearAddresses();
        }
    }

    private function getWelcomeTemplate($name, $password) {
        $passwordInfo = $password ? "<p><strong>Contraseña temporal:</strong> {$password}</p>" : '';
        
        return "
        <html>
        <body style='font-family: Arial, sans-serif; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #2563eb;'>¡Bienvenido a Rifas Chile!</h2>
                <p>Hola {$name},</p>
                <p>Tu cuenta ha sido creada exitosamente en nuestro sistema.</p>
                {$passwordInfo}
                <p>Puedes acceder al sistema desde: <a href='{$_ENV['APP_URL']}'>{$_ENV['APP_URL']}</a></p>
                <br>
                <p>Saludos cordiales,<br>El equipo de Rifas Chile</p>
            </div>
        </body>
        </html>";
    }

    private function getPasswordResetTemplate($name, $resetUrl) {
        return "
        <html>
        <body style='font-family: Arial, sans-serif; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #2563eb;'>Recuperación de Contraseña</h2>
                <p>Hola {$name},</p>
                <p>Has solicitado recuperar tu contraseña. Haz clic en el siguiente enlace para crear una nueva:</p>
                <p><a href='{$resetUrl}' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Recuperar Contraseña</a></p>
                <p>Este enlace expirará en 1 hora por seguridad.</p>
                <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
                <br>
                <p>Saludos cordiales,<br>El equipo de Rifas Chile</p>
            </div>
        </body>
        </html>";
    }

    private function getSaleNotificationTemplate($rifaName, $numbers, $total) {
        $numbersString = implode(', ', $numbers);
        $formattedTotal = ChileanHelper::formatCurrency($total);
        
        return "
        <html>
        <body style='font-family: Arial, sans-serif; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #2563eb;'>¡Confirmación de Compra!</h2>
                <p><strong>Rifa:</strong> {$rifaName}</p>
                <p><strong>Números comprados:</strong> {$numbersString}</p>
                <p><strong>Total pagado:</strong> {$formattedTotal}</p>
                <p>¡Mucha suerte en el sorteo!</p>
                <br>
                <p>Saludos cordiales,<br>El equipo de Rifas Chile</p>
            </div>
        </body>
        </html>";
    }
}
