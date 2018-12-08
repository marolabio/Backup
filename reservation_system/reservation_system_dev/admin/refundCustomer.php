<?php 
  include_once 'includes/dbh.inc.php';
  session_start();

  if(isset($_POST['cust_id'])){
    $cust_id = $_POST['cust_id'];
    $refund = $_POST['refund'];
    
    
	if(is_numeric($_POST['refund'])){
	    
    if($_POST['refund'] < $_POST['amount_paid'] * .80){
        
      header("Location: ../admin/refund.php?error=insufficient");
      exit();
  
    }else{
        	    

      if($refund <= $_POST['amount_paid']){

            // Update status
            mysqli_query($conn , "UPDATE customers set cust_status = 'refunded' where cust_id = '$cust_id'");
            mysqli_query($conn , "UPDATE reservation set res_status = 'refunded' where cust_id = '$cust_id'");
            mysqli_query($conn , "UPDATE billing set bill_status = 'refunded' where cust_id = '$cust_id'");


            // Inserting records to reports table
            $res = mysqli_query($conn, "SELECT * FROM reservation
            where cust_id = '$cust_id' AND res_status = 'refunded'");
            $queryResults = mysqli_num_rows($res);
            $row = mysqli_fetch_array($res);
              
            // Update bill 
            mysqli_query($conn , "UPDATE billing SET refund = '$refund' WHERE cust_id = '$cust_id'");


            // Get id's
            $res_id = $row['res_id'];	
            $bill_id = $row['bill_id'];	
            $user_id = $_SESSION['u_id'];	
            $rep_status = "refunded";	
            
            // Insert into reports
            mysqli_query($conn , "INSERT INTO reports (cust_id, res_id, bill_id, user_id, rep_status) 
              values ('$cust_id','$res_id', '$bill_id','$user_id', '$rep_status')");



        $sql = "SELECT * from reservation where cust_id = '$cust_id'";
          $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              $quantity = $row['quantity'];

              for ($x = 1; $x <= $quantity; $x++){
                // Plus -1 to each room
                $sql = "update rooms set room_occupied = room_occupied - 1 where room_id = '$row[room_id]'";
                mysqli_query($conn, $sql);
              }

          }



            header("Location: ../admin/refund.php?refund=success");
            exit(); 

      }else{

        header("Location: ../admin/refund.php?high=notallowed");
        exit();

      }
    }
    
}else{
    
    header("Location: ../admin/refund.php?invalid=input");
    exit();

    
}

}

?>