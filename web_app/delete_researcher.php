<!DOCTYPE html>
<html>
<head>
  <title>Delete Researcher</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1>ΕΛΙΔΕΚ</h1>
  <h2>The following researcher will be removed :</h2>
  <h3>Note that evaluators/supervisors cannot be removed </h3>
  <?php
  $id = $_GET['id'];
  $firstname = $_GET['firstname'];
  $lastname = $_GET['lastname'];
  $sex = $_GET['sex'];
  $birthdate = $_GET['birthdate'];
  $org = $_GET['org'];
  $orgstartdate = $_GET['orgstartdate'];

  echo "<h3>Researcher current information:</h3>";
  echo "First name: $firstname <br>";
  echo "Last name: $lastname <br>";
  echo "Sex: $sex <br>";
  echo "Birth date: $birthdate <br>";
  echo "Organization: $org <br>";
  echo "Organization start date: $orgstartdate <br>";
  echo "<br><br>";
  if(isset($_POST['submit'])){
    include 'db-connection.php';
    $conn = OpenCon();
    $query = "DELETE FROM researcher WHERE researcher_id=$id";
    if(mysqli_query($conn,$query)) {
         echo '<script type="text/javascript">
                alert("Researcher succesfully removed!");
                location="index.php";
              </script>';
          }
   else{
     echo '<script>alert("There was a problem! Make sure you have permission to remove this researcher!")</script>';
   }
}
  ?>

<form method="post" action="" >
  <input id='submitbtn' type="submit" name='submit' value='DELETE' ></input>
</form>
</body>
</html>
