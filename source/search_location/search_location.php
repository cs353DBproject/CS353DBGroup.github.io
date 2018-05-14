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
<link href="css/search_location.css" type="text/css" rel="stylesheet">
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

<div st mhyle="padding-left:16px">
  <h2>&emsp;&emsp;You Searched: <?php echo $_GET['search']; ?></h2>  <!-- there will be php database content-->
</div>

<script type="text/javascript">
  for (i = 0; i < 5; i++) { 
      document.write("<div class="+'rectangle'+">");
      document.write("<div class="+'column left'+" style="+'background-color:#aaa;'+">");
      document.write("<img src="+'images/elon.png'+">");
      document.write("</div>");
      document.write("<div class="+'column right'+" style="+'background-color:#black;'+">");
      document.write("<a href="+'../location/location.php?search=<?php echo $_GET['search']; ?>'+"><font size="+'5'+"><?php echo $_GET['search']; ?></font></a>");
      document.write("&emsp;<p>Location information Location information Location information</p><br>");
      document.write("<p>Report&emsp;&emsp;&emsp;number of like: </p>");
      document.write("</div>");
      document.write("</div>");
      document.write("<hr class=style1  width=60%> ");
  }
    
</script>



</body>
</html>
