<?php

  $q = intval($_GET['q']);
  $i = 1;

  while($i <= $q){
    echo "<br><br>";
    echo "Deliverable $i: <br> <input type='text' name='del$i' ><br>";
    echo "Summary $i: <br> <input type='text' name='delsum$i' ><br>";
    echo "Deadline: <input type='date' name='deldeadline$i'> <br>";
    $i = $i + 1;
  }
  echo "<input type='hidden' name='i' value=$q>";
 ?>
