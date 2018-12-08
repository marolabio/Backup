<?php
	
	
	if (isset($_POST['user_id'])){
        include 'includes/dbh.inc.php';

		$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
		$user_first = mysqli_real_escape_string($conn, $_POST['firstName']);
        $user_last = mysqli_real_escape_string($conn, $_POST['lastName']);
        $user_email = mysqli_real_escape_string($conn, $_POST['email']);

		
		$sql = "UPDATE users SET user_first = '$user_first', user_last = '$user_last', user_email = '$user_email' where user_id = '$user_id'";
		mysqli_query($conn, $sql);

		header('Location: register.php');
		exit();
		

	}

?>	

