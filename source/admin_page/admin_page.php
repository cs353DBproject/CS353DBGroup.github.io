<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	
  $admin_name = $_SESSION['id'];
  $_SESSION['user_name'] = $admin_name;

  

  $sql = "select id from GeneralUser where username = '".$admin_name."';";
  $result = $conn->query($sql);
  $admin_id;
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $admin_id = $row['id'];
    }
  }
  
  $sql = "select * from Location where admin_id = '".$admin_id."';";
  $result = $conn->query($sql);
  $adminLoc = false;
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $adminLoc = $row;
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/admin_page.css" type="text/css" rel="stylesheet">

</head>
<body>

<div class="topnav">
  <a class="active" href="../admin_page/admin_page.php">Home</a>
  <a href="../add_location/add_location.php">Add Location</a>
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

<div style="padding-left:16px">
  <h2>Welcome <?php echo $admin_name; ?></h2>
</div>
<?php
	if($adminLoc) {
		$admin_location_name = $adminLoc['name'];
		$admin_location_id = $adminLoc['id'];
?>
<div style="padding-left:16px">
  <h3>&emsp;&emsp;&emsp;&emsp;Your location check-ins:</h3>
</div>

<?php
	  //$sql = "select * from Checkin where loc_id = '".$admin_location_id."';";
	$sql = "select * from (select * from Checkin where loc_id = '".$admin_location_id."' order by time asc) as checkin left join (select checkin_id, count(*) as num_of_likes from checkin_likes group by checkin_id) as checkin_likes on checkin.id = checkin_likes.checkin_id";
	  $result = $conn->query($sql);
	  if($result->num_rows > 0){
		while($row = $result->fetch_assoc() ){
		  $sql1 = "select username from GeneralUser where id = '".$row['user_id']."';";
		  $result1 = $conn->query($sql1);
		  if($result1->num_rows > 0){
			while($row1 = $result1->fetch_assoc() ){
			  $checker_name = $row1['username'];
			}
		  }
			  echo "<div class= "."rectangle"." >";
				echo "<div class= "."column left"." style= "."background-color:#aaa;".">";
				if (file_exists("../images/profile".$row['user_id'].".png")) {
					echo "<img src=\"../images/profile".$row['user_id'].".png\" width=\"200\">";
				}
				else {
					echo "<img src="."images/elon.png".">";
				}
				echo "</div>";
				echo "<div class="."column right"." style="."background-color:#black;".">";
				echo "<a href="."../check_in_comment/check_in_comment.php?var=".$row['id']."&var2=".$row['user_id'].""."><font size="."5".">".$checker_name." Has checked-in: ".$admin_location_name."</font></a>
			&emsp;<p>".$checker_name."'s comment: ".$row['text']."</p><br>
			<p>".$row['time'].".&emsp;&emsp;&emsp;Number of likes: ".(int)$row['num_of_likes']."</p>";
				echo "</div>";
			  echo "</div>";
			  echo "<hr class=style1  width=60%> ";
		}
	  }
	}
?>



</body>
</html>
