 <?php 
	include_once 'includes/dbh.inc.php';
	session_start();
 if(is_numeric($_POST['checkinPayment'])){
		
			if($_POST['checkinPayment'] < $_POST['balance']){
				
				header("Location: ../admin/confirmed.php?error=insufficient");
				exit();

			}else{

				$cust_id = $_POST['cust_id'];
				$checkinPayment = $_POST['checkinPayment'];

				if($_POST['checkinPayment'] >= $_POST['balance'] ){

					mysqli_query($conn , "update billing set balance = '0' where cust_id = '$cust_id'");
					$change = $_POST['checkinPayment'] - $_POST['balance']; 
					$_SESSION['change'] = $change;

					mysqli_query($conn , "update reservation set res_status = 'checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "update customers set cust_status = 'checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "update billing set bill_status = 'checkin' where cust_id = '$cust_id'");


					$result = mysqli_query($conn,"SELECT * FROM billing where cust_id = $cust_id");
					$row = mysqli_fetch_assoc($result);
					$bill_id = $row['bill_id'];
					$total_amount = $row['total_amount'] - $row['discount'];
					$user_id = $_SESSION["u_id"];

					// Update customer bill
					mysqli_query($conn , "UPDATE billing set amount_paid = '$total_amount' where cust_id = '$cust_id'");

					// Insert into transaction
					mysqli_query($conn, "INSERT into transaction (cust_id, bill_id, user_id, tran_amount, tran_change) values ('$cust_id', '$bill_id', '$user_id','$checkinPayment', '$change')");
   
				}else{

					mysqli_query($conn , "UPDATE billing set balance = balance - $checkinPayment where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE reservation set res_status = 'checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE customers set cust_status = 'checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set bill_status = 'checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set amount_paid = amount_paid + $checkinPayment where cust_id = '$cust_id'");


					$result = mysqli_query($conn,"SELECT * FROM billing where cust_id = $cust_id");
					$row = mysqli_fetch_assoc($result);
					$bill_id = $row['bill_id'];
					$user_id = $_SESSION["u_id"];

					// Insert into transaction
					mysqli_query($conn, "INSERT into transaction (cust_id, bill_id, user_id, tran_amount) values ('$cust_id', '$bill_id', '$user_id','$checkinPayment')");

				}

			    	header("Location: ../admin/confirmed.php?checkin=success");
					exit();

			}

	}else{
		header("Location: ../admin/confirmed.php?error=nonnumeric");
		exit();
	}