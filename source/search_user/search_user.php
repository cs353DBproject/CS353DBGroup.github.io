<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);
	
	if(!isset($_GET["search"])) {
		header("Location: index.php");
		exit();
	}
	
	$search = mysqli_real_escape_string($conn, $_GET["search"]);
	$query = "SELECT * FROM (SELECT * FROM generaluser WHERE LOWER(username) LIKE LOWER('%$search%')) AS generaluser JOIN (SELECT * FROM user WHERE privacy = 0) AS user ON generaluser.id = user.user_id";
	$result = $conn->query($query);
	
	if(!$result) {
		if(CFG_DEBUG)
			die('An error occurred while getting search results : ' . mysqli_error($conn));
		else
			die('An error occurred. We will look at it as soon as possible!');
	}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/search_user.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="topnav">
  <a href="../main_page/main_page.php">Home</a>
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
<div st mhyle="padding-left:16px">
  <h2>&emsp;&emsp;You Searched: <?php echo htmlspecialchars($_GET['search']); ?></h2>
</div>
<?php
	while($row = $result->fetch_assoc()) {
?>
<div class="rectangle">
    <div class="column left" style="background-color:#aaa;">
<?php
	if (file_exists("../images/profile".$row['id'].".png")) {
		echo "<img class=\"img-thumbnail\" src=\"../images/profile".$row['id'].".png\" width=\"200\">";
	}
	else {
?>
    <img class="img-thumbnail" src="../images/elon.png">
<?php
	}
?>
    </div>
    <div class="column right" style="background-color:#black;">
		<a href="../profile/profile.php?var=<?php echo $row['id']; ?>"><font size="5"><?php echo $row['username']; ?></font></a>
	</div>
</div>
<hr class="style1"  width=60%>
<?php
	}
?>



</body>
</html>
