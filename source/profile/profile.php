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

$id = $_SESSION['id'];
$_SESSION['id'] = $id;

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/profile.css" type="text/css" rel="stylesheet">

</head>
<body>

<div class="topnav">
  <a  href="../main_page/main_page.php?var=<?php echo $id ?>">Home</a>
  <a href="../friends/friends.php?var=<?php echo $id ?>">Friends</a>
  <a href="../myProfile/myProfile.php?var=<?php echo $id ?>">myProfile</a>
  <a href="../index.php">Logout</a>
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

  $sql = "select bio from User where user_id = '".$user_id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $bio = $row['bio'];
    }
  }

  $sql = "select birth_date from User where user_id = '".$user_id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $birth_date = $row['birth_date'];
    }
  }

?>

<div style="padding-left:16px">
  <h2>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $user_name; ?>'s profile</h2>  <!-- there will be php database content-->
</div>

<div class="rectangle">
  <div class="column left" style="background-color:#aaa;">
    <img src="images/elon.png">
  </div>
  <div class="column right" style="background-color:#bbb;">
    <h2><?php echo $bio; ?></h2>
    <p>Birth date: <?php echo $birth_date; ?></p>
    <p>number of checkins: <?php echo 'database content'; ?></p>
  </div>
</div>

<hr class=style1  width="60%">

<?php
  $sql = "select * from Checkin where user_id = '".$user_id."' order by time asc;";
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

      echo "<div class= "."rectangle"." >";
        echo "<div class= "."column left"." style= "."background-color:#aaa;".">";
        echo "<img src="."images/elon.png".">";
        echo "</div>";
        echo "<div class="."column right"." style="."background-color:#black;".">";
        echo "<a href="."../check_in_comment/check_in_comment.php?var=".$row['id']."&var2=".$row['user_id'].""."><font size="."5".">".$user_name." Has checked-in: ".$location_name."</font></a>
        &emsp;<p>".$user_name."'s comment: ".$row['text']."</p><br>
        <p>".$row['time'].".&emsp;&emsp;&emsp;report button&emsp;&emsp; number of like: ".$row['num_of_likes']."</p>";
        echo "</div>";
      echo "</div>";
      echo "<hr class=style1  width=60%> ";
    }
  }


?>


</body>
</html>
