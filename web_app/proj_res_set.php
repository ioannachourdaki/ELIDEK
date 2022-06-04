<?php

  $orgid = intval($_GET['q']);
  $endd = $_GET['q2'];
  echo "<h1>$endd</h1>";
  include 'db-connection.php';
  $conn = OpenCon();
  $query1 = "SELECT researcher_id, first_name, last_name from researcher WHERE organization_id<>$orgid";
  $query2 = "SELECT researcher_id, first_name, last_name from researcher WHERE organization_id=$orgid";
  $evals = mysqli_query($conn, $query1);
  $supervs = mysqli_query($conn, $query2);
  echo "<br>";
  echo "Select project evaluator : <br>";
  echo " <select name='evaluator'>";
  while($row = mysqli_fetch_row($evals)){
    echo "<option value=' $row[0] '>  $row[1] $row[2] </option>";
  }
  echo "</select><br><br>";
  echo "Select project supervisor : <br>";
  echo " <select name='supervisor'>";
  while($row = mysqli_fetch_row($supervs)){
    echo "<option value='$row[0]'>  $row[1] $row[2] </option>";
  }
  echo "</select><br><br>";
  echo "<input type='submit' name='submit' value='Submit'>";
  ?>
