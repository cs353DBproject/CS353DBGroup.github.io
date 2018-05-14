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
  //Get userid
  $user_id;
  $sql = "select id from GeneralUser where username = '".$id."';";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $user_id = $row['id'];
    }
  }
  //find friends
  $friend_id;
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
  //get check-ins of friends
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/main_page.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="topnav">
  <a class="active" href="../main_page/main_page.php?var=<?php echo $id ?>">Home</a>
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

<div style="padding-left:16px">
  <h2>&emsp;&emsp;&emsp;&emsp;Welcome <?php echo $id; ?></h2>  
</div>

<?php
  $sql = "select * from Checkin order by time DESC;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      
      $counter = 0;
      while($num_friends != $counter){
        if($row['user_id'] == $friends_arr[$counter]){

          $sql1 = "select username from GeneralUser where id = '".$row['user_id']."';";
          $result1 = $conn->query($sql1);
          if($result1->num_rows > 0){
            while($row1 = $result1->fetch_assoc() ){
              $friend_name = $row1['username'];
            }
          }
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
            echo "<a href="."../check_in_comment/check_in_comment.php?var=".$row['id']."&var2=".$row['user_id'].""."><font size="."5".">".$friend_name." Has checked-in: ".$location_name."</font></a>
        &emsp;<p>".$friend_name."'s comment: ".$row['text']."</p><br>
        <p>".$row['time'].".&emsp;&emsp;&emsp;report button&emsp;&emsp; number of like: ".$row['num_of_likes']."</p>";
            echo "</div>";
          echo "</div>";
          echo "<hr class=style1  width=60%> ";
        }
        $counter++;
      }   
     }
  }


?>

<!---<div class= "rectangle" >
  <div class= "column left" style= "background-color:#aaa;">
  <img src="images/elon.png">
  </div>
  <div class="column right" style="background-color:#black;">
    <a href="../check_in_comment/check_in_comment.html"><font size="5">Elon Has checked-in: #loc 399</font></a>
    &emsp;<p><?php echo $id; ?>'s comment here...</p><br>
    <p>Here is Date.&emsp;&emsp;&emsp;report button&emsp;&emsp;&emsp; number of like: </p>
  </div>
</div>
<hr class=style1  width=60%> -->

</body>
</html>
