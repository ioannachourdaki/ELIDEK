<!DOCTYPE html>
<html>
<head>
  <title>Update Project</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>Update the following project :</h2>
  <?php

  $id = $_GET['id'];
  $org = $_GET['org'];
  $oldtitle = $_GET['oldtitle'];
  $oldammount = $_GET['oldammount'];
  $oldstartdate = $_GET['oldstartdate'];
  $oldenddate = $_GET['oldenddate'];
  $oldduration = $_GET['oldduration'];
  $oldsummary = $_GET['oldsummary'];
  $oldgrade = $_GET['oldgrade'];
  $oldsuperv= $_GET['oldsuperv'];
  include 'db-connection.php';
  $cons = OpenCon();
  $queryS = "SELECT first_name,last_name from researcher where researcher_id=$oldsuperv";
  echo "<h3>Project information:</h3>";
  echo "Title: $oldtitle <br>";
  echo "Summary: $oldsummary <br>";
  echo "Ammount: $oldammount <br>";
  echo "Duration in years: $oldduration <br>";
  echo "Start date: $oldstartdate <br>";
  echo "Grade: $oldgrade <br>";
  $srow = mysqli_query($cons,$queryS);
  $S = mysqli_fetch_row($srow);
  echo "Current supervisor: $S[0] $S[1] <br>";
  echo "<br><br>";
  $cons->close();
  if(isset($_POST['submit'])){
    $newtitle="";
    $newsummary="";
    $newstartdate="";
    $newenddate="";
    $newsuperv = "";

    if(empty($_REQUEST['newtitle'])){
      $newtitle = $oldtitle;
    }
    else {
      $newtitle = $_REQUEST['newtitle'];
    }

    if(empty($_REQUEST['newsummary'])){
      $newsummary = $oldsummary;
    }
    else {
      $newsummary = $_REQUEST['newsummary'];
    }

    if(empty($_REQUEST['newstartdate'])){
      $newstartdate = $oldstartdate;
    }
    else {
      $newstartdate = $_REQUEST['newstartdate'];
    }

    if(empty($_REQUEST['newenddate'])){
      $newenddate = $oldenddate;
    }
    else {
      $newenddate = $_REQUEST['newenddate'];
    }

    $flag = 0;
    if(empty($_REQUEST['newsuperv'])){
      $newsuperv = $oldsuperv;
    }
    else {
      $flag = 1;
      $newsuperv = $_REQUEST['newsuperv'];
    }

    $conn = OpenCon();
    $query = "UPDATE project SET title='$newtitle', summary='$newsummary', start_date='$newstartdate', end_date='$newenddate', supervisor_id=$newsuperv WHERE project_id=$id";
    //echo $query;
    if(mysqli_query($conn,$query)){
      if($flag == 1){
        $query_sup = "INSERT INTO works_on VALUES($id,$newsuperv)";
        if(mysqli_query($conn, $query_sup)){
          echo '<script type="text/javascript">
                 alert("Supervisor updated!");
               </script>';
        }
      }
      echo '<script type="text/javascript">
             alert("Project succesfully updated!");
             location="index.php";
           </script>';
  }
  else{
    echo '<script>alert("There was a problem updating this project!")</script>';
  }
}
  ?>

<form method="post" action="" >
  <br>
  New Title:
  <input type='text'name='newtitle'>
  <br><br>
  New summary:
  <textarea name="newsummary"></textarea>
  <br><br>
  New supervisor:<br>
  <select name='newsuperv'>
    <?php
      $conn = OpenCon();
      $query = "SELECT researcher_id, first_name, last_name from researcher where organization_id=$org";
      $result = mysqli_query($conn, $query);
      while($row = mysqli_fetch_row($result)){
      ?>
      <option value="<?php echo $row[0]; ?>"> <?php echo "$row[1] $row[2]"; ?> </option>
      <?php
      }
      $conn->close();
      ?>
  </select>
  <br><br>
  New start day:<br>
  <input type="date" name="newstartdate" value="<?php echo date('Y-m-d'); ?>">
  <br><br>
  New end day:<br>
  <input type="date" name="newenddate" value="<?php echo date('Y-m-d'); ?>">
  <br><br>
  <input id='submitbtn' type="submit" name='submit' value='UPDATE'></input>
</form>
</body>
</html>
