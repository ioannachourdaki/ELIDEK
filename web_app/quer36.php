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
  $field = $_GET['field'];
  include 'db-connection.php';
  $conn = OpenCon();

  $query = "SELECT researcher_id, full_name, r_age, count(project_id) as cnt
  FROM project_researcher_vw
  WHERE project_id IN (SELECT project_id FROM active_projects)
  GROUP BY researcher_id,full_name, r_age
  HAVING r_age < 40
  ORDER BY cnt DESC LIMIT 10";


  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) == 0 ){
    echo '<script type="text/javascript">
           alert("An error occured!");
           location="index.php";
         </script>';
  }
  echo "<h2> Young researchers: </h2>";
  echo "<h3><u>A list of our top-10 young (age < 40) researchers working on active projects: </u></h3>";
  echo "<table>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Name</th>";
  echo "<th>Age</th>";
  echo "<th>No of projects</th>";
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
