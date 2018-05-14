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
  	echo 'conn success';
  }
  $admin_user = $_SESSION['admin_name'];
  $_SESSION['admin_name'] = $admin_user;
  echo $admin_user;

  $name = $_POST['name'];
  $address = $_POST['address'];
  $info = $_POST['info'];

  /*$sql = "insert into Location (id, admin_id, name,address, checkin_count, like_count, info) values ('2', '1', 'Anitkabir1', 'Bahçelievler mah.','100554','100554','information about anıtkabir')";
  $result = $conn->query($sql);*/

  $admin_id = $_SESSION['id'];
  
  if (isset($_POST['add_loc'])){
  	echo $admin_id.$name.$address.$info;
    $sql = " insert into Location (admin_id, name, address, checkin_count,like_count, info) values ('".$admin_id."','".$name."','".$address."','0','0','".$info."') ;";
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
		<link href="css/add_location.css" type="text/css" rel="stylesheet">
    </head>

    <body>
<div class="topnav">
  <a href="../admin_page/admin_page.php">Home</a>
  <a class="active" href="../add_location/add_location.php">Add Location</a>
  <a href="../admin_settings/admin_settings.php">Change Settings</a>
  <a href="../change_loc_settings/change_loc_settings.php">Change Location Specifications</a>
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
			<br><br>
			<form class= "form-container" role = "form" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" method = "post">
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
				  <a href="../admin_page/admin_page.html" type="submit" class="btn btn-success btn-block">Add Picture</a><br>
				  <button class="btn btn-success btn-block" type = "submit" name = "add_loc">Add New Location</button>
				  <!--<a class="btn btn-success btn-block" type="submit" name="add_loc">Add New Location</a>-->
				</form>
			
			</div>
			
			<div class = "col-md-4 col-sm-4 col-xs-12"></div>	
		</div>
		
	</div>
	
    </body>

</html>