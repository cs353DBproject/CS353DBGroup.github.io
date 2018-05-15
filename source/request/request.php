<?php
	require '../config.php';
	require '../utils.php';
	$conn = acc_header();
	$acc = get_acc($conn);

  if (isset($_GET['accept'])){
	$fid = mysqli_real_escape_string($conn, $_GET['fid']);
    $sql = "INSERT INTO friends VALUES (".$fid.", ".$acc['id'].")";
    $result = $conn->query($sql);
    $sql = "DELETE FROM friend_reqs WHERE receiver = ".$acc['id']." AND sender = ".$fid;
    $result = $conn->query($sql);
  }

  if (isset($_GET['remove'])){
	$fid = mysqli_real_escape_string($conn, $_GET['fid']);
    $sql = "DELETE FROM friend_reqs WHERE receiver = ".$acc['id']." AND sender = ".$fid;
    $result = $conn->query($sql);
  }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/request.css" type="text/css" rel="stylesheet">

</head>
<body>


<div class="topnav">
  <a href="../main_page/main_page.php">Home</a>
  <a  class="active" href="../friends/friends.php">Friends</a>
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
  <h2>Your Request List</h2>
</div>

<div class="square-container">
<?php
	$sql = "SELECT * FROM (SELECT * FROM friend_reqs WHERE receiver = ".$acc['id'].") AS reqs JOIN generaluser ON reqs.sender = generaluser.id";
    $result = $conn->query($sql);
	while($row = $result->fetch_assoc() ){
?>
	<div class="square">
		<div class="image">
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
		<a class="name" href="../profile/profile.php?var=<?php echo $row['id']; ?>"><?php echo $row['username']; ?></a>
		<a class="remove" href="request.php?remove=1&fid=<?php echo $row['id']; ?>">Remove</a>
		<a class="add" href="request.php?accept=1&fid=<?php echo $row['id']; ?>">Add</a>
	</div>
<?php
	}
?>
</div>

</body>
</html>
