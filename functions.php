<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

function generateVerificationCode($length = 6) {
    return str_pad(random_int(0, 999999), $length, '0', STR_PAD_LEFT);
}

function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->Port = 1025; // MailHog default
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false;

        // Recipients
        $mail->setFrom('noreply@ghtimeline.local', 'GH Timeline');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your GH-timeline Verification Code';
        $mail->Body = "Your verification code is: <b>$code</b>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

function registerEmail($email) {
    $file = __DIR__ . '/subscribers.txt';
    file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX);
}

function fetchGitHubTimeline($username) {
    $url = "https://api.github.com/users/$username/events/public";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'GH-timeline-app'); // GitHub requires a User-Agent
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log('cURL error: ' . curl_error($ch));
    }

    curl_close($ch);
    return $response;
}
