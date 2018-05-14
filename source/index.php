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
            if (isset($_POST['login']) && !empty($_POST['email']) 
               && !empty($_POST['password'])) {

               echo checkUser($_POST['email'],$_POST['password'],$conn);
               if ($_POST['password'] == checkUser($_POST['email'],$_POST['password'],$conn)) {
                                    
                  echo 'You have entered valid username and password';
                  header("Location:/~serdar.erkal/main_page/main_page.php");
                  exit;
               }
               else {
                  echo 'Wrong username or password';
               }
            }
            
            if (isset($_POST['login_admin']) && !empty($_POST['email']) 
               && !empty($_POST['password'])) {

               echo checkUser($_POST['email'],$_POST['password'],$conn);
               if ($_POST['password'] == checkUser($_POST['email'],$_POST['password'],$conn)) {
                                    
                  echo 'You have entered valid username and password';
                  header("Location:/~serdar.erkal/admin_page/admin_page.php");
                  exit;
               }
               else {
                  echo 'Wrong username or password';
               }
            }
            							//".$enteredName."
            function checkUser($enteredMail, $enteredPass,$connection) {
            	$sql = "select username from GeneralUser where email = '".$enteredMail."' AND password = '".$enteredPass."';";
				$result = $connection->query($sql);
				$sql1 = "select password from GeneralUser where email = '".$enteredMail."' AND password = '".$enteredPass."';";
				$result1 = $connection->query($sql1);

				if($result->num_rows > 0){
					while($row = $result->fetch_assoc() ){
						$_SESSION['id'] = $row['username'];
					}
				}

				if($result1->num_rows > 0){
					while($row = $result1->fetch_assoc() ){
						return $row['password'];
					}
				}
			}
			function checkPass($enteredPass) {
    			return $enteredPass;
			}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<link href="css/global.css" type="text/css" rel="stylesheet">
    </head>

    <body>

	<div class ="container-fluid bg">
		<div class ="row">
			<div class = "col-md-4 col-sm-4 col-xs-12"><div class="login-image"></div>​</div>
			<div class = "col-md-4 col-sm-4 col-xs-12">
			
			<form class= "form-container" role = "form" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" method = "post">
			<h1 align="center"> Login</h1>
			  <div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="Email" class="form-control" name="email" placeholder="Email" required autofocus>
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" class="form-control" name="password" placeholder="Password" required>
			  </div>
			  		  <!--- href="./main_page/main_page.html"-->
			  <button class = "btn btn-success btn-block" type = "submit" name = "login">Login</button>
			  <button class = "btn btn-success btn-block" type = "submit" name = "login_admin">Login as Admin</button>
			  <a href="./forgot_1/forgot_1.php" type="submit" class="btn .button1 btn-block">Forgot Password</a>
			  <a href="./create_account/create_account.php" type="submit" class="btn .button2 btn-block">Create Account</a>
			  <a href="./create_manager/create_manager.php" type="submit" class="btn .button2 btn-block">Create Manager Account</a>
			</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>