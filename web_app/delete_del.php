<!DOCTYPE html>
<html>
<head>
  <title>Delete Deliverable</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>The following deliverable will be removed :</h2>
  <?php
  $id = $_GET['id'];
  $title = $_GET['title'];
  $summary = $_GET['summary'];
  $deadline = $_GET['deadline'];

  echo "<h3>Deliverable current information:</h3>";
  echo "Title: $title <br>";
  echo "Summary: $summary <br>";
  echo "Deadline: $deadline <br>";
  echo "<br><br>";
  if(isset($_POST['submit'])){
    include 'db-connection.php';
    $conn = OpenCon();
    $query = "DELETE FROM deliverable WHERE (project_id = $id AND title='$title'AND summary='$summary' AND deadline='$deadline')";
    if(mysqli_query($conn,$query)) {
         echo '<script type="text/javascript">
                alert("Deliverable succesfully updated!");
                location="index.php";
              </script>';
          }
   else{
     echo '<script>alert("There was a problem deleting this deliverable!")</script>';
   }
}
  ?>

<form method="post" action="" >
  <input id='submitbtn' type="submit" name='submit' value='DELETE' ></input>
</form>
</body>
</html>
