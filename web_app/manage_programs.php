<!DOCTYPE html>
<html>
<head>
  <title>Programs</title>
<style>
  table, th, td {
  border: 1px solid black;
}
  </style>
</head>
<body style="background-color:#FFDAB9;">
    <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
    <h2>MANAGE PROGRAMS</h2>
   <!-- <form action="manage_programs.php">
    <input type="submit" value="PROGRAMS">
    </form> -->
    <form action="insert_program.php">
    <input type="submit" value="+ NEW PROGRAM">
    </form>

    <div>
    <?php
      include 'db-connection.php';
      $conn = OpenCon();
      $query = "SELECT program_id, title, department FROM program";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) == 0){
        echo '<h1>ERROR</h1>';
      }
      else{
        echo '<div>';
        echo '<table>';
        echo '<tr>';
        echo '<th> Program ID </th>';
        echo '<th> Program Title </th>';
        echo '<th> Department </th>';
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
          echo "<td><a href='update_program.php?id=$row[0]&oldtitle=$row[1]&olddepartment=$row[2]'>Update </a></td>";
          echo "<td><a style='color:Red;' href='delete_program.php?id=$row[0]&oldtitle=$row[1]&olddepartment=$row[2]'>Remove </a></td>";
          echo '</tr>';
        }

        echo '</div>';
        echo '</table>';
      }
      ?>
  </div>
<body>
<html>
