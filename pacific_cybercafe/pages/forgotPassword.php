<?php

    //use PHPMailer\PHPMailer\PHPMailer;
    include_once 'includes/dbh.inc.php';
    require("/home/rockgard/public_html/PHPMailer_5.2.0/class.phpmailer.php");
    require_once "functions.php";

    if (isset($_POST['email'])) {

        $email = $conn->real_escape_string($_POST['email']);

        $sql = $conn->query("SELECT * FROM customers WHERE cust_email = '$email'");
        if ($sql->num_rows > 0) {

            $token = generateNewString();
            echo $token;

	        $conn->query("UPDATE customers SET token='$token',
                      tokenExpire=DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                      WHERE cust_email='$email'
            ");


	        $mail = new PHPMailer();
            $mail->From = "thesis@rockgardenresort.com";
            $mail->FromName = "Pacific Cybercafe";
	        $mail->addAddress($email);
	        $mail->setFrom("", "");
	        $mail->Subject = "Reset Password";
	        $mail->isHTML(true);
	        $mail->Body = "
	            Hi,<br><br>

	            In order to reset your password, please click on the link below:<br>
	            <a href='
	            http://rockgardenresort.com/pacific/resetPassword.php?email=$email&token=$token
	            '>http://rockgardenresort.com/pacific/resetPassword.php?email=$email&token=$token</a><br><br>
	            If you don’t use this link within 5 minutes, it will expire. To get a new password reset link, visit rockgardenresort.com/pacific/forgotPassword.php
                <br><br>
	            Kind Regards,<br>
	            Pacific Cybercafe
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	   <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="bg">
    <div class="container" id="panel">

        <div class="row">
            <div class="col-md-6 offset-md-3" style="background: white; text-align: center; padding: 20px;">
                <div class="panel-heading">
                    <h1>Pacific Cybercafe</h1>
                </div>
                <hr>
                <div class="form-group">
                <p>Enter your email address and we will send you a link to reset your password.</p>
                <input class="form-control" type="email" id="email" placeholder="Your Email Address" ><br>
                <input type="button" class="btn btn-success" value="Send reset password email">
                <br><br>
                <p id="response"></p>
                </div>
            </div>
        </div>
    </div>

   

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

                            if (!response.success)
                                $("#response").html(response.msg).css('color', "red");

                            else
                                $("#response").html(response.msg).css('color', "green");

                        }
                    });
                } else
                    email.css('border', '1px solid red');
            });
        });
    </script>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</body>
</html>
