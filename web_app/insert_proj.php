<!DOCTYPE html>
<html>
<head>
  <title>Insert a new project</title>
  <script>
function refresh_p(str) {
  if (str == "") {
    document.getElementById("proj_res").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("proj_res").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","proj_res_set.php?q="+str,true);
    xmlhttp.send();
  }
}

function set_deliverable(str) {
  if (str == "") {
    document.getElementById("dels").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("dels").innerHTML = this.responseText;
      }
    };
    var endd = document.getElementById("end_date").value;
    xmlhttp.open("GET","deliverable.php?q="+str,true);
    xmlhttp.send();
  }
}
</script>

</head>
<body style="background-color:#FFDAB9;">
  <?php
  include 'db-connection.php';
  if(isset($_POST['submit'])){
  $title = $_REQUEST['title'];
  $summary = $_REQUEST['summary'];
  $ammount = $_REQUEST['ammount'];
  $start_date = $_REQUEST['start_date'];
  $end_date = $_REQUEST['end_date'];
  $grade = $_REQUEST['grade'];
  $grade_date = $_REQUEST['grade_date'];
  $executive = $_REQUEST['executive'];
  $program = $_REQUEST['program'];
  $organization = $_REQUEST['organization'];
  $evaluator = $_REQUEST['evaluator'];
  $supervisor = $_REQUEST['supervisor'];
  $field_flag = 0;
  foreach ($_REQUEST['fields'] as $f) {
    if(!empty($f)){
       $field_flag = 1;
       break;
     }
  }
  $conn = OpenCon();
  if(!empty($title) && !empty($ammount) && !empty($start_date) && !empty($end_date) && !empty($grade_date) && !empty($organization) && ($field_flag==1) && !empty($executive) && !empty($program)){
  $ins_query = "INSERT INTO project (title,ammount,summary,start_date,end_date,grade,grade_date,evaluator_id,supervisor_id,organization_id,executive_id,program_id)
        VALUES ('$title', $ammount, '$summary', '$start_date', '$end_date', '$grade', '$grade_date', $evaluator,$supervisor,$organization,$executive,$program)";
  if(mysqli_query($conn, $ins_query)){
    echo '<script>alert("Project succesfully inserted!")</script>';
    $tmp = "SELECT project_id from project order by project_id desc limit 1";
    $ret = mysqli_query($conn, $tmp);
    $last_id_r = mysqli_fetch_row($ret);
    $last_id = $last_id_r[0];
    $superv_query = "INSERT INTO works_on VALUES($last_id, $supervisor)";
    $ret = mysqli_query($conn, $superv_query);
    $fp_quer ="";
    foreach ($_REQUEST['fields'] as $field) {
      $fp_quer .= "INSERT INTO field_project VALUES ($last_id, '$field');";
    }
    if(mysqli_multi_query($conn, $fp_quer)){
    //  echo '<script>alert("Fields succesfully inserted!")</script>';
    }
    else{
      echo '<script>alert("There was a problem with sci-fields!")</script>';
    }

    $conn->Close();
    $connection = OpenCon();
    $i = 0;
    if(!empty($_REQUEST['i'])){
        $i = $_REQUEST['i'];
      }
      if($i>0){
    $queryd = "";
    for($j=1; $j<=$i; ++$j){
      $z = $_REQUEST["delsum$j"];
      $y = $_REQUEST["del$j"];
      if(empty($z) OR empty($y)){
        echo '<script type="text/javascript">
               alert("There was a problem with deliverables!");
               location="index.php";
             </script>';

      }
      else{
      $x = date("Y-m-d", strtotime($_REQUEST["deldeadline$j"]));
      $queryd .= "INSERT INTO deliverable VALUES($last_id, '$y', '$z', '$x');";
    }
      }
      echo $queryd;
      if(mysqli_multi_query($connection, $queryd)){
        echo '<script>alert("Deliverable(s) succesfully inserted!")</script>';
      }
      else{
        echo '<script>alert("There was a problem with your deliverables!")</script>';
      }
    }


  }
  else{
    echo '<script type="text/javascript">
           alert("There was a problem inserting this project!");
           location="index.php";
         </script>';
  }


}
else{
    echo '<script>alert("Please fill all (*) fields !")</script>';
}
  }

  ?>


  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2> Insert a new project:</h2>
  <br>

  <form  method="post" action="">
    <label>Project title *</label>: <br>
    <input type="text" name="title">
    <br><br>
    <label>Summary:</label><br>
    <textarea name="summary"></textarea>
    <br><br>
    <label>Ammount:</label> <br>
    <input type="number" name="ammount">
    <br><br>
    Start Date: <br>
    <input type="date" name="start_date" value="<?php echo date('Y-m-d'); ?>">
    <br><br>
    End Date: <br>
    <input type="date" id="end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
    <br><i><small>Note that end date must be after start date </small></i>
    <br><br>
    Grade: <br>
    <select name="grade">
      <option value="A"> A </option>
      <option value="B"> B </option>
      <option value="C"> C</option>
      <option value="D"> D</option>
      <option value="E"> E </option>
    </select>
    <br><br>
    Grade date:<br>
    <input type="date" name="grade_date" value="<?php echo date('Y-m-d'); ?>">
    <br><i><small>Note that grade date must be before start date </small></i>
    <br><br>
    Select one or more scientific fields(*):<br>
    <select name="fields[]" multiple>
      <?php
        $conn = OpenCon();
        $query = "SELECT field_name from field";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_row($result)){
        ?>
        <option value="<?php echo $row[0]; ?>"> <?php echo $row[0]; ?> </option>
        <?php
        }
        $conn->close();
        ?>
    </select>
    <br><br>
    Executive *:<br>
    <select name="executive">
      <option value=""> Select executive </option>
      <?php
        $conn = OpenCon();
        $query = "SELECT executive_id, first_name, last_name from executive";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_row($result)){
        ?>
        <option value="<?php echo $row[0]; ?>"> <?php echo "$row[1] $row[2]"; ?> </option>
        <?php
        }
        $conn->close();
        ?>
    </select>
    <br><br>
    Select Program *:<br>
    <select name="program">
      <option value=""> Select program </option>
      <?php
        $conn = OpenCon();
        $query = "SELECT program_id, title from program";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_row($result)){
        ?>
        <option value="<?php echo $row[0]; ?>"> <?php echo $row[1]; ?> </option>
        <?php
        }
        $conn->close();
        ?>
    </select>
    <br><br>
    Deliverable (s):<br>
  <select name="deliverables" onchange="set_deliverable(this.value)">
  <option value="0">None:</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  </select>
<br>
<div id="dels"></div><br>
    Select Organization*:<br>
    <select name="organization" onchange="refresh_p(this.value)">
      <option value=""> Select organization </option>
      <?php
        $con2 = OpenCon();
        $query2 = "SELECT organization_id, org_name from organization order by organization_id";
        $result2 = mysqli_query($con2, $query2);
        while($row2 = mysqli_fetch_row($result2)){
        ?>
        <option value="<?php echo $row2[0]; ?>"> <?php echo $row2[1]; ?> </option>
        <?php
        }
        ?>
    </select>
    <div id="proj_res"></div>
  </form>


</body>
</html>
