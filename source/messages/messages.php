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

  $user_id;
  $sql = "select id from GeneralUser where username = '".$id."';";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){
      $user_id = $row['id'];
    }
  }
  $friend_id = $_GET['var']; 
?>
<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<link href="css/messages.css" type="text/css" rel="stylesheet">

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
  <h2><?php echo $id ?> Messages: </h2>  <!-- there will be php database content-->
</div>
<br>
<div class="w3-content w3-display-container"><center>
  <img class="mySlides" src="images/elon.png" style="width:10%">
</div>



<hr class=style1  width="60%">


<?php

  $date = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s"))+150);
  $message = $_POST['message'];
  if (isset($_POST['msg_button'])){
    $sql = " insert into messages (sender, receiver , message, date) values ('".$user_id."', '".$friend_id."', '".$message."' , '".$date."') ;";
    $result = $conn->query($sql);
  }

  $sql = "select * from messages where sender = '".$user_id."' or sender = '".$friend_id."' ;";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc() ){

      if($row['sender'] == $user_id && $row['receiver'] == $friend_id){
        echo "<div class= rectangle>";
        echo "<h1>Message from you:  ".$row['message']."</h1>";
        echo "<h1>date: ".$row['date']." </h1>";
        echo "</div>";
        echo "<hr class=style1  width="."60%>".") ";
      }
      else if($row['receiver'] == $user_id && $row['sender'] == $friend_id){
        echo "<div class= rectangle>";
        echo "<h1>Message from friend:  ".$row['message']."</h1>";
        echo "<h1>date: ".$row['date']." </h1>";
        echo "</div>";
        echo "<hr class=style1  width="."60%>".") ";
      } 
    }
  }


?>



  <form class= "form-container" role = "form" action = "<?php echo htmlspecialchars($_SERVER['SELF']);?>" method = "post">
    <div class="form-group">
      <label for="exampleInputEmail1">Message: </label>
      <input type="text" name= "message" class="form-control" id="exampleInputEmail1" placeholder="Message...">
    </div>
    <button class="btn btn-success btn-block" type = "submit" name = "msg_button">Send</button>
  </form>

</body>
</html>
