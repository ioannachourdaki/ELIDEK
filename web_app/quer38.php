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

  $query = "SELECT researcher_id, full_name, count(project_id) as cnt
  FROM project_researcher_vw
  WHERE project_id IN (SELECT project_id FROM active_projects)
    AND project_id NOT IN (SELECT project_id FROM deliverable)
  GROUP BY researcher_id, full_name
  HAVING cnt >= 5";


  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) == 0 ){
    echo '<script type="text/javascript">
           alert("An error occured!");
           location="index.php";
         </script>';
  }
  echo "<h2>Many projects ... few deliverables! </h2>";
  echo "<h3><u>Researcher that are (currently) working on more than 5 projects without deliverables : </u></h3>";
  echo "<table>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Name</th>";
  echo "<th>Projects</th>";
  echo "</tr>";
  while($row = mysqli_fetch_row($result)){
    echo "<tr>";
    echo "<td> $row[0] </td>";
    echo "<td> $row[1]</td>";
    echo "<td> $row[2] </td>";
    echo "</tr>";
  }
  echo "</table>";

  ?>
</body>
</html>
