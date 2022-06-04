<!DOCTYPE html>
<html>
<head>
  <title>Deliverables</title>
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
  $title = $_GET['oldtitle'];
  include 'db-connection.php';
  $conn = OpenCon();
  $query = "SELECT * from deliverable WHERE project_id = $id";
  echo "<h1> Project deliverables: </h1>";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) == 0){
    echo "<h2> This project doesn't have deliverables yet!</h2>";
  }
  else{
    echo "<div>";
    echo "<table>";
    echo "<tr>";
    echo "<th> Title </th>";
    echo "<th> Summary </th>";
    echo "<th> Deadline </th>";
    echo "</tr>";
    while($row = mysqli_fetch_row($result)){
      echo "<tr>";
      echo "<td> $row[1] </td>";
      echo "<td> $row[2] </td>";
      echo "<td> $row[3] </td>";
      echo "<td><a href='update_del.php?id=$row[0]&title=$row[1]&summary=$row[2]&deadline=$row[3]'>Edit</a></td>";
      echo "<td><a href='delete_del.php?id=$row[0]&title=$row[1]&summary=$row[2]&deadline=$row[3]'>Remove</a></td>";
      echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
  }
  if(isset($_POST['submit'])){
    $del_title = $_REQUEST['del'];
    $del_sum = $_REQUEST['delsum'];
    $del_deadline = $_REQUEST['deldeadline'];

    if(empty($del_title) OR empty($del_sum)){
      echo '<script>alert("Please fill all (*) fields!")</script>';
    }
    else{
      $query_del = "INSERT INTO deliverable VALUES($id,'$del_title', '$del_sum', '$del_deadline')";
      if(mysqli_query($conn, $query_del)){
        echo '<script type="text/javascript">
               alert("Deliverable inserted!");
               location="index.php";
             </script>';
      }
      else{
        echo '<script type="text/javascript">
               alert("There was a problem with this deliverable!");
               location="index.php";
             </script>';
      }
    }

  }
 ?>

   <h4>Add a new deliverable:</h4>
<form method="post" action="">
Title *: <br> <input type='text' name='del' ><br>
Summary * : <br> <input type='text' name='delsum' ><br>
Deadline: <input type='date' name='deldeadline'> <br>
<input type='submit' name='submit' value='Add'>
</form>

</body>
</html>
