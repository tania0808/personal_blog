<?php

namespace App\Models;

use App\Core\Application;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ContactForm extends Model
{
    public string $subject = '';
    public string $name = '';

    public string $email = '';
    public string $body = '';

    public function rules(): array
    {
        return [
            'subject' => [self::RULE_REQUIRED],
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'body' => [self::RULE_REQUIRED],
        ];
    }

    public function sendMail(){

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = $_ENV['GMAIL_HOST'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['GMAIL_PORT'];

            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_PASSWORD'];

            $mail->setFrom($this->email);
            $mail->addAddress($_ENV['GMAIL_USER']);

            $mail->addReplyTo($this->email);
            $mail->isHTML(true);
            //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;
            $mail->FromName = $this->name;

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}