<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);

	if(!isset($_GET['var'])) {
		header("Location: index.php");
		exit();
	}
	
	if(isset($_GET['req'])) {
		$fid = mysqli_real_escape_string($conn, $_GET["var"]);
		$query = "INSERT INTO friend_reqs(sender, receiver) VALUES(".$acc['id'].", $fid)";
		$result = $conn->query($query);
	}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/profile.css" type="text/css" rel="stylesheet">

</head>
<body>

<div class="topnav">
  <a  href="../main_page/main_page.php">Home</a>
  <a href="../friends/friends.php">Friends</a>
  <a href="../myProfile/myProfile.php">myProfile</a>
  <a href="../logout.php">Logout</a>
  <div class="search-container">
    <form action="../search_location/search_location.php">
      <input type="text" placeholder="Search.." name="search">
      <button class="button">?</button>
    </form>
  </div>
</div>

<?php
  $birth_date;
  $bio;
  $user_id;
  /*$sql = "select id from GeneralUser where username= '".$id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $user_id = $row['id'];
    }
  }*/

  $user_id = $_GET['var'];

  $sql = "select username from GeneralUser where id = '".$user_id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $user_name = $row['username'];
    }
  }

  $sql = "select * from (select * from User where user_id = ".$user_id.") as user left join (select user_id, count(*) as num_of_checkins from checkin group by user_id) as checkin_num on user.user_id = checkin_num.user_id";
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

<div style="padding-left:16px">
  <h2>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $user_name; ?>'s profile</h2>
<?php
	$sql = "SELECT * FROM friends WHERE person1_id = ".$acc['id']." AND person2_id = ".$user_id;
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		echo "<p>A friend of yours</p>";
	}
	else {
		$sql = "SELECT * FROM friend_reqs WHERE sender = ".$acc['id']." AND receiver = ".$user_id;
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			echo "<p>You have sent a friend request</p>";
		}
		else {
			echo "<a href=\"profile.php?var=$user_id&req=1\">Send a friend request</p>";
		}
	}
?>
</div>

<div class="rectangle">
  <div class="column left" style="background-color:#aaa;">
<?php
	if (file_exists("../images/profile".$user_id.".png")) {
		echo "<img class=\"img-thumbnail\" src=\"../images/profile".$user_id.".png\" width=\"200\">";
	}
	else {
?>
    <img class="img-thumbnail" src="../images/elon.png">
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

<hr class=style1  width="60%">

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
        echo "<a href=\"../check_in_comment/check_in_comment.php?var=".$row['id']."&var2=".$row['user_id']."\"><font size=\"5\">".$user_name." Has checked-in: ".$location_name."</font></a>
        &emsp;<p>".$user_name."'s comment: ".$row['text']."</p><br>
        <p>".$row['time'].".&emsp;&emsp;&emsp;Number of likes: ".(int)$row['num_of_likes']."</p>";
        echo "</div>";
      echo "</div>";
      echo "<hr class=style1  width=60%> ";
    }
  }


?>


</body>
</html>
