<!DOCTYPE html>
<html>
<head>
  <title>Insert a new researcher</title>
</head>
<body style="background-color:#FFDAB9;">
  <?php
  include 'db-connection.php';
  if(isset($_POST['submit'])){
  $con = OpenCon();
  $firstname = $_REQUEST['firstname'];
  $lastname = $_REQUEST['lastname'];
  $sex = $_REQUEST['sex'];
  $birthdate = $_REQUEST['birthdate'];
  $organization = $_REQUEST['organization'];
  $startdate = $_REQUEST['startdate'];

  if(!empty($firstname) && !empty($lastname) && !empty($sex) && !empty($birthdate) && !empty($organization) && !empty($startdate)){

    $query1 = "INSERT INTO researcher (first_name, last_name, sex, birth_date, organization_id, org_start_date) VALUES ('$firstname', '$lastname', '$sex', '$birthdate', '$organization','$startdate')";
    if(mysqli_query($con, $query1)){
      echo '<script type="text/javascript">
             alert("Researcher succesfully inserted!");
             location="index.php";
           </script>';
    }
    else{
      echo '<script>alert("Something went wrong! Make sure you provided appropriate values to all fields! ")</script>';
    }
  }
  else{
      echo '<script>alert("Please fill all fields! ")</script>';
  }
}

  ?>


  <h1>ΕΛΙΔΕΚ</h1>
  <h2> Insert a new researcher:</h2>
  <br>

  <form  method="post" action="">
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
    <input type="date" name="birthdate" value="<?php echo date('Y-m-d'); ?>">
    <br><br>
    Organization:
    <select name="organization">
      <option value=""> Select organization </option>
      <?php
        $con2 = OpenCon();
        $query2 = "SELECT organization_id, org_name from organization order by organization_id";
        $result2 = mysqli_query($con2, $query2);
        while($row2 = mysqli_fetch_row($result2)){
        ?>
        <option value="<?php echo $row2[0]; ?>"> <?php echo $row2[1]; ?> </option>
        <?php
        }
        ?>
    </select>
    <br><br>
    Start Date: <br>
    <input type="date" name="startdate" value="<?php echo date('Y-m-d'); ?>">
    <br><br>
    <input type="submit" name="submit" value="Submit">
  </form>
</body>
</html>
