<?php
	include_once 'includes/dbh.inc.php';
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>

</head>

<body>

	<div id="page-wrap">

		<textarea id="header">INVOICE</textarea>
		
		<div id="identity">
		
            <textarea id="address">Brgy. Arnedo, Bolinao
Pangasinan 2406 Philippines

Globe +63-917-683-6670
Smart +63-920-413-9272 </textarea>

            <div id="logo">

              <div id="logoctr">
                <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
                <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
                |
                <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
                <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
              </div>

              <div id="logohelp">
                <input id="imageloc" type="text" size="50" value="" /><br />
                (max width: 540px, max height: 100px)
              </div>
              <img id="image" src="images/logo.png" alt="logo" />
            </div>
		
		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">

            <textarea id="customer-title">BOOKING</textarea>
            <?php
            	$cust_id = $_SESSION['cust_id'];
            	$payment = $_SESSION['payment'];

            	$sql = "SELECT * FROM reservation
            	inner join customers on customers.cust_id = reservation.cust_id
            	inner join billing on billing.cust_id = reservation.cust_id 
          		where reservation.cust_id = '$cust_id'";
          		$result = mysqli_query($conn, $sql);
          		while($row = mysqli_fetch_assoc($result)){
          			$cust_first = $row['cust_first'];
          			$cust_last = $row['cust_last'];
          			$transactionID = $row['transaction_id'];
          			$total_amount = $row['total_amount'];
          			$balance = $row['balance'];
          			$amount_paid = $row['amount_paid'];
                    $checkin =  strtotime($row['checkin']);
                    $checkout =  strtotime($row['checkout']);
          		}
          		$sql = "select room_id from reservation where cust_id = '$cust_id'";
          		$result = mysqli_query($conn, $sql);
          		while($row = mysqli_fetch_assoc($result)){
          			$room_id = $row['room_id'];
          			$sql = "select * from rooms where room_id = '$room_id'";
          			$result = mysqli_query($conn, $sql);
          			while($row = mysqli_fetch_assoc($result)){
          			$room_type = $row['room_type'];
          			$room_description = $row['room_description'];
          			$room_rate = $row['room_rate'];
          		}	

          		}
            ?>
            <table id="meta">
                <tr>
                    <td class="meta-head">Transaction ID</td>
                    <td><textarea><?php echo $transactionID; ?></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Customer Name</td>
                    <td><textarea><?php echo $cust_first.' '.$cust_last; ?></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Date</td>
                    <td><textarea id="date"></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due">₱</div></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Night/s</th>
		      <th>Price</th>
		  </tr>
		  
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea><?php echo $room_type;?></textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea><?php echo date("j F Y",$checkin). " - " .date("j F Y",$checkout)?></textarea></td>
		      <td><textarea class="cost">₱<?php echo $room_rate.'.00';?></textarea></td>
		      <td><textarea class="qty"><?php 
                   $diff = abs(($checkout)  -  ($checkin));
                   $nights = abs(floor($diff / (60 * 60 * 24)));
                   echo $nights;
                ?></textarea></td>
		      <td><span class="price">₱</span></td>
		  </tr>
		  
		  
		  <tr id="hiderow">
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr>
		  
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">₱</div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">₱</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><textarea id="paid">₱<?php echo $amount_paid;?>.00</textarea></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due">₱</div></td>
		  </tr>
		
		</table>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>Reservations will be confirmed after 50% of the requested charges is deposited to our bank account, which will be sent to you upon request. You can get immediate confirmation by emailing us a scanned deposit slip.</textarea>
		</div>
	
	</div>
	
</body>

</html>