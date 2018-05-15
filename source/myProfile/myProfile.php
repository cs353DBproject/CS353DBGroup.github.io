<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	
$id = $_SESSION['id'];
$_SESSION['id'] = $id;

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/myProfile.css" type="text/css" rel="stylesheet">

</head>
<body>

<div class="topnav">
  <a  href="../main_page/main_page.php">Home</a>
  <a href="../friends/friends.php">Friends</a>
  <a class="active" href="../myProfile/myProfile.php">myProfile</a>
  <a href="../settings/settings.php">Settings</a>
  <a href="../logout.php">Logout</a>
  <div class="search-container">
    <form action="../search_location/search_location.php">
      <input type="text" placeholder="Search.." name="search">
      <button class="button">?</button>
    </form>
  </div>
</div>

<div style="padding-left:16px">
  <h2>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $id; ?>'s profile</h2>  <!-- there will be php database content-->
</div>

<?php
  $birth_date;
  $bio;
  $user_id;
  $sql = "select id from GeneralUser where username= '".$id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $user_id = $row['id'];
    }
  }

  $sql = "select * from (select * from User where user_id = ".$user_id.") as user join (select user_id, count(*) as num_of_checkins from checkin group by user_id) as checkin_num on user.user_id = checkin_num.user_id";
  $is_user = false;
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $bio = $row['bio'];
      $birth_date = $row['birth_date'];
      $num_of_checkins = $row['num_of_checkins'];
		$is_user = true;
    }
  }
	$loc_man;
	if(!$is_user) {
		$sql = "SELECT * FROM LocationAdmin WHERE user_id = ".$user_id;
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc() ){
				$loc_man = $row;
			}
		}
	}

?>

<div class="rectangle">
  <div class="column left" style="background-color:#aaa;">
<?php
	if (file_exists("../images/profile".$user_id.".png")) {
		echo "<img class=\"img-thumbnail\" src=\"../images/profile".$user_id.".png\" width=\"200\">";
	}
	else {
?>
    <img class="img-thumbnail" src="images/elon.png">
<?php
	}
?>
  </div>
  <div class="column right" style="background-color:#bbb;">
    <h2><?php echo $is_user ? $bio : $loc_man['role']; ?></h2>
<?php
	if($is_user) {
?>
    <p>Birth date: <?php echo $birth_date; ?></p>
    <p>number of checkins: <?php echo (int)$num_of_checkins; ?></p>
<?php
	}
?>
  </div>
</div>

<hr class="style1"  width="60%">

<?php
  //$sql = "select * from Checkin where user_id = '".$user_id."' order by time asc;";
  $sql = "select * from (select * from Checkin where user_id = ".$user_id.") as checkin left join (select checkin_id, count(*) as num_of_likes from checkin_likes group by checkin_id) as checkin_likes on checkin.id = checkin_likes.checkin_id";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $sql1 = "select name from Location where id = '".$row['loc_id']."';";
      $result1 = $conn->query($sql1);
      if($result1->num_rows > 0){
      while($row1 = $result1->fetch_assoc() ){
          $location_name = $row1['name'];
        }
      }

      echo "<div class= \"rectangle\" >";
        echo "<div class= \"column left\" style= \"background-color:#aaa;\">";
		if (file_exists("../images/profile".$user_id.".png")) {
			echo "<img class=\"img-thumbnail\" src=\"../images/profile".$user_id.".png\" width=\"200\">";
		}
		else {
			echo "<img class=\"img-thumbnail\" src=\"../images/elon.png\">";
		}
        echo "</div>";
        echo "<div class=\"column right\" style=\"background-color:#black;\">";
        echo "<a href=\"../check_in_comment/check_in_comment.php?var=".$row['id']."&var2=".$row['user_id']."\"><font size=\"5\">".$id." Has checked-in: ".$location_name."</font></a>
        &emsp;<p>".$id."'s comment: ".$row['text']."</p><br>
        <p>".$row['time'].".&emsp;&emsp;&emsp;Number of likes: ".(int)$row['num_of_likes']."</p>";
        echo "</div>";
      echo "</div>";
      echo "<hr class=style1  width=60%> ";
    }
  }


?>


</body>
</html>
