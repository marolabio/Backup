<?php

    //use PHPMailer\PHPMailer\PHPMailer;
    include_once 'includes/dbh.inc.php';
    require("/home/rockgard/public_html/PHPMailer_5.2.0/class.phpmailer.php");
    require_once "functions.php";

    if (isset($_POST['email'])) {

        $email = $conn->real_escape_string($_POST['email']);

        $sql = $conn->query("SELECT user_id FROM users WHERE user_email = '$email'");
        if ($sql->num_rows > 0) {

            $token = generateNewString();
            echo $token;
            
	        $conn->query("UPDATE users SET token='$token', 
                      token_expire=DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                      WHERE user_email='$email'
            ");


	        $mail = new PHPMailer();
            $mail->From = "thesis@rockgardenresort.com";
            $mail->FromName = "Rock Garden Resort";
	        $mail->addAddress($email);
	        $mail->setFrom("", "");
	        $mail->Subject = "Reset Password";
	        $mail->isHTML(true);
	        $mail->Body = "
	            Hi,<br><br>
	            
	            In order to reset your password, please click on the link below:<br>
	            <a href='
	            http://rockgardenresort.com/admin/resetPassword.php?email=$email&token=$token
	            '>http://rockgardenresort.com/admin/resetPassword.php?email=$email&token=$token</a><br><br>
	            If you don’t use this link within 5 minutes, it will expire. To get a new password reset link, visit rockgardenresort.com/admin/forgotPassword.php
                <br><br>
	            Kind Regards,<br>
	            Rock Garden Resort
	        ";

	        if ($mail->Send()){

    	        exit(json_encode(array("status" => 1, "msg" => 'Check your email for a link to reset your password. If it doesn’t appear within a few minutes, check your spam folder.')));

            }else{
    	        exit(json_encode(array("status" => 0, "msg" => 'Something Wrong Just Happened! Please try again!')));
            }

        } else
            exit(json_encode(array("status" => 0, "msg" => 'Please check your inputs!')));
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password System</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4" align="center">
                <div class="form-group well">
                <a href="login.php"><img  width="200px" src="../img/RGR_LOGO.png"></a><br><br>
                <p>Enter your email address and we will send you a link to reset your password.</p>
                <input class="form-control" type="email" id="email" placeholder="Your Email Address" ><br>
                <input type="button" class="btn btn-success" value="Send reset password email">
                <br><br>
                <p id="response"></p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        

        $(document).ready(function () {

            $('.btn-success').on('click', function () {
                 var email = $("#email");

                if (email.val() != "") {
                    email.css('border', '1px solid green');

                    $.ajax({
                       url: 'forgotPassword.php',
                       method: 'POST',
                       dataType: 'json',
                       data: {
                           email: email.val()
                       }, success: function (response) {
                        
                            if (!response.success){
                                $("#response").html(response.msg).css('color', "red");

                            }else{
                                $("#response").html(response.msg).css('color', "green");
                            }
                        }
                    });
                } else
                    email.css('border', '1px solid red');
            });
        });
    </script>
</body>
</html>
