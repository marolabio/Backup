	<?php 
	include_once 'includes/dbh.inc.php';
	
 if(isset($_POST['res_id'])){

 	$res_id = $_POST['res_id'];
 	$result = mysqli_query($conn , "SELECT * from reservation where res_id = '$res_id'");
	$row = mysqli_fetch_assoc($result);
	$cust_id = $row['cust_id'];
	
	$checkin = $row['checkin'];
	$checkout = $row['checkout'];
	$today = date('Y-m-d');

			
			// Check in customer
			mysqli_query($conn , "UPDATE reservation set res_status = 'checkedin' where res_id = '$res_id'");
			$sql = "SELECT * from reservation where res_status = 'checkin' AND cust_id = '$cust_id'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				$queryResults = mysqli_num_rows($result);

				if($queryResults == 0){
					$date = date('Y-m-d H:i:sa');
					mysqli_query($conn , "UPDATE customers set cust_status = 'checkedin', cust_checkin = '$checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set bill_status = 'checkedin' where cust_id = '$cust_id'");
				}

			header("Location: ../admin/checkin.php?checkin=success");
			exit();
	

	




}