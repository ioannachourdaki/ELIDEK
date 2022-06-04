<!DOCTYPE html>
<html>
<head>
  <title>Delete Program</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>The following program will be removed :</h2>
  <?php
  $id = $_GET['id'];
  $oldtitle = $_GET['oldtitle'];
  $olddepartment = $_GET['olddepartment'];


  echo "<h3>Organization's information:</h3>";
  echo "Title: $oldtitle <br>";
  echo "Department: $olddepartment <br>";
  echo "<br><br>";

  if(isset($_POST['submit'])){
    include 'db-connection.php';
    $conn = OpenCon();
    $query = "DELETE FROM program WHERE program_id = $id";
    if(mysqli_query($conn,$query)){
      echo '<script type="text/javascript">
             alert("Program succesfully removed!");
             location="index.php";
           </script>';
  }
  else{
    echo '<script>alert("There was a problem deleting this program!")</script>';
  }
  }

    ?>
<form method="post" action="" >
  <input type="submit" name='submit' value='DELETE'> You can delete ONLY programs that don't fund projects!</input>
</form>
</body>
</html>
