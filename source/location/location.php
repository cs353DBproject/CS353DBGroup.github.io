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
<link href="css/location.css" type="text/css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style> 
input[type=text] {
    width: 60%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid red;
    border-radius: 4px;
}
</style>

</head>
<body>

<div class="topnav">
  <a href="../main_page/main_page.php?var=<?php echo $id ?>">Home</a>
  <a href="../friends/friends.php?var=<?php echo $id ?>">Friends</a>
  <a href="../messages/messages.php?var=<?php echo $id ?>">Messages</a>
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
  
  $location_name = $_GET['search'];
  $loc_id;
  $number_of_checkin;
  $adre;
  $user_id;

  $sql = "select id from Location where name = '".$location_name."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $loc_id = $row['id'];
    }
  }
  $sql = "select id from GeneralUser where username = '".$id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $user_id = $row['id'];
    }
  }
  
  $sql1;
  $date = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s"))+150);
  $comment = $_POST['fname'];
  $rate = $_POST['frate'];
  if (isset($_POST['check_button'])){
    $sql1 = " insert into Checkin (loc_id, time , text, rate ,user_id, num_of_likes) values ('".$loc_id."', '".$date."', '".$comment."' , '".$rate."','".$user_id."' , '12123123') ;";
  $result = $conn->query($sql1);
  }

  $info;
  $address;
  $sql = "select address from Location where id = '".$loc_id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $address = $row['address'];
    }
  }
  $sql = "select info from Location where id = '".$loc_id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $info = $row['info'];
    }
  }
?>

<div style="padding-left:16px">
  <h2>Location <?php echo $_GET['search']; ?></h2>  <!-- there will be php database content-->
</div>


<div class="rectangle">
  <div class="column left" style="background-color:#aaa;">
    <img src="images/first.jpg">
    <font style="color:red;">Rate:  4.3</font><br>
    <font style="color:red;">Number of Checkin: 123</font>
  </div>
  <div class="column right" style="background-color:#bbb;">
    <h2><?php echo $_GET['search']; ?></h2>
    <p> info: <?php echo $info; ?></p>,
    <p> address: <?php echo $address; ?></p>
  </div>
  <form class= "form-container" role = "form" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" method = "post">
  <label style="color:red;" for="fname"><br>&emsp;Enter Comment: </label><br> <br>
      &emsp;<input type="text" name="fname" placeholder="Comment..">
  <br>
  <div class="slidecontainer">

  <p style="color:red;">&emsp;Rate: <span id="demo" style="color:black;"></span></p>
  &emsp;<input type="range" min="1" max="5" value="5" class="slider" id="myRange" name = "frate">
    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<button    style=" background: transparent;" type = "submit" name = "check_button">
      <img src="images/check.png" width="90" height="50" align="center"/>
    </button>
  </form>
</div>

<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>
</div>

<hr class=style1  width="60%">

<?php

  $sql = "select * from Checkin where loc_id = '".$loc_id."' order by time asc;";
  $result = $conn->query($sql);
  if($result->num_rows == 0)
    echo "<p> There is no check-in</p>";
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $sql1 = "select username from GeneralUser where id = '".$row['user_id']."';";
      $result1 = $conn->query($sql1);
      if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc() ){
          $checker_name = $row1['username'];
        }
      }

      echo "<div class= "."rectangle_1"." >";
        echo "<div class= "."column_1 left1"." style= "."background-color:#aaa;".">";
        echo "<img src="."images/elon.png".">";
        echo "</div>";
        echo "<div class="."column_1 right1"." style="."background-color:#black;".">";
        echo "<a href="."../check_in_comment/check_in_comment.php?var=".$row['id']."&var2=".$row['user_id'].""."><font size="."5".">".$checker_name." Has checked-in: ".$location_name."</font></a>
        &emsp;<p>".$checker_name."'s comment: ".$row['text']."</p><br>
        <p>".$row['time'].".&emsp;&emsp;&emsp;report button&emsp;&emsp; number of like: ".$row['num_of_likes']."</p>";
        echo "</div>";
      echo "</div>";
      echo "<hr class=style1  width=60%> ";
    }
  }
?>



</body>
</html>
