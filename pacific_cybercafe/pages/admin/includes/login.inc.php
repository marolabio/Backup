<?php

session_start();

if (isset($_POST['submit'])){
	include_once 'dbh.inc.php';

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = mysqli_real_escape_string($conn, $_POST['password']);

	//error handlers
	//check if inputs are empty
	if (empty($email) || empty($pwd)){
		header("Location: ../index.php?signin=empty");
		exit();
	}else{
		$sql = "SELECT * FROM users where user_email = '$email'";
		$result = mysqli_query($conn,$sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1){
			header("Location: ../index.php?signin=error");
			exit();
			
		}else {
			if($row = mysqli_fetch_assoc($result)){
				//dehashing the password
				$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
				if ($hashedPwdCheck == false){
					header("Location: ../index.php?signin=error");
					exit();
			
				}elseif($hashedPwdCheck == true){

						// Redirect to diff account
						if($row['user_type'] == 'Admin' ){
				
							$_SESSION['u_id'] = $row['user_id'];
							$_SESSION['u_first'] = $row['user_first'];
							$_SESSION['u_last'] = $row['user_last'];
							$_SESSION['u_email'] = $row['user_email'];
							header("Location: ../transaction.php?login=success");
							exit();

						}else if($row['user_type'] == 'Manager'){
					
							$_SESSION['u_id'] = $row['user_id'];
							$_SESSION['u_first'] = $row['user_first'];
							$_SESSION['u_last'] = $row['user_last'];
							$_SESSION['u_email'] = $row['user_email'];
							header("Location: ../rewards.php?login=success");
							exit();

						}



					}
					
			
				}
				
			}
			
		}
		
	}else{
		header("Location: ../signin.php?signin=error");
		exit();
	}
