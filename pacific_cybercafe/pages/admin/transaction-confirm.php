<?php

 	if($_POST["tran_id"]) {
		include 'includes/dbh.inc.php'; 
		session_start();

 		$tran_id = $_POST["tran_id"];

 		$sql = $conn->query("select * from transaction where tran_id = '$tran_id'");
 		$row = mysqli_fetch_assoc($sql);
			 $cust_id = $row['cust_id'];
			 $user_id = "$_SESSION[u_id]";
			 $tran_amount = $row['tran_amount'];
			 $points = $tran_amount / 20;

			 $conn->query("Update customers set cust_load = cust_load + '$tran_amount' where cust_id = '$cust_id'");
			 $conn->query("Update customers set cust_points = cust_points + '$points' where cust_id = '$cust_id'");
			 $conn->query("Update transaction set tran_status = 'confirmed' where tran_id = '$tran_id'");

			//  Insert data to reports
			 $conn->query("INSERT INTO reports (cust_id, tran_id, user_id) VALUES ('$cust_id','$tran_id','$user_id')");
	    
     }
?>