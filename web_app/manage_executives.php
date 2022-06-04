<!DOCTYPE html>
<html>
<head>
  <title>Executives</title>
<style>
  table, th, td {
  border: 1px solid black;
}
  </style>
</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
    <h2>MANAGE EXECUTIVES </h2>
    <form action="insert_executive.php">
    <input type="submit" value="+ NEW EXECUTIVE">
    </form>

    <div>
    <?php
      include 'db-connection.php';
      $conn = OpenCon();
      $query = "SELECT executive_id, first_name, last_name FROM executive";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) == 0){
        echo '<h1>ERROR</h1>';
      }
      else{
        echo '<div>';
        echo '<table>';
        echo '<tr>';
        echo '<th> ID </th>';
        echo '<th> First Name </th>';
        echo '<th> Last Name </th>';
        echo '<th>  </th>';
        echo '<th>  </th>';

        echo '</th>';
        while($row = mysqli_fetch_row($result)){
          echo '<tr>';
          echo '<td>' . $row[0] . '</td>';
          echo '<td>' . $row[1] . '</td>';
          echo '<td>' . $row[2] . '</td>';
          if(mysqli_num_rows($result) == 0){
            echo "<td>''</td>";
          }
          echo "<td><a href='update_executive.php?id=$row[0]&oldfirstname=$row[1]&oldlastname=$row[2]'>Update </a></td>";
          echo "<td><a style='color:Red;' href='delete_executive.php?id=$row[0]&oldfirstname=$row[1]&oldlastname=$row[2]'>Remove </a></td>";
          echo '</tr>';
        }

        echo '</div>';
        echo '</table>';
      }
      ?>
  </div>
<body>
<html>
