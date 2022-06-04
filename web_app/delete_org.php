<!DOCTYPE html>
<html>
<head>
  <title>Delete Organization</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1>ΕΛΙΔΕΚ</h1>
  <h2>The following organization will be removed :</h2>
  <?php
  $id = $_GET['id'];
  $oldname = $_GET['oldname'];
  $oldabbr = $_GET['oldabbr'];
  $oldaddress = $_GET['oldaddress'];
  $oldcity = $_GET['oldcity'];
  $oldtype = $_GET['oldtype'];

  echo "<h3>Organization's information:</h3>";
  echo "Name: $oldname <br>";
  echo "Abbreviation: $oldabbr <br>";
  echo "Address: $oldaddress <br>";
  echo "City: $oldcity <br>";
  echo "Type: $oldtype <br>";
  echo "<br><br>";
  if(isset($_POST['submit'])){
    include 'db-connection.php';
    $conn = OpenCon();
    $query = "DELETE FROM organization WHERE organization_id = $id";
    if(mysqli_query($conn,$query)){
      echo '<script type="text/javascript">
             alert("Organization removed!");
             location="index.php";
           </script>';
  }
  else{
    echo '<script type="text/javascript">
           alert("There was a problem deleting this organization!");
           location="index.php";
         </script>';
  }
  }

    ?>
<form method="post" action="" >
  <input type="submit" name='submit' value='DELETE'> Make sure no researcher that organization has no active projects or evaluators!</input>
</form>
</body>
</html>
