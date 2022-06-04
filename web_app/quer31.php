<?php

  $date1 = $_GET['date1'];
  $date2 = $_GET['date2'];
  $ex = $_GET['ex'];
  $dur = $_GET['dur'];
  echo $date1;
  echo $date2;
  echo $dur;
  echo $ex;
  $conn = OpenCon();
  $query = "SELECT project_id, title, start_date, DATEDIFF(end_date,start_date) DIV 365 as duration, grade, summary, ammount, end_date, organization_id, supervisor_id FROM project";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) == 0){
    echo '<h1>ERROR</h1>';
  }
  else{
    echo '<div>';
    echo '<table>';
    echo '<tr>';
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
      echo "<td><a href='index.php'>  $row[1]  </a></td>";
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
