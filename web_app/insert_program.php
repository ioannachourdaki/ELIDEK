<!DOCTYPE html>
<html>
<head>
  <title>Insert a new program</title>
</head>
<body style="background-color:#FFDAB9;">
  <?php
  include 'db-connection.php';
  if(isset($_POST['submit'])){
    $program_title = $_REQUEST['program_title'];
    $program_department = $_REQUEST['program_department'];
    if(empty($program_title)){
      echo '<script>alert("Title not specified")</script>';
    }

    if(empty($program_department)){
      echo '<script>alert("Department not specified")</script>';
    }

    if(!empty($program_title) && !empty($program_department)){
      $conn = OpenCon();
      $query = "INSERT INTO program (title, department)
                VALUES ('$program_title','$program_department')";
      if(mysqli_query($conn, $query)){
        echo '<script type="text/javascript">
               alert("Program succesfully inserted!");
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
  <h2> Insert a new program:</h2>
  <br>
  <form method="post" action="">
    <label>Program Title*</label>: <br>
    <input type="text" name="program_title">
    <br><br>

    Program Department*<br>
    <select name="program_department">
      <option value=""> Select program department </option>
      <option value="Department 1"> Department 1 </option>
      <option value="Department 2"> Department 2 </option>
      <option value="Department 3"> Department 3 </option>
      <option value="Department 4"> Department 4 </option>
      <option value="Department 5"> Department 5 </option>
      <option value="Department 6"> Department 6 </option>
    </select>

<br><br>
<input type="submit" name="submit" value="Submit">

  </form>


</body>
</html>
