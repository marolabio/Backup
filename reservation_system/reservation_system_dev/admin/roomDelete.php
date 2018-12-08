<?php
	//Delete Room
	
	if(isset($_POST['room_id'])){
		include_once 'includes/dbh.inc.php';
		$room_id = $_POST['room_id'];
		$sql = ("Delete from rooms where room_id = '$room_id'");
		$result = mysqli_query($conn, $sql);

		header("Location: ../admin/rooms.php?delete=success");
		exit();	
	}
?>	



