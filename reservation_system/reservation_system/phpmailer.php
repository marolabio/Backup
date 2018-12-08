<?php
require("/home/rockgard/public_html/PHPMailer_5.2.0/class.phpmailer.php");
$c_email = $_SESSION['c_email'];
$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "localhost";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "thesis@rockgardenresort.com";  // SMTP username
$mail->Password = "kVq(gsKLWFrv"; // SMTP password

$mail->From = "thesis@rockgardenresort.com";
$mail->FromName = "Rock Garden Resort";
$mail->addAddress($c_email);
      


ob_start(); //STARTS THE OUTPUT BUFFER
include('email.php');  //INCLUDES YOUR PHP PAGE AND EXECUTES THE PHP IN THE FILE
$page_content = ob_get_contents() ;  //PUT THE CONTENTS INTO A VARIABLE
ob_clean();  //CLEAN OUT THE OUTPUT BUFFER

$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = 'Reservation';
$mail->Body = $page_content;


if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}else{
  echo "Message has been sent"; 
  
   if(isset($_SESSION['res_id'])){ 


        unset($_SESSION['rooms']);
        unset($_SESSION['reservations']);
        unset($_SESSION['checkin']);
        unset($_SESSION['checkout']);
        unset($_SESSION['res_id']);
        unset($_SESSION['c_first']);
        unset($_SESSION['c_last']);
        unset($_SESSION['c_email']);
        unset($_SESSION['c_contact']);
        unset($_SESSION['total']);
            
        header("Location: ../booknow.php?reservation=success");
        exit();
    }

    if(isset($_SESSION['r_id'])){

        unset($_SESSION['rooms']);
        unset($_SESSION['reservations']);
        unset($_SESSION['checkin']);
        unset($_SESSION['checkout']);
        unset($_SESSION['res_id']);
        unset($_SESSION['c_first']);
        unset($_SESSION['c_last']);
        unset($_SESSION['c_email']);
        unset($_SESSION['c_contact']);
        unset($_SESSION['total']);
        
         
        header("Location: ../modify.php?modify=success");
        exit();
    }
}


?>
