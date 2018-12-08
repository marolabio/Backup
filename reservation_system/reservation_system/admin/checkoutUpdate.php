<?php 
	include_once 'includes/dbh.inc.php';

	$total = $_POST['total'];
	$cust_id = $_POST['cust_id'];

	$sql = "UPDATE billing set total_amount = total_amount + '$total', balance = balance + '$total', additional = additional + '$total' where cust_id = '$cust_id'";
	mysqli_query($conn, $sql);

	// Add amenities 

	header("Location: checkout.php?update=success");
	exit();

?>