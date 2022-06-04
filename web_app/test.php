<!DOCTYPE html>
<html>
<body>
  <h1>insertion status</h1>
  <?php
    $org_name = $_REQUEST['org_name'];
    $abbr = $_REQUEST['abbr'];
    $street_name = $_REQUEST['street_name'];
    $street_number = $_REQUEST['street_number'];
    $zip = $_REQUEST['zip'];
    $city = $_REQUEST['city'];
    $org_type = $_REQUEST['org_type'];

    if(empty($org_name)){
      echo "ERROR: Organization's name not specified!<br>";
    }

    if(empty($abbr)){
      $abbr = substr($org_name,0,3);
    }

    if(empty($org_type)){
      echo "ERROR: Organization's type not specified!";
    }
    if($org_type == "university") $org_type = "unversity";
    if($org_type == "research_center") $org_type = "research center";
    if($org_type == "company") $org_type = "company";

    if(!empty($org_name) && !empty($org_type)){
      echo "<h1>Your query: </h1>";
      echo "INSERT INTO organization (org_name, abbreviation,street_name,street_number,zip, city, org_type) VALUES ($org_name,$abbr,$street_name,$street_number,$zip,$city,  $org_type);";
      echo "<br><br><br><br>";
      echo "<a href='index.php'>Return to Home Page </a>";
  }
    ?>
</body>
</html>
