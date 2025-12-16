<?php
    require_once("vendor/autoload.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    //define this constant in a separate file for security
    $mail->Host = SMTP_HOST; 
    $mail->Port = SMTP_PORT; 
    $mail->SMTPSecure = SMTP_ENCRYPTION; 
    $mail->Username = EMAIL_USERNAME; 
    $mail->Password = EMAIL_PASSWORD; 

    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addReplyTo(TO_EMAIL, TO_NAME);

    //recipient
    $mail->addAddress(RECIPIENT_EMAIL, RECIPIENT_NAME);
    $mail->isHTML(true); //set to false for plain text email
    $mail->Subject = EMAIL_SUBJECT;
    $mail->Body = "<div style='color:blue; font-size:20px; background-color:grey;'>" . EMAIL_MESSAGE . "</div>";
    
    //send the email
    if($mail->send()){
        echo "Email sent";
    }
    else{
        echo "Error: " . $mail->ErrorInfo;

    }
?>
