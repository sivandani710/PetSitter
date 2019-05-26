<?php
	require 'dbh.inc.php';
    //If is sign by gmail
	if (isset($_SESSION['access_token'])) {
		//Check is complete registration
		if (!isset($_SESSION['user-id'])) {
			if ($stmt = $conn->prepare("SELECT id, latitude, longitude FROM users WHERE oauth_uid=?")) {
				$auth_uid = $_SESSION['id'];
				//Bind parameters for
				$stmt->bind_param("s", $auth_uid);
		
				//Execute query 
				$stmt->execute();
				$stmt->store_result();
				//Save user-id
				$stmt->bind_result($id, $latitude, $longitude);
				if(!$stmt->fetch()){
					//User still not complete create
					header('Location: create-user.php');
					exit();
				} else {
					$_SESSION['user-id'] = $id;
					$_SESSION['user-latitude'] = $latitude;
					$_SESSION['user-longitude'] = $longitude;
				}
						
				//Free statement
				$stmt->free_result();
			} else {
				printf("Errormessage: %s\n", $conn->error);
			}
		}
	}
?>