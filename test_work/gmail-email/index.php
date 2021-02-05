<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';
require_once '../components/settings_db.php';
require_once  '../class/parsing.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);

$parsObj = new parsing();
$parsObj->setUrl('https://dailyillini.com/news/');
$arrNewsLink = $parsObj->getNewsLink();
try {

    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = 'redisochko@gmail.com'; // YOUR gmail email
    $mail->Password = 'vlvqakbrvuunxfho'; // YOUR gmail password

    // Sender and recipient settings
    $sql = "SELECT email FROM users";
    $result = $pdo->query($sql);
    foreach ($result as $email) {
        $mail->setFrom($email['email'], 'Sender Name');
        $mail->addAddress($email['email'], 'Receiver Name');
        $mail->addReplyTo($email['email'], 'Sender Name'); // to set the reply to
    }
    // Setting the email content

    $sql = "SELECT link FROM links";
    $result = $pdo->query($sql);
    $links = [];
    foreach ($result as $item){

        if ($item['link'] != NULL) {
            $links[] = $item['link'];
        } else {
            return;
        }
    }
    $result = array_diff($arrNewsLink, $links);

    if (count($result) >= 1) {
        foreach ($result as $link) {

        $mail->IsHTML(true);
        $mail->Subject = "New news";
        $mail->Body = $link;
        $mail->AltBody = 'All for you';

        $mail->send();
        echo "Email message sent.";
        }
    }
    header('Location: http://example.com/test_work/index.php');
} catch (Exception $e) {
    echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}

?>
