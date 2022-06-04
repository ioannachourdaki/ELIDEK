<!DOCTYPE html>
<html>
<head>
  <title>Update organization</title>
  <script>
function input_phones(str) {
  if (str == "") {
    document.getElementById("upphone_nums").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("upphone_nums").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","input_phones.php?q="+str,true);
    xmlhttp.send();
  }
}
</script>
</head>
<body style="background-color:#FFDAB9;">
  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2>Update an existing organization:</h2>
  <?php
  $id = $_GET['id'];
  $oldname = $_GET['oldname'];
  $oldabbr = $_GET['oldabbr'];
  $oldstreetname = $_GET['oldstreetname'];
  $oldstreetnum = $_GET['oldstreetnum'];
  $oldzip = $_GET['oldzip'];
  $oldcity = $_GET['oldcity'];
  $oldtype = $_GET['oldtype'];

  echo "<h3>Current organization:</h3>";
  echo "Name: $oldname <br>";
  echo "<br>Abbreviation: $oldabbr <br>";
  echo "<br>Address: $oldstreetname $oldstreetnum, $oldzip <br>";
  echo "<br>City: $oldcity <br>";
  echo "<br>Type: $oldtype <br>";
  echo "<br>Phone number(s): <br>";
  include 'db-connection.php';
  $conn = OpenCon();
  $query = "SELECT pnumber FROM phone_number WHERE organization_id=$id";
  $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_row($result)){
    echo "$row[0] <br>";
  }
  echo "<br><br>";
  echo "<h3>Update</h3>";
  if(isset($_POST['submit'])){
    $org_name = $_REQUEST['org_name'];
    $abbr = $_REQUEST['abbr'];
    $street_name = $_REQUEST['street_name'];
    $street_number = $_REQUEST['street_number'];
    $zip = $_REQUEST['zip'];
    $city = $_REQUEST['city'];
    $org_type = $_REQUEST['org_type'];
    $i = 0;
    if(!empty($_REQUEST['i'])){
        $i = $_REQUEST['i'];
      }

    if(empty($org_name)){
      $org_name = $oldname;
    }


    if(empty($abbr)){
      $abbr = substr($org_name,0,3);
    }

    if(empty($org_type)){
      $org_type = $oldtype;
    }

    if(empty($street_name)){
      $street_name = $oldstreetname;
    }
    if(empty($street_number)){
      $street_number = $oldstreetnum;
    }
    if(empty($zip)){
      $zip = $oldzip;
    }
    if(empty($city)){
      $city = $oldcity;
    }

    if($org_type == "university") $org_type = "university";
    if($org_type == "research_center") $org_type = "research_center";
    if($org_type == "company") $org_type = "company";


      $conn = OpenCon();
      $query = "UPDATE organization SET
                org_name = '$org_name', abbreviation ='$abbr' , street_name='$street_name', street_number=$street_number, zip='$zip', city='$city', org_type='$org_type'
                WHERE organization_id=$id";
      if(mysqli_query($conn, $query)){
        echo '<h2>Organization updated succesfully!</h2>';
        $query1 = "";
        if($i>0){
        for($j=1; $j<=$i; ++$j){
          $x = $_REQUEST["num$j"];
          $query1 .= "INSERT INTO phone_number VALUES($id, '$x');";
          }
          if(mysqli_multi_query($conn, $query1)){
            echo "<h2> Succefully inserted extra phone number(s)!</h2>";
          }
          else{
            echo '<script>alert("There was a problem with your phone number!")</script>';
          }
        }
        }
      else{
        echo '<script>alert("There was a problem! Please try again!")</script>';
      }
      echo "<br>";
      echo "<a href='index.php'>Return to Home Page </a>";

    }

    ?>
  <form method="post" action="">
    <label>Organization name*</label>: <br>
    <input type="text" name="org_name",>
    <span class="error"> <?php echo $org_nameErr;?> </span>
    <br><br>
    <label>Abbreviation:</label><br>
    <input type="text" name="abbr">
    <br><br>
    Address:<br><br>
    <label>Street Name:</label> <br>
    <input type="text" name="street_name">
    <br><br>
    Street Number: <br>
    <input type="number" name="street_number">
    <br><br>
    ZIP: <br>
    <input type="number" name="zip">
    <br><br>
    City: <br>
    <input type="text" name="city">
    <br><br>
    Organization type:*<br>
    <select name="org_type">
      <option value=""> Select organization type </option>
      <option value="university"> University </option>
      <option value="research_center"> Research Center </option>
      <option value="company"> Company </option>
    </select>
    <br><br>
    <a href="update_phone_numbers.php?id=<?php echo $id?>">Edit phone numbers </a>
    <br>
    <div id="upphone_nums"></div>
    <br><br>
    <input type="submit" name="submit" value="Submit">
  </form>


</body>
</html>
