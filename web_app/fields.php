<!DOCTYPE html>
<html>
<head>
  <style>
  table, th, td {
  border: 1px solid black;
}
  </style>
</head>
<body>
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h1><a href='fields2.php'>ΕΛΙΔΕΚ</a></h1>
  <h2> Our scientific fields: </h2>
  <table>
    <tr><td><b><a href="quer33.php?field='Agricultural Sciences'">Agricultural Sciences</a> </td></tr>
    <tr><td><b><a href="quer33.php?field='Chemistry'">Chemistry</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Computer Science'">Computer Science</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Economics'">Economics</a> </td></tr>
    <tr><td><b><a href="quer33.php?field='Energy & Environment'">Energy & Environment</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Engineering'">Engineering</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Geology'">Geology</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Humanities and Arts'">Humanities and Arts</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Life Sciences'">Life Sciences</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Mathematics'">Mathematics</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Natural Sciences'">Natural Sciences</a></td></tr>
    <tr><td><b><a href="quer33.php?field='Social Sciences'">Social Sciences</a></b></td></tr>
  </table>
  <small> Clicking a field will show associated projects and researchers!</small>

  <div>
    <h2>Top 3 field combination :</h2>
    <table>
      <?php
        include 'db-connection.php';
        $conn = OpenCon();

        $query = "SELECT count(fp1.project_id) as cnt, fp1.field_name as field1, fp2.field_name as field2
        FROM field_project fp1 INNER JOIN field_project fp2
        ON (fp1.project_id=fp2.project_id and fp1.field_name<fp2.field_name)
        GROUP BY fp1.field_name, fp2.field_name
        ORDER BY cnt DESC LIMIT 3";

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 0){
            echo "<h2>No projects found!</h2>";
        }

        echo "<table>";
        echo "<tr>";
        echo "<th> Field Pair</th>";
        echo "<th> Total projects </th>";
        while($row = mysqli_fetch_row($result)){
          echo "<tr>";
          echo "<td> $row[1] & $row[2]</td>";
          echo "<td> $row[0]</td>";
          echo "</tr>";
        }

       ?>

 </body>
 </html>
