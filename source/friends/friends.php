<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);

  if (isset($_GET['remove'])){
	$fid = mysqli_real_escape_string($conn, $_GET['fid']);
    $sql = "DELETE FROM friends WHERE person1_id = ".$acc['id']." AND person2_id = ".$fid;
    $result = $conn->query($sql);
  }
  
  $num_friends = 0;
  $friends_arr = array();
  $sql = "select * from friends where person1_id = ".$acc['id']."";
  $result = $conn->query($sql);
  //get friends to array
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
		$friends_arr[$num_friends] = $row['person2_id'];
		$num_friends++;
    }
  }


?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/friends.css" type="text/css" rel="stylesheet">

</head>
<body>


<div class="topnav">
  <a href="../main_page/main_page.php">Home</a>
  <a class="active" href="../friends/friends.php">Friends</a>
  <a href="../myProfile/myProfile.php">myProfile</a>
  <a href="../logout.php">Logout</a>
  <div class="search-container">
    <form action="../search_location/search_location.php">
      <input type="text" placeholder="Search.." name="search">
      <button class="button">?</button>
    </form>
  </div>
</div>


<div style="padding-left:16px">
  <h2><?php echo $acc['username']; ?> 's Friends</h2>
</div>

<input type="button" class="btn btn-info" value="Request" onclick=" goto_request()">

<script>
function goto_request()
{
     location.href = "../request/request.php";
} 
</script>

<div class="square-container">

<?php
  //$friends_arr

  for($x = 0; $x <$num_friends; $x++){

  
    $sql = "select * from GeneralUser where id = '".$friends_arr[$x]."';";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc() ){

      echo "<div class=\"square\">";
        echo "<div class=\"image\">";
		if (file_exists("../images/profile".$row['id'].".png")) {
			echo "<img class=\"img-thumbnail\" src=\"../images/profile".$row['id'].".png\" width=\"200\">";
		}
		else {
			echo "<img class=\"img-thumbnail\" src=\"../images/elon.png\">";
		}
        echo "</div><a class=\"name\" href=\"../profile/profile.php?var=".$row['id']."\">".$row['username']."</a>";
        echo "<a class=\"message\" href=\"../messages/messages.php?var=".$row['id']."\">message</a>";
        echo "<a class=\"remove\" href=\"friends.php?remove=1&fid=".$row['id']."\">Remove</a>"; 
      echo "</div>";
      }
    }
  }
?>


</div>
<br>
<div align="center" class="search-container" >
    <form action="../search_user/search_user.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
<br><br>
</body>
</html>
