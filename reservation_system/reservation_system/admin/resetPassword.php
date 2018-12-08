<?php
	require_once "functions.php";
	include_once 'includes/dbh.inc.php';
	

	if (isset($_GET['email']) && isset($_GET['token'])) {

		$email = $conn->real_escape_string($_GET['email']);
		$token = $conn->real_escape_string($_GET['token']);

		$sql = $conn->query("SELECT user_id FROM users WHERE
			user_email='$email' AND token='$token' AND token<>'' AND token_expire > NOW()
		");

		if ($sql->num_rows > 0) {
			changePassword($email, $token);
		} else
			redirectToLoginPage();
	} else {
		redirectToLoginPage();
	}


?>

