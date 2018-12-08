<?php
	session_start();
	include_once 'includes/dbh.inc.php';

	if (isset($_POST['submit'])){

		$first = $_SESSION['c_first'];
		$last = $_SESSION['c_last'];
		$contact = $_SESSION['c_contact'];
		$email = $_SESSION['c_email'];
		
		//Transaction ID	
		$result = "";
		$char = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$char = str_shuffle($char);
		$transaction_id = substr($char ,0 ,6);
		$_SESSION['transaction_id'] = $transaction_id;

		// Insert customer details to the database
		$sql = "INSERT INTO customers (cust_first, cust_last, cust_email, cust_contact, transaction_id, cust_status) values ('$first', '$last', '$email', '$contact', '$transaction_id', 'waiting')";


		// If inserted get cust_id
		if($conn->query($sql)===TRUE){
			$cust_id = $conn->insert_id;
		}

		// Get total bill
		$total = $_SESSION['total'];

		$sql = "INSERT INTO billing (cust_id, total_amount, balance, bill_status) values ('$cust_id', '$total','$total', 'pending')";
		
		// If inserted get bill id
		if($conn->query($sql)===TRUE){
			$bill_id = $conn->insert_id;
		}

            

		foreach ($_SESSION['reservations'] as $key => $room) {

			$cust_id = mysqli_real_escape_string($conn, $cust_id);
			$room_id = mysqli_real_escape_string($conn, $room['id']);
			$checkin = mysqli_real_escape_string($conn, $room['checkin']);
			$checkout = mysqli_real_escape_string($conn, $room['checkout']);
			$nights = mysqli_real_escape_string($conn, $room['nights']);
			$quantity = mysqli_real_escape_string($conn, $room['quantity']);
			$res_status = 'pending';
			$res_type = 'walk-in';


			for ($x = 1; $x <= $quantity; $x++){
				// Plus 1 to each room that will be occupied
				$sql = "UPDATE rooms set room_occupied = room_occupied + 1 where room_id = '$room_id'";
				mysqli_query($conn, $sql);
			}
	
			// Insert reservation
			$sql = "INSERT INTO reservation (cust_id, bill_id, room_id, quantity, nights, checkin, checkout, res_type, res_status) values ('$cust_id', '$bill_id', '$room_id', '$quantity', '$nights', '$checkin','$checkout', '$res_type', '$res_status')";

			// Set bill id of the customer
			if($conn->query($sql)===TRUE){
				$_SESSION['res_id'] = $conn->insert_id;

			}

		}


		// Unset sessions
		unset($_SESSION['c_first']);
		unset($_SESSION['c_last']);
		unset($_SESSION['c_contact']);
		unset($_SESSION['c_email']);
		unset($_SESSION['cust_email']);
		unset($_SESSION['reservations']);
		unset($_SESSION['rooms']);

		
		header("Location: reservation.php?walkin=success");
		exit();
}







	