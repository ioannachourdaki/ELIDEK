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

  $query_proj = "SELECT ap.project_id, ap.title FROM active_projects ap
  INNER JOIN field_project fp ON
  ap.project_id = fp.project_id
  WHERE (fp.field_name ='$field')";



  $query_res = "SELECT r.researcher_id, r.first_name, r.last_name FROM researcher r
  INNER JOIN works_on wo
  ON r.researcher_id = wo.researcher_id
  WHERE wo.project_id IN
  ( SELECT ap.project_id FROM active_projects ap
    INNER JOIN field_project fp
    ON ap.project_id = fp.project_id
    WHERE (fp.field_name='$field'
            AND ap.start_date<=DATE_SUB(CURDATE(),INTERVAL 1 YEAR) )
  )";



  $result_proj = mysqli_query($conn, $query_proj);


  if(mysqli_num_rows($result_proj) == 0){
    echo "<h2>No active projects on this field!</h2>";
  }
  else{
    echo "<h2> Field: $field </h2>";
    echo "<h3><u>Active projects on $field: </u></h3>";
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Title</th>";
    echo "</tr>";
    while($row = mysqli_fetch_row($result_proj)){
      echo "<tr>";
      echo "<td> $row[0]</td>";
      echo "<td> $row[1]</td>";
      echo "</tr>";
    }
    echo "</table>";
  }

  $result_res = mysqli_query($conn, $query_res);
  if(mysqli_num_rows($result_res) == 0){
    echo "<h2>No researchers work for at least one year on this field!</h2>";
  }
  else{
    echo "<br><br><br>";
    echo "<h3><u>Researchers working on this field over last year:</u></h3>";
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Name</th>";
    echo "</tr>";
    while($row = mysqli_fetch_row($result_res)){
      echo "<tr>";
      echo "<td> $row[0]</td>";
      echo "<td> $row[1] $row[2]</td>";
      echo "</tr>";
    }
    echo "</table>";
  }
?>
</body>
</html>
