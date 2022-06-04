<!DOCTYPE html>
<html>
<head>
  <title>Delete organization</title>

</head>
<body style="background-color:#FFDAB9;">
  <h1>ΕΛΙΔΕΚ</h1>
  <h2>The following organization will be removed :</h2>
  <?php
  $id = $_GET['id'];
  $oldname = $_GET['oldname'];
  $oldabbr = $_GET['oldabbr'];
  $oldaddress = $_GET['oldaddress'];
  $oldcity = $_GET['oldcity'];
  $oldtype = $_GET['oldtype'];

  echo "<h3>Organization's information:</h3>";
  echo "Name: $oldname <br>";
  echo "Abbreviation: $oldabbr <br>";
  echo "Address: $oldaddress <br>";
  echo "City: $oldcity <br>";
  echo "Type: $oldtype <br>";
  echo "<br><br>";
  if(isset($_POST['submit'])){
    $org_name = $_REQUEST['org_name'];
    $abbr = $_REQUEST['abbr'];
    $street_name = $_REQUEST['street_name'];
    $street_number = $_REQUEST['street_number'];
    $zip = $_REQUEST['zip'];
    $city = $_REQUEST['city'];
    $org_type = $_REQUEST['org_type'];

    if($org_type == "university") $org_type = "unversity";
    if($org_type == "research_center") $org_type = "research_center";
    if($org_type == "company") $org_type = "company";

    if(!empty($org_name) && !empty($org_type)){
      echo "<h1>Your query: </h1>";
      echo "DELETE FROM organization WHERE organization_id = $id;";
      echo "<br><br>";
      echo "<a href='index.php'>Return to Home Page </a>";
  }
}
    ?>
<form action="">
  <input type="submit" name='submit'>DELETE</input>
</form>
</body>
</html>
