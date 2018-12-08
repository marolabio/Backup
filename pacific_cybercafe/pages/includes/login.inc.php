<?php

session_start();

if (isset($_POST['submit'])){
	include_once 'dbh.inc.php';

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = mysqli_real_escape_string($conn, $_POST['password']);

	//error handlers
	//check if inputs are empty
	if (empty($email) || empty($pwd)){
		header("Location: ../signin.php?signin=empty");
		exit();
	}else{
		$sql = "SELECT * FROM customers where cust_email = '$email'";
		$result = mysqli_query($conn,$sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1){
			header("Location: ../signin.php?signin=error");
			exit();
			
		}else {
			if($row = mysqli_fetch_assoc($result)){
				//dehashing the password
				$hashedPwdCheck = password_verify($pwd, $row['cust_pwd']);
				if ($hashedPwdCheck == false){
					header("Location: ../signin.php?signin=error");
					exit();
			
				}elseif($hashedPwdCheck == true){
					//log in the user here
						$_SESSION['c_id'] = $row['cust_id'];
						$_SESSION['c_first'] = $row['cust_first'];
						$_SESSION['c_last'] = $row['cust_last'];
						$_SESSION['c_email'] = $row['cust_email'];
						$_SESSION['c_load'] = $row['cust_load'];
						$_SESSION['c_points'] = $row['cust_points'];
						header("Location: ../home.php?login=success");
						exit();

					}
					
			
				}
				
			}
			
		}
		
	}else{
		header("Location: ../signin.php?signin=error");
		exit();
	}
