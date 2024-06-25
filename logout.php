<?php
echo "<link rel=\"stylesheet\" href=\"https://www.w3schools.com/w3css/4/w3.css\">";
session_start();


setcookie("logout", "$_SESSION[user] has been logged out successfully.", time() +1);


session_destroy();
header("location: login.php")

?>