<?php
	include_once 'includes/dbh.inc.php';
	session_start();
	
	if (isset($_POST['submit'])){
		
	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$contact = mysqli_real_escape_string($conn, $_POST['contact']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);

	
	//error handlers
	//check for empty fields
	
	if(empty($first) || empty($last)|| empty($contact) || empty($email) ){
		header("Location: ../transaction.php?guestDetails=empty");
		exit();
	}else {
		
		if(!preg_match("/^[a-zA-Z]/",$first) || !preg_match("/^[a-zA-Z]/",$last)){
			header("Location: ../transaction.php?guestDetails=invalid");
			exit();	
		}else{

			if(!preg_match("/^09[0-9][0-9]*$/",$contact)){
					header("Location: ../transaction.php?contactNumber=invalid");
					exit();	
			}
			
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../transaction.php?guestDetails=email");
				exit();	


				}else{

					// Convert to lowercase
					$first = strtolower($first);
					$last = strtolower($last);
					
					// Set to session
					$_SESSION['c_first'] = ucwords($first);
					$_SESSION['c_last'] = ucwords($last);
					$_SESSION['c_email'] = $_POST['email'];
					$_SESSION['c_contact'] = $_POST['contact'];
					header("Location: summary.php");
					exit();	


				}	

		}
	}
	
}else{
	header("Location: ../transaction.php");
	exit();
}