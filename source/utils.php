<?php
function acc_header() {
	session_start();
	
	if(!isset($_SESSION["id"])) {
		header("Location: ../index.php");
		exit();
	}
	
	// Create connection
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD);

	// Check connection
	if ($conn->connect_error) {
		if(CFG_DEBUG)
			die('An error occurred while connection database : ' . $conn->connect_error);
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
	
	mysqli_select_db($conn, DB_DATABASE);
	
	return $conn;
}

function get_acc($conn) {
	$id = mysqli_real_escape_string($conn, $_SESSION["id"]);
	$query = "SELECT * FROM GeneralUser WHERE username ='$id'";
	$result = $conn->query($query);
	
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while trying to fetch user information : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
	
	if($result->num_rows < 1) {
		session_unset();
		session_destroy();
		header("Location: ../index.php");
		exit();
	}
	
	return $result->fetch_assoc();
}