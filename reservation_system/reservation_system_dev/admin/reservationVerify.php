<?php 
	
	include_once 'includes/dbh.inc.php';
	session_start();
	if(is_numeric($_POST['prepayment'])){
	
			if($_POST['prepayment'] < $_POST['balance'] / 2){
				header("Location: ../admin/reservation.php?error=insufficient");
				exit();
				
			}else{

				$cust_id = $_POST['cust_id'];
				$prepayment = $_POST['prepayment'];

				if($_POST['prepayment'] >= $_POST['balance'] ){

					mysqli_query($conn , "UPDATE billing set balance = '0' where cust_id = '$cust_id'");
					$change = $_POST['prepayment'] - $_POST['balance']; 
					$_SESSION['change'] = $change;

					// Update status
					mysqli_query($conn , "UPDATE reservation set res_status = 'checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE customers set cust_status = 'checkin' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set bill_status = 'checkin' where cust_id = '$cust_id'");


					// Get
					$result = mysqli_query($conn, "SELECT * FROM billing where cust_id = $cust_id");
					$row = mysqli_fetch_assoc($result);
					$bill_id = $row['bill_id'];
					$total_amount = $row['total_amount'];
					$user_id = $_SESSION["u_id"];
					
					// Update customer amount paid
					mysqli_query($conn , "UPDATE billing set amount_paid = '$total_amount' where cust_id = '$cust_id'");


					
					// Update transactions
					mysqli_query($conn, "INSERT into transaction (cust_id, bill_id, user_id, tran_amount, tran_change) 
								values ('$cust_id', '$bill_id', '$user_id','$prepayment', '$change')");


					// Send email
					$res = mysqli_query($conn, "SELECT * FROM reservation
					inner join customers on reservation.cust_id = customers.cust_id
		     		where reservation.cust_id = '$cust_id'");
		            while($row = mysqli_fetch_array($res)){
		                
		                $_SESSION['c_id'] = $row['cust_id'];
		                $c_email = $row['cust_email'];
		                $_SESSION['c_email'] = $c_email;
		                $res_type = $row['res_type'];
		                $_SESSION['verifypayment'] = $prepayment;

			        }

			        if($res_type == 'online'){

						include 'phpmailerVerify.php';

			        }else{

			        	header("Location: reservation.php?walkinfullpayment=success");
			        	exit();
			        }

				}else{
					// Update billing
					mysqli_query($conn , "UPDATE billing set balance = balance - '$prepayment' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set amount_paid = amount_paid + '$prepayment' where cust_id = '$cust_id'");

					// Update status
					mysqli_query($conn , "UPDATE reservation set res_status = 'confirmed' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE customers set cust_status = 'confirmed' where cust_id = '$cust_id'");
					mysqli_query($conn , "UPDATE billing set bill_status = 'confirmed' where cust_id = '$cust_id'");
					
					// Get
					$result = mysqli_query($conn,"SELECT * FROM billing where cust_id = $cust_id");
					$row = mysqli_fetch_assoc($result);
					$bill_id = $row['bill_id'];
					$user_id = $_SESSION["u_id"];
					
					// Update transactions
					mysqli_query($conn, "INSERT into transaction (cust_id, bill_id, user_id, tran_amount) 
								values ('$cust_id', '$bill_id', '$user_id','$prepayment')");


					// Send email
					$res = mysqli_query($conn, "SELECT * FROM reservation
					inner join customers on reservation.cust_id = customers.cust_id
		     		where reservation.cust_id = '$cust_id'");
		            while($row = mysqli_fetch_array($res)){
		                
		                $_SESSION['c_id'] = $row['cust_id'];
		                $c_email = $row['cust_email'];
		                $_SESSION['c_email'] = $c_email;
		                $res_type = $row['res_type'];
		                $_SESSION['verifypayment'] = $prepayment;

			        }

			        if($res_type == 'online'){

						include 'phpmailerVerify.php';

			        }else{

			        	header("Location: reservation.php?walkinprepayment=success");
			        	exit();
			        }
				}
			}
		

	}else{
		header("Location: ../admin/reservation.php?error=nonnumeric");
		exit();
	}