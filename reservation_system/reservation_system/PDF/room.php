<?php
		
	$dbhost = 'localhost';
    $username = 'root';
    $password = 'roda28';
    $db = 'resortdb';
    $conn = mysqli_connect( $dbhost, $username, $password, $db );

    if(ISSET($_POST['submit'])){
        	$rName = $_POST['room_Name'];
        	$rRate = $_POST['room_Rate'];
        	$rQuantity = $_POST['room_Quantity'];
        	$rStatus = $_POST['room_Status'];

           // $sql='insert into room ( `roomName`,`roomRate`,`roomQuantity`,`roomStatus` ) values ( $rName, $rRate, $rQuantity, $rStatus)';
           //$query = mysqli_query($conn, $sql);

           	$sql = "INSERT INTO room (roomName, roomRate, roomQuantity, roomStatus) values ('$rName', '$rRate', '$rQuantity', '$rStatus')";
			mysqli_query($conn, $sql);
            echo 'The database was updated';
    }else{
			echo 'Update error.';

    }

?>
<!doctype html>
<html>
    <head>
        <title>Simple Form submission example</title>
    </head>
    <body>
        <form method='post' action ="index.php">
            Room Name:<input type='text' name='room_Name' /><br/><br/>
            Room Rate:<input type='text' name='room_Rate' /><br/><br/>
            Room Quantity:<input type='text' name='room_Quantity' /><br/><br/>
            Room Status:<input type='text' name='room_Status' /><br/><br/>

            <input type='submit' name = "submit" value='Submit' onclick ="update.php" />
            <input type='submit' name = "print" value='Print' onclick ="index.php" />


            <?php
                
            ?>
        </form>
    </body>
</html>


