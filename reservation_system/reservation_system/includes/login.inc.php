<?php

session_start();

if (isset($_POST['submit'])){
	include_once 'dbh.inc.php';
	
	
	$cust_email = trim(mysqli_real_escape_string($conn, $_POST['cust_email']));
	$transaction_id = trim(mysqli_real_escape_string($conn, $_POST['transaction_id']));
	
	//error handlers
	//check if inputs are empty
	if (empty($cust_email) || empty($transaction_id)){
		header("Location: ../modify.php?login=empty");
		exit();
	}else{
		$sql = "SELECT * FROM customers where transaction_id = '$transaction_id' AND cust_status = 'waiting'";
		$result = mysqli_query($conn,$sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1){
			header("Location: ../modify.php?transaction_id=error");
			exit();
			
		}else {
			while($row = mysqli_fetch_assoc($result)){
				
				
			
				if ($cust_email != $row['cust_email']){
					header("Location: ../modify.php?email=error");
					exit();
			
				}else{

				    //log in the user here
					$_SESSION['cust_id'] = $row['cust_id'];
					header("Location: ../loginsuccess.php?login=success");
					exit();   
				    }

			
				
				}
			}
			
		}
		
		
}else{
	header("Location: ../login.php?login=error");
	exit();
}
