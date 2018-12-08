<?php

if(isset($_POST["view"])){
 session_start();
 include("includes/dbh.inc.php");

 if($_POST["view"] == 'yes'){
  $sql = "UPDATE notification SET status=1 WHERE status=0 AND to_cust = '$_SESSION[c_email]'";
  mysqli_query($conn, $sql);
 }else{

 $sql = "SELECT * FROM notification 
 inner join customers on customers.cust_id = notification.cust_id
 where to_cust = '$_SESSION[c_email]' ORDER BY 'notif_id' DESC LIMIT 5";
 $result = mysqli_query($conn, $sql);
 $output = '';
 
 if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_array($result)){
   $output .= '
   <li>
    <a href="#">
     <strong>'.$row["amount"].' points was transfered to your account by <br>' . $row['cust_email'] . '</strong><br />
     <small><em>'.$row["message"].'</em></small>
    </a>
   </li>
   <li class="divider"></li>
   ';
  }
 }else{
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }

}
 
 $query = "SELECT * FROM notification WHERE status=0 AND to_cust = '$_SESSION[c_email]'";
 $result1 = mysqli_query($conn, $query);
 $count = mysqli_num_rows($result1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>