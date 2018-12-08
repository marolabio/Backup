<?php

if (isset($_POST['submit'])){

		// Insert code
		include_once 'dbh.inc.php';

		$first = ucwords(mysqli_real_escape_string($conn, $_POST['firstName']));
		$last = ucwords(mysqli_real_escape_string($conn, $_POST['lastName']));
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$pwd = mysqli_real_escape_string($conn, $_POST['password']);
		$pwd1 = mysqli_real_escape_string($conn, $_POST['password1']);

		// Error handlers
		// Check for empty fields

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
					$sql = "SELECT * from customers where cust_email = '$email'";
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
							$sql = "INSERT INTO customers (cust_first, cust_last, cust_email, cust_pwd, cust_load, cust_points) values ('$first', '$last', '$email', '$hashedPwd',0,0)";
							$success = mysqli_query($conn, $sql);

							if($success){
							
								header("Location: ../signin.php?register=success");
								exit();
									
							}else{
								header("Location: ../signin.php?register=unsuccessful");
								exit();
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
