<?php
	require 'config.php';
	require 'utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);
	
	if(!isset($_GET["comment_id"])) {
		header("Location: index.php");
		exit();
	}
	
	$query = "INSERT INTO comment_reports VALUES(".$acc['id'].", ".mysqli_real_escape_string($conn, $_GET["comment_id"]).")";
	$result = $conn->query($query);
	
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while reporting comment : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
			
	echo "<script> alert('Comment has been succesfully reported'); window.location.href='".$_SERVER["HTTP_REFERER"]."';</script>";