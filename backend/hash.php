<?php 
$password = "souleymane2008";
$hash = password_hash($password, PASSWORD_DEFAULT);
// $hash devient quelque chose comme : $2y$10$WfwbdL9xHTM5...
echo $hash ; 
?>