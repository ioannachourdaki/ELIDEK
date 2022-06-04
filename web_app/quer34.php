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

  $query = "SELECT distinct u.organization_id, u.org_name as 'ORGANIZATION NAME', u.grade_date as 'FIRST YEAR', (u.grade_date+1) AS 'SECOND YEAR', u.cnt AS 'COUNT'
  FROM
  organization_proj_vw u
  inner join
  organization_proj_vw v
  ON u.organization_id = v.organization_id
  where v.grade_date = u.grade_date+1 and u.cnt=v.cnt and u.cnt>=10";


  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) == 0 ){
    echo '<script type="text/javascript">
           alert("An error occured!");
           location="index.php";
         </script>';
  }
  echo "<h2> 'Back to back' organizations: </h2>";
  echo "<h3><u>Organizations with back to back same number of projects (>10) :  </u></h3>";
  echo "<small>based on grade date</small>";
  echo "<table>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Organization Name</th>";
  echo "<th>Years</th>";
  echo "<th>Projects per year </th>";
  echo "</tr>";
  while($row = mysqli_fetch_row($result)){
    echo "<tr>";
    echo "<td> $row[0]</td>";
    echo "<td> $row[1]</td>";
    echo "<td> $row[2] & $row[3]</td>";
    echo "<td> $row[4]</td>";
    echo "</tr>";
  }
  echo "</table>";

  ?>
</body>
</html>
