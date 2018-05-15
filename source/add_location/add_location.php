<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);
  
  if (isset($_POST['add_loc'])){
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$address = mysqli_real_escape_string($conn, $_POST['address']);
	$info = mysqli_real_escape_string($conn, $_POST['info']);
    $sql = " insert into Location (admin_id, name, address, info) values ('".$acc['id']."','".$name."','".$address."','".$info."') ;";
	$result = $conn->query($sql);
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while trying to add location : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
	$loc_id = mysqli_insert_id($conn);
	
	
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['fileToUpload']['name'])));
    
    $expensions= array("jpeg","jpg","png");
    
    if(in_array($file_ext,$expensions)=== false) {
		echo "<script> alert('Only JPEG and PNG files are allowed!');</script>";
    }
	else {
		$sql = "INSERT INTO Photo (loc_id, title) values (".$loc_id.",'".$name."')";
		$result = $conn->query($sql);
		if(!$result) {
			if(CFG_DEBUG)
				die('An error occurred while trying to add photo : ' . mysqli_error($conn));
			else
				die('An error occurred. We will look at it as soon as possible!');
		}
		$photo_id = mysqli_insert_id($conn);
		$file_name = "locImage".$loc_id."-".$photo_id.".png";
		move_uploaded_file($file_tmp,"../images/".$file_name);
		header("Location: ../location/location.php?search=".$_POST['name']);
		exit();
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
		<link href="css/add_location.css" type="text/css" rel="stylesheet">
    </head>

    <body>
<div class="topnav">
  <a href="../admin_page/admin_page.php">Home</a>
  <a class="active" href="../add_location/add_location.php">Add Location</a>
  <a href="../admin_settings/admin_settings.php">Change Settings</a>
  <a href="../change_loc_settings/change_loc_settings.php">Change Location Specifications</a>
  <a href="../logout.php">Logout</a>
  <div class="search-container">
    <form action="../search_location_admin/search_location_admin.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
	
	<div class ="container-fluid bg">
		<div class ="row">
			<div class = "col-md-4 col-sm-4 col-xs-12"><div class="login-image"></div>​</div>
			<div class = "col-md-4 col-sm-4 col-xs-12">
			<br><br>
			<form class= "form-container" role = "form" method = "post" enctype="multipart/form-data">
				  <div class="form-group">
				    <label for="exampleFormControlInput1">Location Name</label>
				    <input name ="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Location Name">
				  </div>
				  <div class="form-group">
				    <label for="exampleFormControlInput1">Address</label>
				    <input name ="address" type="text" class="form-control" id="exampleFormControlInput1" placeholder="adress">
				  </div>
				  <div class="form-group">
				    <label for="exampleFormControlTextarea1">Info</label>
				    <textarea name ="info" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
				  </div>
				  <div class="form-group">
				    <label for="exampleFormControlTextarea1">Picture</label>
				    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
				  </div>
				  <button class="btn btn-success btn-block" type = "submit" name = "add_loc">Add New Location</button>
			</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>