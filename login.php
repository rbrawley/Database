<!DOCTYPE html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php

$year = date("Y");

?>
<html class = 'w3-gray'>
<head>
    <title>Login Here</title>
</head>

<body>
    <div>
        <?php 
            if(isset($_COOKIE["logout"])){
                echo "<h2 class = 'w3-center w3-text-black'>$_COOKIE[logout]</h2>";
            }
            if(isset($_COOKIE["registerSuccess"])){
                echo "<h2 class = 'w3-center w3-text-black'>$_COOKIE[registerSuccess]</h2>";
            }
        ?>
        <div class = 'w3-container w3-left w3-third'><p></p></div>
        <div class = 'w3-container w3-center w3-third'>
            <h1 class = 'w3-center w3-xxxlarge w3-text-black'>Login</h1>
        </div>

        <div class = 'w3-container w3-right w3-third'><p></p></div>
        <div class = 'w3-xlarge w3-text-black'>
        <?php include "loginserver.php"; ?>
        <form action="loginserver.php" method = "POST" class = 'w3-center'>
            <div class = 'w3-container w3-section'>
                <label for="username">Username:<label><br>
                <input type="text" name="username" id="username" placeholder = "Username" required minlength="3"> 
            </div>

            <div class = 'w3-container w3-section'>
                <label for="password">Password:<label><br>
                <input type="password" name="password" id="password" placeholder = "Password" required><br>
            </div>
            
            <div class = 'w3-container w3-section'>
            <input type="submit" value="Login">
            </div>
            <?php if(isset($_COOKIE["loginError"])) {
                echo "<h4 class = 'w3-text-red'>$_COOKIE[loginError]</h4>";

            } ?>
        </form><br><br>
        </div>
        <div  class = 'w3-center w3-text-purple'>
            <a href="registration.php">New User?  Register here</a>
        </div>
    </div>
</body>

<footer class = 'w3-center w3-text-black'>&copy; <?php echo $year; ?> Richard Brawley</footer>
</html>