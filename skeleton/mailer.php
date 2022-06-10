<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\SMTP;

// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

// function sendEmail($subject,$message,$recipient){

//     $mail = new PHPMailer(true);
//     $mail->IsSMTP();
//     $mail->Host = 'smtp.gmail.com';               //Adresse IP ou DNS du serveur SMTP
//     $mail->Port = 465;                          //Port TCP du serveur SMTP
//     $mail->SMTPAuth = 1;                        //Utiliser l'identification
//     $mail->CharSet = 'UTF-8';
    
//     if($mail->SMTPAuth){
//        $mail->SMTPSecure = 'tls';               //Protocole de sécurisation des échanges avec le SMTP
//        $mail->Username   =  'loc.mns.ifa.57@gmail.com';    //Adresse email à utiliser
//        $mail->Password   =  '@loc57MNS';         //Mot de passe de l'adresse email à utiliser
//     }
    
//     $mail->From       = "ne-pas-repondre@locmns.com";                //L'email à afficher pour l'envoi
//     $mail->FromName   = "LocMNS";          //L'alias de l'email de l'emetteur
    
//     $mail->AddAddress($recipient);
    
//     $mail->Subject    =  $subject;                      //Le sujet du mail
//     $mail->WordWrap   = 50; 			       //Nombre de caracteres pour le retour a la ligne automatique
//     $mail->AltBody = $message; 	       //Texte brut
//     $mail->IsHTML(false);                                  //Préciser qu'il faut utiliser le texte brut
    
//     if (!$mail->send()) {
//           echo $mail->ErrorInfo;
//     } else{
//           echo 'Message bien envoyé';
//     }

// }

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//Load Composer's autoloader
//require 'vendor/autoload.php';
function sendEmail($subject,$message,$recipient){
//Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp-relay.sendinblue.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'laurent.scodro@gmail.com';                     //SMTP username
        $mail->Password   = 'M9sFyE2Rw5XcWK1f';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ne-pas-repondre@locmns.com', 'lolo le bg');
        $mail->addAddress($recipient);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}