<!DOCTYPE html>
<html>
<head>
  <title>Delete Executive</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>The following executive will be removed :</h2>
  <?php
  $id = $_GET['id'];
  $oldfirstname = $_GET['oldfirstname'];
  $oldlastname = $_GET['oldlastname'];


  echo "<h3>Executive's information:</h3>";
  echo "First name: $oldfirstname <br>";
  echo "Last name: $oldlastname <br>";
  echo "<br><br>";
  if(isset($_POST['submit'])){
    include 'db-connection.php';
    $conn = OpenCon();
    $query = "DELETE FROM executive WHERE executive_id = $id";
    if(mysqli_query($conn,$query)){
      echo '<script type="text/javascript">
             alert("Executive removed!");
             location="index.php";
           </script>';
  }
  else{
    echo '<script type="text/javascript">
           alert("Error. Executive may have funded one or more projects!");
           location="index.php";
         </script>';
  }
  }

    ?>
<form method="post" action="" >
  <input type="submit" name='submit' value='DELETE'> You can delete ONLY executives that don't fund projects!</input>
</form>
</body>
</html>
