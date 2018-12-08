<?php session_start(); ?>
<center>
<br>

<p>Hi, <?php echo $_SESSION['cust_name'];?>! </p>
   <p>Congratulations! You have successfully redeemed <?php echo $_SESSION['reward_name'];?>! We hope you enjoy your reward!</p>
   <p>Please present this code to the cashier: <b><?php echo $_SESSION['code']; ?></b></p> 
   <p><span style="color:red">Note: </span>This confirmation message was also sent to your email account.</p> 

   <a href="rewards.php">Go back</a>
</center>

