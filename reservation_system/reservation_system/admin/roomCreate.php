<?php

if (isset($_POST['submit'])){
	session_start();
	include_once 'includes/dbh.inc.php';
	
	$room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
	$room_description = mysqli_real_escape_string($conn, $_POST['room_description']);
	$room_rate = mysqli_real_escape_string($conn, $_POST['room_rate']);
	$room_quantity = mysqli_real_escape_string($conn, $_POST['room_quantity']);
	$room_max = mysqli_real_escape_string($conn, $_POST['room_max']);

	//error handlers
	//check for empty fields
	
	if(empty($room_type) || empty($room_description)|| empty($room_rate) || empty($room_quantity)||empty($room_max)){
		header("Location: ../admin/rooms.php?create=empty");
		exit();
	}else {

		
		//check if input characters are valid
		if(!preg_match("/^[a-zA-Z]/",$room_type)){
		header("Location: ../admin/rooms.php?roomtype=invalid");
		exit();	
		}else{

				$sql = "SELECT * from rooms where room_type ='$room_type'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if ($resultCheck > 0){
					header("Location: ../admin/rooms.php?create=taken");
					exit();	
					
				}else{
					
				    $sql = "INSERT INTO rooms (room_type, room_description, room_max, room_quantity, room_rate) values ('$room_type','$room_description','$room_max', '$room_quantity', '$room_rate')";

				    if($conn->query($sql)===TRUE){
						$_SESSION['room_id'] = $conn->insert_id;
					}
				}	
		}	
	
	}

}else{
	header("Location: ../admin/rooms.php");
	exit();
}

					//insert image	
					$file = $_FILES['file'];
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

			/*					//upload file to folder upload
								$fileNameNew = uniqid('', true).".".$fileActualExt;
								$fileDestination = 'upload/'.$fileNameNew;
								move_uploaded_file($fileTmpName, $fileDestination);*/

								$file = addslashes($fileTmpName);
								$file  = file_get_contents($file);
								$file  = base64_encode($file);
								saveimage($file);

								header("Location: ../admin/rooms.php?create=success");
								exit();	

							}else{
								echo "Your file is to big!";
							}
						}else{
							echo "There was an error uploading your file!";
						}

					}else{
						echo "You cannot upload files of this type!";
					}
			

				function saveimage($file){
					include_once 'includes/dbh.inc.php';
					$room_id = $_SESSION['room_id'];
					$sql = "Update rooms set room_img = '$file' where room_id = '$room_id'";
					$result = mysqli_query($conn, $sql);

						if($result){
							echo "image uploaded.";
						}else{
							echo "image not uploaded.";
						}
				}


		