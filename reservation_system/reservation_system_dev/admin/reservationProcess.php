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
	
	if(empty($first) || empty($last)){
		header("Location: ../admin/reservationTransaction.php?guestDetails=empty");
		exit();
	}else{
		
		//check if input characters are valid
		if(!preg_match("/^[a-zA-Z]/",$first) || !preg_match("/^[a-zA-Z]/",$last)){
			
            header("Location: ../admin/reservationTransaction.php?guestDetails=invalid");
			exit();	
		
		}else{

			if(empty($_POST['contact'])){
				$_SESSION['c_contact'] = 'N/A';
			}else{

				if(!preg_match("/^09[0-9][0-9]*$/",$contact)){
					header("Location: ../admin/reservationTransaction.php?contactNumber=invalid");
					exit();	
				}else{
					$_SESSION['c_contact'] = $contact;
				}
				
			}



			if(empty($_POST['email'])){
				$_SESSION['c_email'] = 'N/A';
			}else{

				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					header("Location: ../admin/reservationTransaction.php?guestDetails=email");
					exit();
				}else{
					$_SESSION['c_email'] = $email;
				}

			}

			// Convert to lowercase
			$first = strtolower($first);
			$last = strtolower($last);

			// Set session
			$_SESSION['c_first'] = ucwords($first);
			$_SESSION['c_last'] = ucwords($last);
			
			// Redirect
			header("Location: ../admin/reservationSummary.php");
			exit();	

		}
		
	}

	
}else{
	header("Location: ../reservationTransaction.php");
	exit();
}

