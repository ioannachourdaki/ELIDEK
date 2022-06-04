<?php

   function OpenCon(){
      $dbhost = "localhost";
      $dbuser = "elidek_user";
      $dbpass = "elidek_password";
      $db = "elidek_db";

      $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

      //echo "Connected successfully";
      return $conn;
   }

   function CloseCon($conn){
      $conn -> close();
   }


?>
