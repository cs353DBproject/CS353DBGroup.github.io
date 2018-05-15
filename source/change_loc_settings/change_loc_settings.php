<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	
  $admin_id = $_SESSION['id'];
  $name = $_POST['name'];
  $address = $_POST['address'];
  $info = $_POST['info'];
  $var = $_GET['var'];

  $sql = "select id from Location where admin_id = '".$admin_id."';";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $location_id = $row['id'];
    }
  }
  if (isset($_POST['change_button'])){
    $sql = " update Location set name = '".$name."', address = '".$address."', info = '".$info."' where id = '".$location_id."';";
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
		<link href="css/change_loc_settings.css" type="text/css" rel="stylesheet">
    </head>

    <body>
    	<div class="topnav">
		  <a href="../admin_page/admin_page.php">Home</a>
		  <a href="../add_location/add_location.php">Add Location</a>
		  <a href="../admin_settings/admin_settings.php">Change Settings</a>
		  <a class="active" href="../change_loc_settings/change_loc_settings.php">Change Location Specifications</a>
		  <a href="../index.php">Logout</a>
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
			
			<form class= "form-container" role = "form" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" method = "post">
			<h1 align="center"> Change Loc. Settings</h1>
			  <div class="form-group">
				<label for="Location Name">Location Name</label>
				<input type="Name" name= "name" class="form-control" id="Name" placeholder="Name">
			  </div>
			  <div class="form-group">
				<label for="Address">Address</label>
				<input type="Address" name= "address" class="form-control" id="Address" placeholder="Address">
			  </div>
			  <div class="form-group">
				<label for="Info">Info</label>
				<input type="Info" name= "info" class="form-control" id="Info" placeholder="Info">
			  </div> <br>
			  <a href="../change_loc_settings/change_loc_settings.html" type="submit" class="btn btn-success btn-block">Change&Add Picture</a> <br>
			  <button class="btn btn-success btn-block" type = "submit" name = "change_button">Change Settings</button>
			</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>