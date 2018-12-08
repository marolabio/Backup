<?php
	
	include_once 'includes/dbh.inc.php';
	if (isset($_POST['user_id'])){
		
		$user_first = mysqli_real_escape_string($conn, $_POST['user_first']);
		$user_last = mysqli_real_escape_string($conn, $_POST['user_last']);
		$user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
		$user_uid = mysqli_real_escape_string($conn, $_POST['user_uid']);
		$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
		
		$sql = "UPDATE users SET user_first = '$user_first', user_last = '$user_last', user_email = '$user_email', user_uid = '$user_uid' where user_id = '$user_id'";
		mysqli_query($conn, $sql);
		
		header("Location: ../admin/users.php?edit=success");
		exit();	

	}

?>	

