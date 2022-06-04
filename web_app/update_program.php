<!DOCTYPE html>
<html>
<head>
  <title>Update Program</title>
</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>Update an existing Program:</h2>
  <?php
  $id = $_GET['id'];
  $oldtitle = $_GET['oldtitle'];
  $olddepartment = $_GET['olddepartment'];

  echo "<h3>Current project:</h3>";
  echo "Project: $oldtitle <br>";
  echo "<br>Department: $olddepartment <br>";
  include 'db-connection.php';
  echo "<br><br>";
  echo "<h3>Update</h3>";
  if(isset($_POST['submit'])){

    $program_title = $_REQUEST['program_title'];
    $program_department = $_REQUEST['program_department'];

    if(empty($program_title)){
      $program_title = $oldtitle;
    }


    if(empty($program_department)){
      $program_department = $olddepartment;
    }

      $conn = OpenCon();
      $query = "UPDATE program SET
                title = '$program_title', department ='$program_department'  WHERE program_id=$id";
      if(mysqli_query($conn, $query)){
        echo '<script type="text/javascript">
               alert("Program succesfully updated!");
               location="index.php";
             </script>';
        }
      else{
        echo '<script>alert("There was a problem! Please try again!")</script>';
      }
      echo "<br>";
      echo "<a href='index.php'>Return to Home Page </a>";

    }

    ?>
  <form method="post" action="">
    <label>Program Title*</label>: <br>
    <input type="text" name="program_title",>
    <br><br>
    Program Department*<br>
    <select name="program_department">
      <option value=""> Select program department </option>
      <option value="Department 1"> Department 1 </option>
      <option value="Department 2"> Department 2 </option>
      <option value="Department 3"> Department 3 </option>
      <option value="Department 4"> Department 4 </option>
      <option value="Department 5"> Department 5 </option>
      <option value="Research Department"> Research Department </option>
    </select>
    <br><br>
    <input type="submit" name="submit" value="Submit">
  </form>


</body>
</html>
