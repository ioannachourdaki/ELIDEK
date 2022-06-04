<!DOCTYPE html>
<html>

<head>
  <title>Projects</title>
  <style>
  table, th, td {
  border: 1px solid black;
}

  </style>

</head>

<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>MANAGE PROJECTS</h2>

  <br><br>
  <form action="">
    <div class="filters">
  Filters:<br><br>
  <i>Start date between:</i><br>
  <input type='date' id='d1' name='date1'>  -  <input type='date'id='d2' name='date2'><br><br>
  <i> Duration in years: </i><br>
  <input type='number' id='dur' name='dur'><br><br>
  Executive:<br>
  <select name="ex" >
    <option value=""> Select executive </option>
    <?php
    include 'db-connection.php';
      $conn = OpenCon();
      $query1 = "SELECT executive_id, first_name, last_name from executive";
      $result = mysqli_query($conn, $query1);
      while($row = mysqli_fetch_row($result)){
      ?>
      <option value="<?php echo $row[0]; ?>"> <?php echo "$row[1] $row[2]"; ?> </option>
      <?php
      }
      $conn->close();
      ?>
  </select>
</div>
  <br>
  <input type='submit' name='filter' value='Search' >
  </form>
  <br><br><br>
  <form action="insert_proj.php">
    <input type="submit" value="+ NEW PROJECT">
  </form>

  <small><i>Click a project for more details</i></small>
  <div id='proj'>
    <?php

      $date1 = $_GET['date1'];
      $date2 = $_GET['date2'];
      $ex = $_GET['ex'];
      $dur = $_GET['dur'];

      $conn = OpenCon();


      if(empty($date1)){
        $w1 = true;
      }
      else{
        $w1 = "start_date >= '$date1'";
      }

      if(empty($date2)){
        $w2 = true;
      }
      else{
        $w2 = "start_date <= '$date2'";
      }

      if(empty($dur)){
        $w3 = true;
      }
      else{
        $w3 = "DATEDIFF(end_date,start_date) DIV 365 = $dur";
      }

      if(empty($ex)){
        $w4 = true;
      }
      else{
        $w4 = "executive_id = $ex";
      }

      $query = "SELECT project_id, title, start_date, DATEDIFF(end_date,start_date) DIV 365 as duration, grade, summary, ammount, end_date, organization_id, supervisor_id FROM project";
      $query.= " WHERE ($w1 and $w2 and $w3 and $w4)";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) == 0){
        echo '<h3>No results!</h3>';
      }
      else{
        echo '<div>';
        echo '<table>';
        echo '<tr>';
        echo '<th> ID </th>';
        echo '<th> Project Title </th>';
        echo '<th> Ammount in € </th>';
        echo '<th> Scientific Fields </th>';
        echo '<th> Grade </th>';
        echo '<th> Start Date </th>';
        echo '<th> Duration </th>';
        echo '<th> Executive </th>';
        echo '</tr>';
        while($row = mysqli_fetch_row($result)){
          echo '<tr>';
          echo '<td>' . $row[0] . '</td>';
          echo "<td><a href='workson.php?id=$row[0]&title=$row[1]&orgid=$row[8]'>  $row[1]  </a></td>";
          echo '<td>' . $row[6] . '</td>';
          $query2 = "SELECT field_name from field_project WHERE project_id=$row[0]";
          $result2 = mysqli_query($conn,$query2);
          if(mysqli_num_rows($result2) == 0){
            echo "<td>''</td>";
          }
          else{ echo "<td>";
            while($row2 = mysqli_fetch_row($result2)){
              echo "$row2[0] <br>";
            }
            echo "</td>";
          }
          echo "<td>  $row[4]  </td>";
          echo '<td>' . $row[2] . '</td>';
          echo "<td>  $row[3]  </td>";
          $query3 = "SELECT e.first_name, e.last_name from executive e inner join project p on e.executive_id=p.executive_id  WHERE p.project_id=$row[0]";
          $result3 = mysqli_query($conn,$query3);
          if(mysqli_num_rows($result3) == 0){
            echo "<td>''</td>";
          }
          else{ echo "<td>";
            while($row3 = mysqli_fetch_row($result3)){
              echo "$row3[0] $row3[1]";
            }
            echo "</td>";
          }
          echo "<td><a href=manage_deliverables.php?id=$row[0]&title=$row[1]>Deliverables</a></td>";
          echo "<td><a href='update_proj.php?id=$row[0]&oldtitle=$row[1]&oldstartdate=$row[2]&oldduration=$row[3]&oldgrade=$row[4]&oldsummary=$row[5]&oldammount=$row[6]&oldenddate=$row[7]&org=$row[8]&oldsuperv=$row[9]'>Update </a></td>";
          echo "<td><a style='color:Red;' href='delete_proj.php?id=$row[0]&oldtitle=$row[1]&oldstartdate=$row[2]&oldduration=$row[3]&oldgrade=$row[4]&oldsummary=$row[5]&oldammount=$row[6]'>Remove </a></td>";
          echo '</tr>';
        }

        echo '</div>';
        echo '</table>';
      }
      ?>

  </div>
</body>
</html>
