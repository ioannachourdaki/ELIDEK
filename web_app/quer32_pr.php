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

  $query = "SELECT * FROM project_researcher_vw";


  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) == 0 ){
    echo '<script type="text/javascript">
           alert("An error occured!");
           location="index.php";
         </script>';
  }
  echo "<h2> Projects / Researcher : </h2>";
  echo "<table>";
  echo "<tr>";
  echo "<th>Researcher ID</th>";
  echo "<th>Name</th>";
  echo "<th>Age</th>";
  echo "<th>Project ID</th>";
  echo "<th>Title</th>";
  echo "<th>Start Date</th>";
  echo "<th>End date</th>";
  echo "</tr>";
  while($row = mysqli_fetch_row($result)){
    echo "<tr>";
    echo "<td> $row[0]</td>";
    echo "<td> $row[1]</td>";
    echo "<td> $row[2]</td>";
    echo "<td> $row[3]</td>";
    echo "<td> $row[4]</td>";
    echo "<td> $row[5]</td>";
    echo "<td> $row[6]</td>";
    echo "</tr>";
  }
  echo "</table>";

  ?>
</body>
</html>
