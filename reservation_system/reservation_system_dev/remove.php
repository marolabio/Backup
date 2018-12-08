<?php
	session_start();
	include_once 'includes/dbh.inc.php';	
	//Cancel
	if(isset($_SESSION['r_id'])){
    	unset($_SESSION['r_id']); 
    	unset($_SESSION['cust_id']); 
    	unset($_SESSION['checkin']); 
    	unset($_SESSION['checkout']); 
    	unset($_SESSION['r_type']);
    	unset($_SESSION['r_rate']);
    	unset($_SESSION['nights']);
		header("Location: ../booknow.php?remove=success");
		exit();	
		
	}
?>