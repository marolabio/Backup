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
		
		//check if input characters are valid

			if(!preg_match("/^09[1-9][0-9]*$/",$contact)){
					header("Location: ../transaction.php?contactNumber=invalid");
					exit();	
			}

			//check if email is valid
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../transaction.php?guestDetails=email");
				exit();	

				}else{

					$_SESSION['c_first'] =  ucwords($_POST['first']);
					$_SESSION['c_last'] =  ucwords($_POST['last']);
					$_SESSION['c_email'] = $_POST['email'];
					$_SESSION['c_contact'] = $_POST['contact'];
					header("Location: ../modifySummary.php");
					exit();	


				}	

			
	}
	
}else{
	header("Location: ../transaction.php");
	exit();
}