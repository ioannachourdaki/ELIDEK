<!DOCTYPE html>
<html>
<head>
  <title>Update Researcher</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1>ΕΛΙΔΕΚ</h1>
  <h2>The following researcher will be removed :</h2>
  <h3>Note that evaluators/supervisors cannot be removed </h3>
  <?php
  $id = $_GET['id'];
  $oldfirstname = $_GET['firstname'];
  $oldlastname = $_GET['lastname'];
  $oldsex = $_GET['sex'];
  $oldbirthdate = $_GET['birthdate'];
  $oldorg = $_GET['org'];
  $oldorgstartdate = $_GET['orgstartdate'];
  $oldorgid = $_GET['orgid'];

  echo "<h3>Researcher current information:</h3>";
  echo "First name: $oldfirstname <br>";
  echo "Last name: $oldlastname <br>";
  echo "Sex: $oldsex <br>";
  echo "Birth date: $oldbirthdate <br>";
  echo "Organization: $oldorg <br>";
  echo "Organization start date: $oldorgstartdate <br>";
  echo "<br><br>";

  if(isset($_POST['submit'])){
    $id = $_GET['id'];
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
    $sex = $_REQUEST['sex'];
    $birthdate = $_REQUEST['birthdate'];
    $org = $_REQUEST['org'];
    $orgstartdate = $_REQUEST['orgstartdate'];
    $orgid = $_REQUEST['orgid'];
    include 'db-connection.php';
    $conn = OpenCon();


    if(empty($firstname)){
      $firstname = $oldfirstname;
    }

    if(empty($lastname)){
      $lastname = $oldlastname;
    }

    if(empty($sex)){
      $sex = $oldsex;
    }

    if(empty($birthdate)){
      $birthdate = $oldbirthdate;
    }

    $query = "UPDATE researcher SET first_name = '$firstname', last_name ='$lastname', sex = '$sex', birth_date ='$birthdate' WHERE researcher_id=$id";

    if(mysqli_query($conn,$query)) {
         echo '<script type="text/javascript">
                alert("Researcher succesfully updated!");
                location="index.php";
              </script>';
          }
   else{
     echo '<script>alert("There was a problem! Make sure you have permission to remove this researcher!")</script>';
   }

}
  ?>
<h3>Update researcher:</h3><br>
<form method="post" action="" >
  <label>First name:</label> <br>
  <input type="text" name="firstname">
  <br><br>
  <label>Last name:</label><br>
  <input type="text" name="lastname">
  <br><br>
  <label>Sex:</label> <br>
  <select name="sex">
    <option value="Female">Female</option>
    <option value="Male">Male</option>
    <option value="Other">Other</option>
  </select>
  <br><br>
  Birth Date: <br>
  <input type="date" name="birthdate" value="<?php echo $oldbirthdate; ?>">
  <br><br>
  <input id='submitbtn' type="submit" name='submit' value='UPDATE' ></input>
</form>
</body>
</html>
