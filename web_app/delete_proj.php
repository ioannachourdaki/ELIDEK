<!DOCTYPE html>
<html>
<head>
  <title>Delete Project</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1>ΕΛΙΔΕΚ</h1>
  <h2>The following project will be removed :</h2>
  <?php
  $id = $_GET['id'];
  $oldtitle = $_GET['oldtitle'];
  $oldammount = $_GET['oldammount'];
  $oldstartdate = $_GET['oldstartdate'];
  $oldduration = $_GET['oldduration'];
  $oldgrade = $_GET['oldgrade'];
  $oldsummary = $_GET['oldsummary'];

  echo "<h3>Project information:</h3>";
  echo "Title: $oldtitle <br>";
  echo "Summary: $oldsummary <br>";
  echo "Ammount: $oldammount <br>";
  echo "Duration: $oldduration <br>";
  echo "Start date: $oldstartdate <br>";
  echo "Grade: $oldgrade <br>";
  echo "<br><br>";
  if(isset($_POST['submit'])){
    include 'db-connection.php';
    $conn = OpenCon();
    $query = "DELETE FROM project WHERE project_id = $id";
    if(mysqli_query($conn,$query)){
      echo '<script type="text/javascript">
             alert("Project succesfully removed!");
             location="index.php";
           </script>';

  }
  else{
    echo '<script>alert("There was a problem deleting this project!")</script>';
  }
}
  ?>

<form method="post" action="" >
  <input id='submitbtn' type="submit" name='submit' value='DELETE' ></input>
</form>
</body>
</html>
