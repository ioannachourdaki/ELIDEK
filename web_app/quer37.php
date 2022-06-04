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

  $query = "SELECT e.first_name, e.last_name, c.company_name, sum(c.amt) as total_ammount
  FROM executive e
  INNER JOIN
    (SELECT o.org_name as company_name, p.ammount as amt, p.executive_id as executive_id
    FROM project p
    INNER JOIN organization o
    ON p.organization_id=o.organization_id
    WHERE o.org_type='company') c
  ON e.executive_id= c.executive_id
  GROUP BY e.first_name, e.last_name, c.company_name
  ORDER BY total_ammount DESC
  LIMIT 5";


  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) == 0 ){
    echo '<script type="text/javascript">
           alert("An error occured!");
           location="index.php";
         </script>';
  }
  echo "<h2> Companies' best friends: </h2>";
  echo "<h3><u>Here are the top-5 Executives based on total funds to a company (and the name of the company): </u></h3>";
  echo "<table>";
  echo "<tr>";
  echo "<th>Executive's name</th>";
  echo "<th>Company</th>";
  echo "<th>Total ammount</th>";
  echo "</tr>";
  while($row = mysqli_fetch_row($result)){
    echo "<tr>";
    echo "<td> $row[0] $row[1]</td>";
    echo "<td> $row[2] </td>";
    echo "<td> $row[3]</td>";
    echo "</tr>";
  }
  echo "</table>";

  ?>
</body>
</html>
