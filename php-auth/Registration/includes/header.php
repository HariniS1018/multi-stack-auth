<?php ob_start(); ?>
<?php require_once("db.php"); ?>
<?php require_once("functions.php"); ?>
<?php if(isset($_SESSION['login']) || isAlreadyLoggedIN()) {header("location:index.php");} ?>
<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $current_page ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php

    require_once("vendor/autoload.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = SMTP_HOST;
    $mail->Port = SMTP_PORT;
    $mail->SMTPSecure = SMTP_ENCRYPTION;

    $mail->Username = EMAIL_USERNAME;
    $mail->Password = EMAIL_PASSWORD;

    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addReplyTo(TO_EMAIL, TO_NAME);
    $mail->isHTML(true); //set to false for plain text email
    
?>
