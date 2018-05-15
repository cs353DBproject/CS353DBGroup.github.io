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

  if (isset($_POST['signup_button'])){
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$squestion = mysqli_real_escape_string($conn, $_POST['squestion']);
	$answer = $_POST['answer'];
	$birth_date = date('Y-m-d', strtotime($_POST['birth_date']));
	$date = date("Y/m/d");
	
    $sql = " insert into GeneralUser (username , email, password ,secret_question, answer) values ('".$username."','".$email."', '".$password."', '".$squestion."' , '".$answer."') ;";
  	$result = $conn->query($sql);
	
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while trying to create an account : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}

  	$sql = " select id from GeneralUser where username = '".$username."' ";
  	$result = $conn->query($sql);
  	if($result->num_rows > 0){
					while($row = $result->fetch_assoc() ){
						$new_id = $row['id'];
					}
				}
  	$sql = " insert into User (user_id, register_date, birth_date,privacy,profile_pic,bio) values ('".$new_id."', '".$date."', '".$birth_date."','1', 'pictureofUser','bio') ;";
  	$result = $conn->query($sql);
	
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while trying to add account as user : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
	
	$_SESSION["id"] = $username;
	header("Location: ../main_page/main_page.php");
	exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<link href="css/create_account.css" type="text/css" rel="stylesheet">
    </head>

    <body>
	<div class ="container-fluid bg">
		<div class ="row">
			<div class = "col-md-4 col-sm-4 col-xs-12"><div class="login-image"></div>​</div>
			<div class = "col-md-4 col-sm-4 col-xs-12">
			
			<form class= "form-container" role = "form" method = "post">
			<h1 align="center"> Create Account</h1>
			  <div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" name= "email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Username</label>
				<input type="input" name = "username" class="form-control" id="exampleInputPassword1" placeholder="Username">
			  </div>			  
			  <div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" name = "password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Repeat Password</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			  </div>
			  <div class="form-group">
				<label for="squestion">Secret Question</label>
				<select name="squestion" class="form-control">
					<option value="0">What is the name of your last school?</option>
					<option value="1">What is the name of your pet?</option>
				</select>
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Secret Question Answer</label>
				<input type="input" name = "answer" class="form-control" id="exampleInputPassword1" placeholder="Answer">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Birth Date</label>
				<input type="Date" name = "birth_date" class="form-control" id="Date" placeholder="Date">
			  </div>	
			  <button class="btn btn-success btn-block" type = "submit" name = "signup_button">Sign Up</button>  
			  <a href="../index.php" type="submit" class="btn btn-success btn-block">Return to Sign-in</a>
			</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>