<!DOCTYPE html>
<html>
<title>Update Deliverable</title>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>Edit deliverable:</h2>
  <?php
    $oldtitle = $_GET['title'];
    $id = $_GET['id'];
    $oldsummary = $_GET['summary'];
    $olddeadline = $_GET['deadline'];
    echo "<h2>Current deliverable details:</h2>";
    echo "Title: $oldtitle <br>";
    echo "Summary: $oldsummary <br>";
    echo "Deadline: $olddeadline <br>";

    if(isset($_POST['updatedel'])){
      $title = $_POST['newdeltitle'];
      $summary = $_POST['newdelsummary'];
      $deadline = $_POST['newdeldeadline'];
      include 'db-connection.php';
      $conn = OpenCon();
      $query = "UPDATE deliverable SET title='$title', summary='$summary', deadline='$deadline' WHERE (project_id=$id and title='$oldtitle' and summary='$oldsummary' and deadline='$olddeadline')";
      if(!empty($title) and !empty($summary)){
        if(mysqli_query($conn, $query)){
          echo '<script type="text/javascript">
                  alert("Deliverable succesfully updated!");
                  location="index.php";
                </script>';
        }
        else{
          echo '<script>alert("There was a problem with your deliverables!")</script>';
        }
      }else{
        echo '<script type="text/javascript">
                alert("Please fill all (*) fields!");
              </script>';
      }
    }
  ?>



<div id='edit_here'><h2 id='t'>Edit deliverable </h2>
  <form method='post' action=''>
Edit title: <br>
<input type='text' name='newdeltitle'>
<br><br>
Edit summary: <br>
<input type='text' name='newdelsummary'>
<br><br>
Edit deadline:<br>
<input type='date' name='newdeldeadline'>
<br><br>
<input type='submit' value='Update' name='updatedel'>
<br><br>
</form>
</div>
