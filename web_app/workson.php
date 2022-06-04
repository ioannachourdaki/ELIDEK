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

    $id = $_GET['id'];
    include 'db-connection.php';
    $conn =OpenCon();
    $proj_q = "SELECT summary, ammount, start_date, end_date, grade, grade_date, evaluator_id, supervisor_id, organization_id, executive_id, program_id FROM project WHERE project_id = $id";

    $p = mysqli_query($conn, $proj_q);
    $pr = mysqli_fetch_row($p);

    $evalq = "SELECT first_name, last_name FROM researcher WHERE researcher_id=$pr[6]";
    $supervq = "SELECT first_name, last_name FROM researcher WHERE researcher_id=$pr[7]";
    $organq = "SELECT org_name FROM organization WHERE organization_id = $pr[8]";
    $execq = "SELECT first_name, last_name FROM researcher WHERE researcher_id=$pr[9]";
    $progq = "SELECT title FROM program WHERE program_id = $pr[10]";

    $evalr = mysqli_query($conn, $evalq);
    $supervr = mysqli_query($conn, $supervq);
    $execr = mysqli_query($conn, $execq);
    $progr = mysqli_query($conn, $progq);
    $organr = mysqli_query($conn, $organq);

    $eval = mysqli_fetch_row($evalr);
    $superv = mysqli_fetch_row($supervr);
    $exec = mysqli_fetch_row($execr);
    $prog = mysqli_fetch_row($progr);
    $organ = mysqli_fetch_row($organr);

    echo "<h2>Project full information:</h2>";
    echo "<table>";
    echo "<tr><th>ID</th> <td>$id</td></tr>";
    $title = $_GET['title'];
    echo "<tr><th>Title</th> <td>$title</td></tr>";
    echo "<tr><th>Summary:</th><td> $pr[0]</td></tr>";
    echo "<tr><th>Budget(€):</th> <td>$pr[1]</td></tr>";
    echo "<tr><th>Start date:</th><td>$pr[2]</td></tr>";
    echo "<tr><th>End date:</th> <td>$pr[3]</td></tr>";
    $end_d = $pr[3];
    echo "<tr><th>Grade:</th> <td>$pr[4]</td></tr>";
    echo "<tr><th>Grade date:</th> <td>$pr[5]</td></tr>";
    echo "<tr><th>Evaluator:</th> <td>$eval[0] $eval[1]</td></tr>";
    echo "<tr><th>Supervisor:</th> <td>$superv[0] $superv[1]</t></tr>";
    echo "<tr><th>Organization:</th><td> $organ[0]</td></tr>";
    echo "<tr><th>Executive:</th> <td>$exec[0] $exec[1]</td></tr>";
    echo "<tr><th>Program:</th> <td>$prog[0]</td></tr>";
    echo "</table>";
    echo "<br><br><br>";
    echo "<h2> Researchers working/worked on this project: </h2>";
    $query = "SELECT r.researcher_id, r.first_name, r.last_name FROM researcher r INNER JOIN works_on wo ON r.researcher_id=wo.researcher_id WHERE project_id = $id ";

    $result = mysqli_query($conn,$query);

    if(isset($_GET['del'])){
      $rid = $_GET['rid'];
      $id = $_GET['id'];
      if($rid == $pr[7]){
        $rid= "XXXXXXX";
      }
      $query2 = "DELETE FROM works_on WHERE (project_id= $id AND researcher_id=$rid)";
      if(mysqli_query($conn, $query2)){
           echo '<script type="text/javascript">
                  alert("Researcher succesfully removed from project!");
                  location="index.php";
                </script>';
      }
      else{
        echo '<script>alert("An error occured!Please try again! ")</script>';
      }
    }


    if(isset($_POST['add'])){
      $idd = $_GET['id'];
      $x = $_REQUEST['r'];
      if(empty($x)){
        echo '<script>alert("Error! Please make sure you selected a valid researcher ")</script>';
      }
      else{
        $q = "INSERT INTO works_on VALUES ($id, $x)";
        if(mysqli_query($conn, $q)){
          echo '<script type="text/javascript">
                  alert("Researcher added to the project!");
                  location="index.php";
                </script>';
        }
        else{
          echo '<script>alert("Error! Please make sure you selected a valid researcher ")</script>';
        }
      }
    }

  ?>


  <?php
    if(mysqli_num_rows($result) == 0){
      echo "<h3 style='color:red'> No researchers worked/working on this project! </h3>";
    }
    else{
      echo "<div>";
      echo "<table>";
      echo "<tr><th>Researcher's ID</th>";
      echo "<th>Researcher's name</th>";
      while($row = mysqli_fetch_row($result)){
        echo "<tr>";
        echo "<td> $row[0] </td>";
        echo "<td> $row[1] $row[2] </td>";
        echo "<td><a href='workson.php?id=$id&del=true&rid=$row[0]'>Delete</a>";
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "</div>";
    }

   ?>
   <br>
   <h3> Add researcher: </h3>
   <form method="post">
     <select name='r'>
       <?php
         $orgid = $_GET['orgid'];
         $conn = OpenCon();
         $query = "SELECT r.researcher_id, r.first_name, r.last_name FROM researcher r WHERE(r.org_start_date<'$pr[3]' and r.organization_id=$orgid AND r.researcher_id NOT IN (SELECT r.researcher_id FROM researcher r INNER JOIN works_on wo ON r.researcher_id=wo.researcher_id WHERE (project_id = $id)))";

         $result = mysqli_query($conn, $query);
         if(mysqli_num_rows($result) == 0){
           echo "<option value=''>All researchers working!</option>";
         }
         else{
           echo "<option value=''>Select researcher</option>";
           while($row = mysqli_fetch_row($result)){

          echo" <option value='$row[0]'>  $row[1] $row[2]  </option>";

           }
           $conn->close();
         }

           ?>
     </select>
   <input type='submit' name='add' value='Add'>
 </form>
 </body>
 </html>
