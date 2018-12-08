<?php
	session_start();
	
	if(isset($_SESSION['cust_id'])){

		foreach($_SESSION as $key => $val){

    		if ($key != 'u_id' && $key != 'u_first'){

      			unset($_SESSION[$key]);

    		}
    	
		}
    	header("Location: ../modify.php?logout=success");
		exit();

	}else{

		header("Location: ../modify.php");
		exit();

	}

?>