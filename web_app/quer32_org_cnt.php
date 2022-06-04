<!DOCTYPE html>
<html>
<head>
  <style>
  table, th, td {
  border: 1px solid black;
}
  </style>
</head>
<body style="background-color:#FFDAB9;">

  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>

  <?php

  include 'db-connection.php';
  $conn = OpenCon();

  $query = "SELECT * FROM organization_proj_vw";


  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) == 0 ){
    echo '<script type="text/javascript">
           alert("An error occured!");
           location="index.php";
         </script>';
  }
  echo "<h2> Organizations and total projects per year : </h2>";
  echo "<table>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Organization name</th>";
  echo "<th>Total projects</th>";
  echo "<th>Year</th>";
  echo "</tr>";
  while($row = mysqli_fetch_row($result)){
    echo "<tr>";
    echo "<td> $row[0]</td>";
    echo "<td> $row[1]</td>";
    echo "<td> $row[2]</td>";
    echo "<td> $row[3]</td>";
    echo "</tr>";
  }
  echo "</table>";

  ?>
</body>
</html>
