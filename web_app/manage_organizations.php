<!DOCTYPE html>
<html>
<head>
  <title>Organizations</title>
  <style>
  table, th, td {
  border: 1px solid black;
}
  </style>
</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>MANAGE ORGANIZATIONS</h2>

  <a href="quer32_org_cnt.php">Organizations/Total projects per year </a><br><br>

  <form action="insert_org.php">
    <input type="submit" value="+ NEW ORGANIZATION">
  </form>

  <div>
    <?php
      include 'db-connection.php';
      $conn = OpenCon();
      $query = "SELECT organization_id, org_name, abbreviation, street_name, street_number, zip , city, org_type FROM organization";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) == 0){
        echo '<h1>ERROR</h1>';
      }
      else{
        echo '<div>';
        echo '<table>';
        echo '<tr>';
        echo '<th> Organization ID </th>';
        echo '<th> Organization name </th>';
        echo '<th> Abbreviation </th>';
        echo '<th> Address </th>';
        echo '<th> City </th>';
        echo '<th> Type </th>';
        echo '<th> Phone number(s) </th>';
        echo '<th>  </th>';
        echo '<th>  </th>';

        echo '</th>';
        while($row = mysqli_fetch_row($result)){
          $query2 = "SELECT pnumber from phone_number WHERE organization_id=$row[0]";
          $result2 = mysqli_query($conn,$query2);
          echo '<tr>';
          echo '<td>' . $row[0] . '</td>';
          echo '<td>' . $row[1] . '</td>';
          echo '<td>' . $row[2] . '</td>';
          echo "<td>  $row[3] , $row[4], $row[5] </td>";
          echo '<td>' . $row[6] . '</td>';
          echo '<td>' . $row[7] . '</td>';
          if(mysqli_num_rows($result) == 0){
            echo "<td>''</td>";
          }
          else{ echo "<td>";
            while($row2 = mysqli_fetch_row($result2)){
              echo "$row2[0] <br>";
            }
            echo "</td>";
          }
          echo "<td><a href='update_org.php?id=$row[0]&oldname=$row[1]&oldabbr=$row[2]&oldstreetname=$row[3]&oldstreetnum=$row[4]&oldzip=$row[5]&oldcity=$row[6]&oldtype=$row[7]'>Update </a></td>";
          echo "<td><a style='color:Red;' href='delete_org.php?id=$row[0]&oldname=$row[1]&oldabbr=$row[2]&oldstreetname=$row[3]&oldstreetnum=$row[4]&oldzip=$row[5]&oldcity=$row[6]&oldtype=$row[7]'>Remove </a></td>";
          echo '</tr>';
        }

        echo '</div>';
        echo '</table>';
      }
      ?>
  </div>
</body>
</html>
