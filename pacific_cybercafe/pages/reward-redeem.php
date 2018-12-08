<?php
    include_once "includes/dbh.inc.php";
    session_start();
    $cust_id = $_POST['cust_id'];
    $reward_id = $_POST['reward_id'];
    $cust_email = $_POST['cust_email'];
    
    // Insert data to redeem table
    $sql = "INSERT INTO redeem (cust_id, reward_id) VALUES ('$cust_id', '$reward_id')";
    
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;

        $sql = "SELECT rewards.reward_name, rewards.reward_points,
                CONCAT(cust_first, ' ', cust_last) AS cust_name, redeem.created_at
                FROM redeem
                INNER JOIN customers on customers.cust_id = redeem.cust_id
                INNER JOIN rewards on rewards.reward_id = redeem.reward_id
                where redeem.redeem_id = '$last_id'";

        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        $cust_name = $row['cust_name'];
        $reward_name = $row['reward_name'];
        $reward_points = $row['reward_points'];
        $created_at = strtotime($row['created_at']);
        $created_at = date(strtotime('+3 days'), $created_at);
        $expires = date('j F Y h:i:s A', $created_at);


        // Generate promo code
	    $char = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$char = str_shuffle($char);
		$code = substr($char ,0 ,6);
        
        // Update redeem table
        $conn->query("UPDATE redeem set code = '$code', expiration=DATE_ADD(NOW(), INTERVAL +3 DAY) where redeem_id = '$last_id'");

        // Update customers points
        $conn->query("UPDATE customers set cust_points = cust_points - '$reward_points' where cust_id = '$cust_id'");


    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Send email
    if($result){
        

        $admin_email = $cust_email;
        $email = "thesis@rockgardenresort.com";
        $subject = "Redeem Reward";
        $body = "
            Hi, $cust_name
            Congratulations! You have successfully redeemed $reward_name! We hope you enjoy your reward!
            
            Please present this code to the cashier: $code 
            This reward is valid until $expires
            
            Pacific Cybercafe
        
        ";
        
        //send email
        if(mail($admin_email, "$subject", $body, "From:" . $email)){
            $_SESSION['cust_name'] = $cust_name;
            $_SESSION['reward_name'] = $reward_name;
            $_SESSION['code'] = $code;

            echo "<script>window.alert('Success! Details has been sent to your email')</script>";
            echo "<script>window.location.href='confirmed.php'</script>";
        }
    }else{
        echo "Something went wrong";
    }

   
