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
    "Connected successfully";
  }

  $var = $_GET['var'];
  $id = $_SESSION['id'];
  $_SESSION['id'] = $id;
  $user_id;
  $sql = "select id from GeneralUser where username = '".$id."';";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $user_id = $row['id'];
    }
  }

  $num_friends = 0;
  $friends_arr = array();
  $sql = "select * from friends where person1_id = '".$user_id."' or person2_id = '".$user_id."';";
  $result = $conn->query($sql);
  //get friends to array
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      if($row['person1_id'] != $user_id){
        $friends_arr[$num_friends] = $row['person1_id'];
        $num_friends++;
      }
      else if($row['person2_id'] != $user_id){
        $friends_arr[$num_friends] = $row['person2_id'];
        $num_friends++;
      }
    }
  }

  if (isset($_POST['remove_button'])){
    $sql = " delete from friends (sender, receiver , message, date) values ('".$user_id."', '".$friend_id."', '".$message."' , '".$date."') ;";
    $result = $conn->query($sql);
  }


?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/friends.css" type="text/css" rel="stylesheet">

</head>
<body>


<div class="topnav">
  <a href="../main_page/main_page.php?var=<?php echo $id ?>">Home</a>
  <a class="active" href="../friends/friends.php?var=<?php echo $id ?>">Friends</a>
  <a href="../myProfile/myProfile.php?var=<?php echo $id ?>">myProfile</a>
  <a href="../index.php">Logout</a>
  <div class="search-container">
    <form action="../search_location/search_location.php">
      <input type="text" placeholder="Search.." name="search">
      <button class="button">?</button>
    </form>
  </div>
</div>


<div style="padding-left:16px">
  <h2><?php echo $var; ?> 's Friends</h2>
</div>

<!--<button href="../request/request.html" type="button" class="btn">Request</button>-->

<input type="button" class="btn btn-info" value="Request" onclick=" goto_request()">

<script>
function goto_request()
{
     location.href = "../request/request.html";
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

      echo "<div class="."square".">";
        echo "<div class="."image".">";
          echo "<img src="."images/elon.png".">";
        echo "</div><a class="."name"." href="."../profile/profile.php?var=".$row['id']."".">".$row['username']."</a>";
        echo "<a class="."message"." href="."../messages/messages.php?var=".$row['id']."".">message</a>";
        echo "<a class="."remove"." href="."../removed/removed.php?var=".$row['id']."".">remove</a>"; 
      echo "</div>";
      }
    }
  }
?>


</div>
<br>
<div align="center" class="search-container" >
    <form action="../search_user/search_user.html">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
<br><br>
</body>
</html>
