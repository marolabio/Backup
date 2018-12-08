<?php 
   
	if(isset($_POST['submit']) && isset($_POST['cust_id'])){
	    $cust_id = $_POST['cust_id'];
		$file = $_FILES['file'];
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];

		// Set
		$bank = $_POST['bank'];
		$msg = $_POST['message'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array('jpg', 'jpeg', 'png', 'pdf');

		if(in_array($fileActualExt, $allowed)){
			if($fileError === 0){
				if($fileSize < 10000000){

					$file = addslashes($fileTmpName);
					$file  = file_get_contents($file);
					$file  = base64_encode($file);
					saveimage($file, $cust_id, $bank, $msg);
					
				}else{
				
					echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Your file is too big!');
                    window.location.href='loginsuccess.php';
                	</script>");
				}
			}else{
			
				echo ("<script LANGUAGE='JavaScript'>
                    window.alert('There was an error uploading your file!');
                    window.location.href='loginsuccess.php';
                </script>");
			}

		}else{
		
			echo ("<script LANGUAGE='JavaScript'>
                    window.alert('You cannot upload files of this type!');
                    window.location.href='loginsuccess.php';
                </script>");
			
		}
}

	function saveimage($file, $cust_id, $bank, $msg){
		include_once 'includes/dbh.inc.php';
		$sql = "UPDATE customers SET cust_slip = '$file', bank_name = '$bank', message = '$msg' where cust_id = '$cust_id'";
		$result = mysqli_query($conn, $sql);

		// Insert Send to email here
				
			if($result){
				
                echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Success! Deposit slip has been sent. Please regularly check your email for updates of your payment.');
                    window.location.href='modifyLogout.php?send=success';
                </script>");
				
			}else{
			    
				echo ("<script LANGUAGE='JavaScript'>
					window.alert('Image not uploaded!');
					window.location.href='loginsuccess.php';
				</script>");
				
			}
	}

?>


