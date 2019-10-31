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

if (empty($_POST["phonenumber"])) {
    $errorMSG = "Phone Number is required ";
} else {
    $phonenumber = $_POST["phonenumber"];
}

if (empty($_POST["message"])) {
    $errorMSG = "Message is required ";
} else {
    $message = $_POST["message"];
}

if (empty($_POST["terms"])) {
    $errorMSG = "Terms is required ";
} else {
    $terms = $_POST["terms"];
}

$Subject = "New message from Marketing page";

// prepare email body text
// $Body = "";
// $Body .= "Name: ";
// $Body .= $name;
// $Body .= "\n";
// $Body .= "Email: ";
// $Body .= $email;
// $Body .= "\n";
// $Body .= "Message: ";
// $Body .= $message;
// $Body .= "\n";
// $Body .= "Terms: ";
// $Body .= $terms;
// $Body .= "\n";

$success = sendMail("noreply@ordernexteats.com",$email,$name,$phonenumber,$Subject,$message,$terms);

function sendMail($submittedMail,$email,$name,$phonenumber,$Subject,$message,$terms){
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.office365.com";
    $mail->Port = 587; 
    $mail->Username = "noreply@ordernexteats.com";
    $mail->Password = "deemsys@123";
    $mail->SetFrom($submittedMail);
    $mail->Subject = $Subject;
    $mail->Body = '
    <html>
        <head>
            <title>Some title</title>
            <style>
                td {
                    padding:10px;
                }
            </style>
        </head>
        <body>
        <p>Hi admin,</p>
        <p>'.$name.', who contacted us through our site.</p>
            <table style="margin:30px;">
                <tr><td style="background:#ffa600;color:#fff">Name</td><td style="background-color:#f3f3f3">'.$name.'</td></tr>
                <tr><td style="background-color:#ffa600;color:#fff">Email</td><td style="background-color:#f3f3f3">'.$email.'</td></tr>
                <tr><td style="background-color:#ffa600;color:#fff">Phone Number</td><td style="background-color:#f3f3f3">'.$phonenumber.'</td></tr>
                <tr><td style="background-color:#ffa600;color:#fff">Message</td><td style="background-color:#f3f3f3">'.$message.'</td></tr>
                <tr><td style="background-color:#ffa600;color:#fff">Terms</td><td style="background-color:#f3f3f3">'.$terms.'</td></tr>
            </table>
        </body>
    </html>';
    $mail->AddAddress($submittedMail);
    $mail->IsHTML(true);  
    if(!$mail->Send()) {
        echo "error 1";
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    $mail->Subject = "Contact Submitted";
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
    <h2 align="center">Thank You for Contacting Us</h2>
    <p  align="center">We Will Contact You Soon...!!!</p>
    <p>Regards,</p>
    <p>Order Next Eats Team.</p>
    <hr>
    <p align="center"><i>This is an automatically generated message.</i></p>
    <p align="center"><i>Please do not reply directly to this email as it will go nowhere.</i></p>
    </body>
</html>';
    if(!$mail->Send()) {
        echo "error 2";
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