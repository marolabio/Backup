	<?php
	
	
	if (isset($_POST['reward_id'])){
        include 'includes/dbh.inc.php';

		$reward_id = mysqli_real_escape_string($conn, $_POST['reward_id']);
		$reward_name = mysqli_real_escape_string($conn, $_POST['reward_name']);
		$reward_points = mysqli_real_escape_string($conn, $_POST['reward_points']);
		$file = $_FILES['file']['name'];


		
		$sql = "UPDATE rewards SET reward_name = '$reward_name', reward_points = '$reward_points' where reward_id = '$reward_id'";
		mysqli_query($conn, $sql);
		
		if($file == ''){
			header("Location: rewards.php?edit=success");
			exit();

		}else
			$fileName = $_FILES['file']['name'];
			$fileTmpName = $_FILES['file']['tmp_name'];
			$fileSize = $_FILES['file']['size'];
			$fileError = $_FILES['file']['error'];
			$fileType = $_FILES['file']['type'];

			$fileExt = explode('.', $fileName);
			$fileActualExt = strtolower(end($fileExt));

			$allowed = array('jpg', 'jpeg', 'png', 'pdf');

			if(in_array($fileActualExt, $allowed)){
			if($fileError === 0){
				if($fileSize < 1000000){

				$file = addslashes($fileTmpName);
				$file  = file_get_contents($file);
				$file  = base64_encode($file);

				$sql = "Update rewards set reward_img = '$file' where reward_id = '$reward_id'";
				$result = mysqli_query($conn, $sql);
			
					if($result){
						header("Location: rewards.php?edit=success");
						exit();	
					}else{
					echo "image not uploaded.";
					}

				}else{
				echo "Your file is to big!";
				}
			}else{
				echo "There was an error uploading your file!";
			}

			}else{
			echo "You cannot upload files of this type!";
			}
		
	

	
	}

?>	


