<?php

if (isset($_POST['submit'])){

		// Insert code
		include_once 'dbh.inc.php';

		$first = ucwords(mysqli_real_escape_string($conn, $_POST['firstName']));
		$last = ucwords(mysqli_real_escape_string($conn, $_POST['lastName']));
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$pwd = mysqli_real_escape_string($conn, $_POST['password']);
		$pwd1 = mysqli_real_escape_string($conn, $_POST['password1']);
		$type = mysqli_real_escape_string($conn, $_POST['type']);

		//error handlers
		//check for empty fields

		if(empty($first) || empty($last)|| empty($email) || empty($pwd )){
			header("Location: ../register.php?register=empty");
			exit();
		}else {

			//check if input characters are valid
			if(!preg_match("/^[a-zA-Z]*$/",$first) || !preg_match("/^[a-zA-Z]*$/",$last)){
			header("Location: ../register.php?register=invalid");
			exit();
			}else{
				//check if email is valid
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					header("Location: ../register.php?register=email");
					exit();

				}else{
					$sql = "SELECT * from users where user_email = '$email'";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);

					if ($resultCheck > 0){
						header("Location: ../register.php?register=usertaken");
						exit();

					}else{

						if($pwd == $pwd1){
							//hashing the password
							$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
											

							//insert the user into the  database
							$sql = "INSERT INTO users (user_type, user_first, user_last, user_email, user_pwd) values ('$type', '$first', '$last', '$email', '$hashedPwd')";
							$success = mysqli_query($conn, $sql);

							if($success){
								
								echo "<script>window.alert('Success! Account has been created')</script>";
								echo "<script>window.location.href='../register.php?register=success'</script>";

							}else{
								echo 'Something went wrong!';
							}
						}else{
							header("Location: ../register.php?password=notMatching");
							exit();	
						}
					
					}

				}

			}
		}

}else{
	header("Location: ../register.php");
	exit();
}
