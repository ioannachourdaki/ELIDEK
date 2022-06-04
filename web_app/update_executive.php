<!DOCTYPE html>
<html>
<head>
  <title>Update Executive</title>
</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>Update an existing Executive:</h2>
  <?php
  $id = $_GET['id'];
  $oldfirstname = $_GET['oldfirstname'];
  $oldlastname = $_GET['oldlastname'];

  echo "<h3>Current Executive:</h3>";
  echo "First name: $oldfirstname <br>";
  echo "<br>Last name: $oldlastname <br>";
  include 'db-connection.php';
  echo "<br><br>";
  echo "<h3>Update</h3>";
  if(isset($_POST['submit'])){

    $executive_first_name = $_REQUEST['executive_first_name'];
    $executive_last_name = $_REQUEST['executive_last_name'];

    if(empty($executive_first_name)){
      $executive_first_name = $oldfirstname;
    }


    if(empty($executive_last_name)){
      $executive_last_name = $oldlastname;
    }

      $conn = OpenCon();
      $query = "UPDATE executive SET
                first_name = '$executive_first_name', last_name ='$executive_last_name'  WHERE executive_id=$id";
      if(mysqli_query($conn, $query)){
        echo '<script type="text/javascript">
               alert("Exective succesfully updated!");
               location="index.php";
             </script>';
        }
      else{
        echo '<script>alert("There was a problem! Please try again!")</script>';
      }


    }

    ?>
  <form method="post" action="">
    <label>First name*</label>: <br>
    <input type="text" name="executive_first_name",>
    <br><br>
    Last name*<br>
    <input type="text" name="executive_last_name",>
    <br><br>
    <input type="submit" name="submit" value="Submit">
  </form>


</body>
</html>
