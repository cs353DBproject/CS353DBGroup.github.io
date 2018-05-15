<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);
	
  if (isset($_POST['change_button'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$answer = $_POST['answer'];
	$birth_date = date('Y-m-d', strtotime($_POST['birth_date']));
	$secondary_email = $_POST['secondary_email'];
	$role = $_POST['role'];
  
    $sql = " update GeneralUser set email = '".$email."', password = '".$password."', answer = '".$answer."' where id = '".$acc['id']."';";
  	$result = $conn->query($sql);
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while trying to update GeneralUser: ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
  	
  	$sql = " update LocationAdmin set role = '".$role."' , secondary_email = '".$secondary_email."' where user_id = '".$acc['id']."' ;";
  	$result = $conn->query($sql);
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while trying to update LocationAdmin : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
	
	if(isset($_FILES['fileToUpload'])) {
		$file_name = $_FILES['fileToUpload']['name'];
		$file_size = $_FILES['fileToUpload']['size'];
		$file_tmp = $_FILES['fileToUpload']['tmp_name'];
		$file_type = $_FILES['fileToUpload']['type'];
		
		$file_ext = explode('.', $file_name);
		$file_ext = strtolower(end($file_ext));
		
		$expensions= array("jpeg","jpg","png");
		
		if(in_array($file_ext,$expensions)=== false) {
			echo "<script> alert('Only JPEG and PNG files are allowed!');</script>";
		}
		else {
			$file_name = "profile".$acc['id'].".png";
	
			if (file_exists("../images/".$file_name))
				unlink("../images/".$file_name);
			move_uploaded_file($file_tmp,"../images/".$file_name);
		}
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
		<link href="css/admin_settings.css" type="text/css" rel="stylesheet">
    </head>

    <body>
		<div class="topnav">
		  <a href="../admin_page/admin_page.php">Home</a>
		  <a href="../add_location/add_location.php">Add Location</a>
		  <a class="active" href="../admin_settings/admin_settings.php">Change Settings</a>
		  <a href="../change_loc_settings/change_loc_settings.php">Change Location Specifications</a>
		  <a href="../logout.php">Logout</a>
		  <div class="search-container">
		    <form action="../search_location/search_location.php">
		      <input type="text" placeholder="Search.." name="search">
		      <button type="submit"><i class="fa fa-search"></i></button>
		    </form>
		  </div>
		</div>

	<div class ="container-fluid bg">
		<div class ="row">
			<div class = "col-md-4 col-sm-4 col-xs-12"><div class="login-image"></div>​</div>
			<div class = "col-md-4 col-sm-4 col-xs-12">
			
			<form class= "form-container" role = "form" method = "post" enctype="multipart/form-data">
			<h1 align="center"> Change Account Settings</h1>
			  <div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" name= "email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" name= "password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Secret Question Answer</label>
				<input type="password" name= "answer" class="form-control" id="exampleInputPassword1" placeholder="Answer">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Birth Date</label>
				<input type="Date" name= "birth_date" class="form-control" id="exampleInputPassword1" placeholder="Date">
			  </div>
			  <div class="form-group">
				<label for="exampleInputEmail1">Secondary Email address</label>
				<input type="email" name= "secondary_email" class="form-control" id="exampleInputEmail1" placeholder="Secondary Email">
			  </div>
			  <div class="form-group">
				<label for="exampleInputEmail1">Role</label>
				<input type="text" name= "role" class="form-control" id="exampleInputEmail1" placeholder="Role">
			  </div>
				<div class="form-group">
				  <label for="exampleFormControlTextarea1">Picture</label>
				  <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
				</div>
			  <button class="btn btn-success btn-block" type = "submit" name = "change_button">Change Settings</button>
			</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>