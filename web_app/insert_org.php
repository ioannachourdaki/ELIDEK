<!DOCTYPE html>
<html>
<head>
  <title>Insert a new organization</title>
  <script>
function input_phones(str) {
  if (str == "") {
    document.getElementById("phone_nums").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("phone_nums").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","input_phones.php?q="+str,true);
    xmlhttp.send();
  }
}
</script>

</head>
<body style="background-color:#FFDAB9;">
  <?php
  function validating($phone) {
    if(preg_match("/^([1]-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$/i", $phone))
       return true;
    else
       return false;
  }


  include 'db-connection.php';
  if(isset($_POST['submit'])){
    $org_name = $_REQUEST['org_name'];
    $abbr = $_REQUEST['abbr'];
    $street_name = $_REQUEST['street_name'];
    $street_number = $_REQUEST['street_number'];
    $zip = $_REQUEST['zip'];
    $city = $_REQUEST['city'];
    $org_type = $_REQUEST['org_type'];
    $pnums = array();
    $i = 1;
    if(!empty($_REQUEST['i'])){
        $i = $_REQUEST['i'];
      }

    if(empty($org_name)){
      echo '<script>alert("Name not specified")</script>';
    }

    if(empty($abbr)){
      $abbr = substr($org_name,0,3);
    }

    if(empty($org_type)){
      echo '<script>alert("Type not specified")</script>';
    }

    if($org_type == "university") $org_type = "university";
    if($org_type == "research_center") $org_type = "research_center";
    if($org_type == "company") $org_type = "company";

    if(!empty($org_name) && !empty($org_type) && !empty($_REQUEST['phones'])){
      $flag = 1;
      // Validate every phone number
      for($j=1; $j<=$i; ++$j){
        if(!validating($_REQUEST["num$j"])){
          $flag = 0;
        }
      }

      $conn = OpenCon();
      $query = "INSERT INTO organization (org_name, abbreviation, street_name, street_number, zip, city, org_type)
                VALUES ('$org_name','$abbr','$street_name', $street_number, '$zip', '$city', '$org_type')";

      if($flag){
        if(mysqli_query($conn, $query)){
          $query1 = "";
          for($j=1; $j<=$i; ++$j){
            $x = $_REQUEST["num$j"];
            $query1 .= "INSERT INTO phone_number SELECT organization_id, '$x' FROM organization WHERE (org_name = '$org_name' AND abbreviation='$abbr');";
            }
              if(mysqli_multi_query($conn, $query1)){
                echo '<script type="text/javascript">
                       alert("Organization succesfully inserted!");
                       location="index.php";
                     </script>';
              }
              else{
                echo '<script>alert("There was a problem with your phone number(s)!")</script>';
              }
        }
        else{
          echo '<script>alert("There was a problem! Please try again!")</script>';
        }
    }
    else{
        echo '<script>alert("Invalid phone number(s)!")</script>';
    }
      echo "<br>";
      echo "<a href='index.php'>Return to Home Page </a>";
    }
    else{
      echo '<script>alert("Please fill all mandatory fields!")</script>';;
    }
}
    ?>

  <h1><a href='index.php'>ΕΛΙΔΕΚ</a></h1>
  <h2> Insert a new organization:</h2>
  <br>
  <form method="post" action="">
    <label>Organization name*</label>: <br>
    <input type="text" name="org_name">
    <span class="error"> <?php echo $org_nameErr;?> </span>
    <br><br>
    <label>Abbreviation:</label><br>
    <input type="text" name="abbr">
    <br><br>
    Address:<br>
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
    Phone number(s)*:<br>
  <select name="phones" onchange="input_phones(this.value)">
  <option value="">-</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  </select>
<br>
<div id="phone_nums"></div>
<br><br>
<input type="submit" name="submit" value="Submit">

  </form>


</body>
</html>
