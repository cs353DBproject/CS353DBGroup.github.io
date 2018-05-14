<?php
ob_start();
  session_start();

  $servername = "localhost";
  $username = "serdar.erkal";
  $password = "7ydo8hj2";
  $dbname = "serdar_erkal";
  // Create connection
  $conn = new mysqli($servername, $username, $password,$dbname);
  // Check connection
  if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
  }
  else{
    "Connected successfully";
  }
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $answer = $_POST['answer'];
  $secondary = $_POST['secondary'];
  $role = $_POST['role'];
  $birth_date = date('Y-m-d', strtotime($_POST['birth_date']));
  $date = date("Y/m/d");

  if (isset($_POST['signup_button'])){
    $sql = " insert into GeneralUser (username , email, password ,secret_question, answer) values ('".$username."','".$email."', '".$password."', '1' , '".$answer."') ;";
  	$result = $conn->query($sql);

  	$sql = " select id from GeneralUser where username = '".$username."' ";
  	$result = $conn->query($sql);
  	if($result->num_rows > 0){
					while($row = $result->fetch_assoc() ){
						$new_id = $row['id'];
					}
				}
  	$sql = " insert into LocationAdmin (user_id, role, secondary_email) values ('".$new_id."', '".$role."', '".$secondary."') ;";
  	$result = $conn->query($sql);
  }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<link href="css/create_manager.css" type="text/css" rel="stylesheet">
    </head>

    <body>
	<div class ="container-fluid bg">
		<div class ="row">
			<div class = "col-md-4 col-sm-4 col-xs-12"><div class="login-image"></div>​</div>
			<div class = "col-md-4 col-sm-4 col-xs-12">
			
			<form class= "form-container" role = "form" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" method = "post">
			<h1 align="center"> Create Account</h1>
			  <div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Username</label>
				<input type="input" name="username" class="form-control" id="exampleInputPassword1" placeholder="Username">
			  </div>			  
			  <div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Repeat Password</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Role</label>
				<input type="input" name="role" class="form-control" id="exampleInputPassword1" placeholder="Role">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Secondary e-mail</label>
				<input type="email" name="secondary" class="form-control" id="exampleInputPassword1" placeholder="e-mail">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Birth Date</label>
				<input type="Date" name="birth_date" class="form-control" id="Date" placeholder="Date">
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