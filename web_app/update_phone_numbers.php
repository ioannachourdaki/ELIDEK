<!DOCTYPE html>
<html>
<head>
  <title>Update phone numbers</title>
  <style>
  table, th, td {
  border: 1px solid black;
}
  </style>
</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>Edit phone numbers:</h2>
  <?php
  function validating($phone) {
    if(preg_match("/^([1]-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$/i", $phone))
       return true;
    else
       return false;
  }

    $id = $_GET['id'];
    $num = $_REQUEST['num'];
    include 'db-connection.php';
    $conn =OpenCon();
    $query = "SELECT pnumber FROM phone_number WHERE organization_id = $id ";
    $result = mysqli_query($conn,$query);

    if(isset($_GET['del'])){
      $num = $_GET['num'];
      $oid = $_GET['id'];
      $query2 = "DELETE FROM phone_number WHERE (organization_id= $oid AND pnumber='$num')";
      if(mysqli_query($conn, $query2)){
           echo '<script type="text/javascript">
                  alert("Number succesfully removed!");
                  location="index.php";
                </script>';
      }
      else{
        echo '<script>alert("An error occured!Please try again! ")</script>';
      }
    }

    if(isset($_POST['submit'])){
      $n = $_REQUEST['pnum'];
      if(validating($n)){
        $query3 = "INSERT INTO phone_number VALUES ($id, '$n')";
        if(mysqli_query($conn, $query3)){
          echo '<script type="text/javascript">
                 alert("Number succesfully inserted!");
                 location="index.php";
               </script>';
        }
        else{
          echo '<script>alert("An error occured!Please try again! ")</script>';
        }
      }
      else{
        echo '<script>alert("Wrong phone number format! ")</script>';
      }

    }
  ?>



  <h3>Current phone numbers:</h3>
  <?php
    if(mysqli_num_rows($result) == 0){
      echo "<h3> No phone numbers attached! </h3>";
    }
    else{
      echo "<div>";
      echo "<table>";
      echo "<tr><th>Number</th>";
      while($row = mysqli_fetch_row($result)){
        echo "<tr>";
        echo "<td> $row[0] </td>";
        echo "<td><a href='update_phone_numbers.php?id=$id&del=true&num=$row[0]'>Delete</a>";
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "</div>";
    }

   ?>
   <br>
   <h3> Add a new phone number: </h3>

   <br><br>
   <form method="post">
     <input type='text' name='pnum' >
   <input type='submit' name='submit' value='Add'>
 </form>
 </body>
 </html>
