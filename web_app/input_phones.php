<?php

  $q = intval($_GET['q']);
  $i = 1;
  echo "<br>";
  echo "<small><i>Phone numbers must be in XXX-XXX-XXXX form.<br> Other forms will not be accepted!<i></small><br><br>";
  
  while($i <= $q){
    echo "Phone number $i: <br> <input type='text' name='num$i' ><br>";
    $i = $i + 1;
  }
  echo "<input type='hidden' name='i' value=$q>";
 ?>
