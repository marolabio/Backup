<?php
	if($_POST["tran_id"]) {
        include 'includes/dbh.inc.php';
		$tran_id = $_POST["tran_id"];

		$sql = $conn->query("select * from transaction where tran_id = '$tran_id'");
		$row = mysqli_fetch_assoc($sql);
		$cust_id = $row['cust_id'];

		$conn->query("delete from transaction where tran_id = '$tran_id' and cust_id = '$cust_id'");
	    
     }
?>