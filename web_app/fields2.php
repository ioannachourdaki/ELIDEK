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
  include 'db-connection.php';
  $conn = OpenCon();
  $query = "SELECT * FROM field";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) != 0){

    echo "<h2> Our scientific fields: </h2>";
    echo "<table>";
    while($row = mysqli_fetch_row($result)){
      $url_enc = urlencode($row[0]);
    echo "<tr><td><b><a href='quer33.php?field=$url_enc'>$row[0]</a></td>";
    echo "<td><a href='fields2.php?field_name=$url_enc&del=true'>Remove</a></td></tr>";
  }
    echo "</table><br><small> Clicking a field will show associated projects and researchers!</small>";


  }
  else{
    echo '<script type="text/javascript">
           alert("No fields found!");
           location="index.php";
         </script>';

  }

  if(isset($_POST['submit'])){
    $new_field = $_REQUEST['new_field'];
    $query_add = "INSERT INTO field VALUES ('$new_field')";
    if(mysqli_query($conn, $query_add)){
      echo '<script type="text/javascript">
             alert("New field added!");
             location="index.php";
           </script>';
    }
    else{
      echo '<script type="text/javascript">
             alert("Error, please try again!");
             location="index.php";
           </script>';
    }
  }

  if(isset($_GET['del'])){
    $fieldname = $_GET['field_name'];
    $query_del = "DELETE FROM field WHERE field_name = '$fieldname'";
    if(mysqli_query($conn, $query_del)){
      echo '<script type="text/javascript">
             alert("Field succesfully removed!");
             location="index.php";
           </script>';
    }
    else{
      echo '<script type="text/javascript">
             alert("Error, please try again!");
             location="index.php";
           </script>';
    }
  }

  ?>
  <br>
  <form method="post" action="">
    <br>Add a new field: <br>
    <input type='text' name='new_field' >
    <input type="submit" name="submit" value="Add">
    <br><br>
  <div>
    <h2>Top 3 field combination :</h2>
    <table>

      <?php

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

</form>
 </body>
 </html>
