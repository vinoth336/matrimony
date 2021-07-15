<?php
$mysqli = new mysqli("103.83.81.68","marriedl_rajus","Ra472hjT0a","marriedl_matrimony", "3306");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>
