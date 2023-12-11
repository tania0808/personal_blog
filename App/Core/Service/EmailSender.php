<?php

namespace App\Core\Service;

use App\Core\Exception\MailNotSentException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailSender
{
    /**
     * @throws MailNotSentException
     */
    public function send(
        string $email,
        string $fromName,
        string $subject,
        string $body
    ): void {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = $_ENV['GMAIL_HOST'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['GMAIL_PORT'];

            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASSWORD'];

            $mail->setFrom($email);
            $mail->addAddress($_ENV['GMAIL_USER']);

            $mail->addReplyTo($email);
            $mail->isHTML();
            //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->FromName = $fromName;

            $mail->send();
        } catch (Exception $e) {
            throw new MailNotSentException();
        }
    }
}
