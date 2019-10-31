<?php

require '../phpmailer/class.phpmailer.php';

$errorMSG = "";

if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

if (empty($_POST["email"])) {
    $errorMSG = "Email is required ";
} else {
    $email = $_POST["email"];
}

if (empty($_POST["select"])) {
    $errorMSG = "Select is required ";
} else {
    $select = $_POST["select"];
}

if (empty($_POST["terms"])) {
    $errorMSG = "Terms is required ";
} else {
    $terms = $_POST["terms"];
}

// $EmailTo = "yourname@domain.com";
$Subject = "New privacy request from Marketing page";
$newBody = "Thank You for Contacting Us";

// prepare email body text
// $Body = "";
// $Body .= '<b>Name: </b>';
// $Body .= $name;
// $Body .= '<br/><b> Email: </b>';
// $Body .= $email;
// $Body .= '<br/><b> Request: </b>';
// $Body .= $select;
// $Body .= '<br/><b>Terms: </b>';
// $Body .= $terms;
		
// send email
$success = sendMail("webteam.deem@gmail.com",$email, $select, $Subject, $newBody,$terms,$name);

function sendMail($submittedMail, $email, $select, $Subject, $newBody,$terms,$name){
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; 
    $mail->Username = "webteam.deem@gmail.com";
    $mail->Password = "webteam@#123";
    $mail->SetFrom($email,"DeemsysInc");
    $mail->Subject = $Subject;
    $mail->Body = '
    <html>
        <head>
            <title>Some title</title>
            <style>
                td {
                    padding:15px;
                }
            </style>
        </head>
        <body>
        <p>Hi admin,</p>
        <p>'.$name.', who contacted us through our site.</p>
            <table style="margin:25px;">
                <tr><td style="background:#ffa600;color:#fff">Name</td><td style="background-color:#f3f3f3">'.$name.'</td></tr>
                <tr><td style="background-color:#ffa600;color:#fff">Email</td><td style="background-color:#f3f3f3">'.$email.'</td></tr>
                <tr><td style="background-color:#ffa600;color:#fff">Request</td><td style="background-color:#f3f3f3">'.$select.'</td></tr>
                <tr><td style="background-color:#ffa600;color:#fff">Terms</td><td style="background-color:#f3f3f3">'.$terms.'</td></tr>
            </table>
        </body>
    </html>';
    $mail->AddAddress($submittedMail);
    $mail->IsHTML(true);  
    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    $mail->ClearAddresses();
    $mail->AddAddress($email);
    $mail->Body = '<html>
        <head>
            <title>Some title</title>
            <style>
                td {
                    padding:10px;
                }
            </style>
        </head>
        <body>
        <p>Hi '.$name.',</p>
        <p>'.$newBody.'</p>
        </body>
    </html>';
    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

// redirect to success page
if ($success && $errorMSG == ""){
   echo "success";
}else{
    if($errorMSG == ""){
        echo "Message has been sent";
    } else {
        echo $errorMSG;
    }
}
?>