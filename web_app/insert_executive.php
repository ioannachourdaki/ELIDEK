<!DOCTYPE html>
<html>
<head>
  <title>Insert a new executive</title>
</head>
<body style="background-color:#FFDAB9;">
  <?php
  include 'db-connection.php';
  if(isset($_POST['submit'])){
    $executive_first_name = $_REQUEST['executive_first_name'];
    $executive_last_name = $_REQUEST['executive_last_name'];
    if(empty($executive_first_name)){
      echo '<script>alert("Name not specified")</script>';
    }

    if(empty($executive_last_name)){
      echo '<script>alert("Type not specified")</script>';
    }

    if(!empty($executive_first_name) && !empty($executive_last_name)){
      $conn = OpenCon();
      $query = "INSERT INTO executive (first_name, last_name)
                VALUES ('$executive_first_name','$executive_last_name')";
      if(mysqli_query($conn, $query)){
        echo '<script type="text/javascript">
               alert("Executive succesfully inserted!");
               location="index.php";
             </script>';
        }
      else{
        echo '<script>alert("There was a problem! Please try again!")</script>';
      }
    }
    else{
      echo "<h1>ERROR</h1><br>";
    }
}
    ?>

  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2> Insert a new Executive:</h2>
  <br>
  <form method="post" action="">
    <label>First name*</label>: <br>
    <input type="text" name="executive_first_name">
    <br><br>

    Last name*<br>
    <input type="text" name="executive_last_name">
    <br><br>
<br><br>
<input type="submit" name="submit" value="Submit">

  </form>


</body>
</html>
