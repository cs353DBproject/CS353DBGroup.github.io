<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);
	
	$query = "CALL friend_checkins(".$acc['id'].")";
	$result = $conn->query($query);
	
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while trying to fetch checkin information : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/main_page.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="topnav">
  <a class="active" href="../main_page/main_page.php">Home</a>
  <a href="../friends/friends.php">Friends</a>
  <a href="../messages/messages.php">Messages</a>
  <a href="../myProfile/myProfile.php">myProfile</a>
  <a href="../logout.php">Logout</a>
  <div class="search-container">
    <form action="../search_location/search_location.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>

<div style="padding-left:16px">
  <h2>&emsp;&emsp;&emsp;&emsp;Welcome <?php echo $acc['username']; ?></h2>  
</div>
<?php
	while($row = $result->fetch_assoc()) {
?>
<div class="rectangle">
	<div class="column" left="" style="background-color:#aaa;">
<?php
	if (file_exists("../images/profile".$row['id'].".png")) {
		echo "<img src=\"../images/profile".$row['id'].".png\" width=\"200\">";
	}
	else {
?>
    <img src="images/elon.png">
<?php
	}
?>
	</div>
	<div class="column" right="" style="background-color:#black;">
		<a href="../check_in_comment/check_in_comment.php?var=<?php echo $row['checkin_id']; ?>&var2=<?php echo $row['user_id']; ?>">
			<font size="5"><?php echo $row['username']; ?> Has checked-in: <?php echo $row['name']; ?></font>
		</a>
		<p><?php echo $row['text']; ?></p><br>
		<p><?php echo $row['time']; ?>.   Number of likes: <?php echo (int)$row['like_count']; ?></p>
	</div>
</div>
<hr class=style1  width=60%>
<?php
    }
?>

</body>
</html>
