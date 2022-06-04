<!DOCTYPE html>
<html>
<head>
  <title>Researchers</title>
  <style>
  table, th, td {
  border: 1px solid black;
}
  </style>

</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>MANAGE RESEARCHERS</h2>
  <form action="insert_researcher.php">
    <input type="submit" value="+ ADD RESEARCHER">
  </form>
  <br>
    <?php
      include 'db-connection.php';
      $conn = OpenCon();
      $query = "SELECT researcher_id, first_name, last_name, sex, birth_date, organization_id, org_start_date FROM researcher";
      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) == 0){
        echo '<h1>ERROR</h1>';
      }
      else{
        echo '<div>';
        echo '<table>';
        echo '<tr>';
        echo '<th> ID </th>';
        echo '<th> Name </th>';
        echo '<th> Sex </th>';
        echo '<th> Birth Date </th>';
        echo '<th> Organization </th>';
        echo '<th> Start Date </th>';
        echo '</tr>';
        while($row = mysqli_fetch_row($result)){
          echo '<tr>';
          echo '<td>' . $row[0] . '</td>';
          echo "<td> $row[1] $row[2] </td>";
          echo '<td>' . $row[3] . '</td>';
          echo '<td>' . $row[4] . '</td>';
          $query2 = "SELECT org_name from organization WHERE organization_id = $row[5]";
          $result2 = mysqli_query($conn,$query2);
          if(mysqli_num_rows($result2) == 0){
                echo "<td>   </td>";
          }
          else{
            $row2 = mysqli_fetch_row($result2);
            echo "<td>  $row2[0] </td>";
          }
          echo '<td>' . $row[6] . '</td>';
          echo "<td><a href='update_researcher.php?id=$row[0]&firstname=$row[1]&lastname=$row[2]&sex=$row[3]&birthdate=$row[4]&org=$row2[0]&orgstartdate=$row[6]'>Update</a></td>";
          echo "<td><a style='color:Red;' href='delete_researcher.php?id=$row[0]&firstname=$row[1]&lastname=$row[2]&sex=$row[3]&birthdate=$row[4]&org=$row2[0]&orgstartdate=$row[6]'>Remove</a></td>";
          echo '</tr>';
        }

        echo '</div>';
        echo '</table>';
      }
      ?>


</body>
</html>
