<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	
  $email = $_POST['email'];
  $password = $_POST['password'];
  $answer = $_POST['answer'];
  $birth_date = date('Y-m-d', strtotime($_POST['birth_date']));
  $var = $_GET['var'];
  
  $sql = " select id from GeneralUser where username = '".$var."' ";
  	$result = $conn->query($sql);
  	if($result->num_rows > 0){
					while($row = $result->fetch_assoc() ){
						$new_id = $row['id'];
					}
				}

  if (isset($_POST['change_button'])){
    $sql = " update GeneralUser set email = '".$email."', password = '".$password."', answer = '".$answer."' where id = '".$new_id."';";
  	$result = $conn->query($sql);

  	$sql = " update User set birth_date = '".$birth_date."' where id = '".$new_id."';";
  	$result = $conn->query($sql);
    
    $id = $_SESSION['id'];
	$_SESSION['id'] = $id;
  }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<link href="css/settings.css" type="text/css" rel="stylesheet">
    </head>

    <body>
    	<div class="topnav">
		  <a  href="../main_page/main_page.php?var=<?php echo $id ?>">Home</a>
		  <a href="../friends/friends.php?var=<?php echo $id ?>">Friends</a>
		  <a href="../myProfile/myProfile.php?var=<?php echo $id ?>">myProfile</a>
		  <a class="active" href="../settings/settings.php?var=<?php echo $id ?>">Settings</a>
		  <a href="../index.php">Logout</a>
		  <div class="search-container">
		    <form action="../search_location/search_location.php">
		      <input type="text" placeholder="Search.." name="search">
		      <button class="button">?</button>
		    </form>
		  </div>
		</div>

	<div class ="container-fluid bg">
		<div class ="row">
			<div class = "col-md-4 col-sm-4 col-xs-12"><div class="login-image"></div>​</div>
			<div class = "col-md-4 col-sm-4 col-xs-12">
			
			<form class= "form-container" role = "form" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" method = "post">
			<h1 align="center"> Change Account Settings</h1>
			  <div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" name= "email" class="form-control" id="exampleInputEmail1" placeholder="Email">
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
				<label for="exampleInputPassword1">Secret Question Answer</label>
				<input type="input" name = "answer" class="form-control" id="exampleInputPassword1" placeholder="Answer">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Birth Date</label>
				<input type="Date" name = "birth_date" class="form-control" id="Date" placeholder="Date">
			  </div>
			  <form method="POST" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" enctype="multipart/form-data">
				 <input type="file" name="myimage">
				 <input type="submit" name="submit_image" value="Upload">
				</form>
			  <button class="btn btn-success btn-block" type = "submit" name = "change_button">Change Settings</button>
			</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>