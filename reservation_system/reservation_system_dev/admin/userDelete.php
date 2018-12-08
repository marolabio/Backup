<?php
		include_once 'includes/dbh.inc.php';
		//Delete User
		if(isset($_POST['user_id'])){
		$user_id = $_POST['user_id'];
		$sql = ("Delete from users where user_id = '$user_id'");
		$result = mysqli_query($conn, $sql);

		header("Location: ../admin/users.php?delete=success");
		exit();	
	}
?>