<?php
	session_start();
	include_once 'dbh.inc.php';

	if(isset($_SESSION['u_id'])){

		// Unset all session
		foreach($_SESSION as $key => $val){
      		unset($_SESSION[$key]);
		}
		
    	// Redirect
		header("Location: ../signin.php?logout=success");
		exit();

	}else{

		// Redirect
		header("Location: ../signin.php?logout=success");
		exit();

	}
?>