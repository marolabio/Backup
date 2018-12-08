<?php
	session_start();
	include_once 'dbh.inc.php';

	if(isset($_SESSION['u_id'])){
		// Update last login
		$date = date('Y-m-d g:i:s');
		$sql = "update users set last_login = '$date' where user_id = '$_SESSION[u_id]'";
		mysqli_query($conn, $sql);

		// Unset all session
		foreach($_SESSION as $key => $val){
      		unset($_SESSION[$key]);
    	}
		
		// Redirect
		header("Location: ../login.php");
		exit();

	}else{

		// Redirect
		header("Location: ../login.php");
		exit();

	}
?>