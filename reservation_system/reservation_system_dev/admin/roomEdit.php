<?php

	if (isset($_POST['r_id'])){
		
		include_once 'includes/dbh.inc.php';
		
		$room_id = mysqli_real_escape_string($conn, $_POST['r_id']);
		$room_type = mysqli_real_escape_string($conn, $_POST['r_type']);
		$room_description = mysqli_real_escape_string($conn, $_POST['r_description']);
		$room_max = mysqli_real_escape_string($conn, $_POST['r_max']);
		$room_quantity = mysqli_real_escape_string($conn, $_POST['r_quantity']);
		$room_rate = mysqli_real_escape_string($conn, $_POST['r_rate']);
		
		


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




					if($fileSize === 0 ){
						$sql = "UPDATE rooms SET room_type = '$room_type', room_description = '$room_description', room_max = '$room_max', room_quantity = '$room_quantity', room_rate = '$room_rate' where room_id = '$room_id'";
							mysqli_query($conn, $sql);
							header("Location: ../admin/rooms.php?edit=success");
							exit();	
					}else{

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

								$sql = "UPDATE rooms SET room_img = '$file', room_type = '$room_type', room_description = '$room_description', room_max = '$room_max' ,room_quantity = '$room_quantity', room_rate = '$room_rate' where room_id = '$room_id'";
								$result = mysqli_query($conn, $sql);

								if($result){
									echo "image uploaded.";
								}else{
									echo "image not uploaded.";
								}
										
								header("Location: ../admin/rooms.php?edit=success");
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
					}

					
	}

?>	

