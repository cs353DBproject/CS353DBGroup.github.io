<?php
	require '../config.php';
	session_start();
	
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

  if (isset($_POST['check_button'])){
	$email = $_POST['email'];
	$answer = $_POST['answer'];
    $sql = " select * from GeneralUser where email = '".$email."' AND answer = '".$answer."';";
  	$result = $conn->query($sql);
  	if($result->num_rows > 0){
		while($row = $result->fetch_assoc() ){
			$_SESSION['id'] = $row['username'];
		}
		
		$sql = "SELECT * FROM User WHERE user_id = ".$row['id'];
		$result = $conn->query($sql);
		if($result->num_rows > 0)
			header("Location:../settings/settings.php");
		else
			header("Location:../admin_settings/admin_settings.php");
        exit;
	}
	else {
		echo "<script> alert('Email or the answer is wrong!');</script>";
	}
  }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<link href="css/forgot.css" type="text/css" rel="stylesheet">
    </head>

    <body>
	<div class ="container-fluid bg">
		<div class ="row">
			<div class = "col-md-4 col-sm-4 col-xs-12"><div class="login-image"></div>​</div>
			<div class = "col-md-4 col-sm-4 col-xs-12">
			
			<form class= "form-container" role = "form" method = "post">
			<h1 align="center"> Forgot Password</h1>
			  <div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" name = "email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Secret Question Answer</label>
				<input type="password" name = "answer" class="form-control" id="exampleInputPassword1" placeholder="Answer">
			  </div>
			  <button class="btn btn-success btn-block" type = "submit" name = "check_button">Check</button>
			</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>