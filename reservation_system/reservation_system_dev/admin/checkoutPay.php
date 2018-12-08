<?php 
	include_once 'includes/dbh.inc.php';
	session_start();
	
	if(isset($_POST['cust_id'])){

		if(is_numeric($_POST['payment'])){
	
			if($_POST['payment'] < $_POST['balance']){
				header("Location: ../admin/checkout.php?error=insufficient");
				exit();
				
			}else{

				$cust_id = $_POST['cust_id'];
				$payment = $_POST['payment'];
				$total_amount = $_POST['total_amount'];

				if($_POST['balance'] == 0){


                    header("Location: checkout.php?balance=0");
					exit();

				}else{


					if($_POST['payment'] >= $_POST['balance'] ){

					mysqli_query($conn , "update billing set balance = '0' where cust_id = '$cust_id'");

					mysqli_query($conn , "update billing set amount_paid = '$total_amount' where cust_id = '$cust_id'");

					$change = $_POST['payment'] - $_POST['balance']; 
					$_SESSION['change'] = $change;


					$result = mysqli_query($conn,"SELECT * FROM billing where cust_id = '$cust_id'");
					$row = mysqli_fetch_assoc($result);

					$bill_id = $row['bill_id'];
					$user_id = $_SESSION["u_id"];

					mysqli_query($conn, "INSERT into transaction (cust_id, bill_id, user_id, tran_amount, tran_change) values ('$cust_id', '$bill_id', '$user_id','$payment', '$change')");

                    header("Location: checkout.php?paid=successful");
					exit();
					
					}

				}
			}

		}else{

			header("Location: ../admin/checkout.php?error=nonnumeric");
			exit();
		}

	}else{
		header("Location: ../admin/checkin.php?=error");
		exit();	

	}
 ?>

