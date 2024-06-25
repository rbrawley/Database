<!DOCTYPE html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php


$year = date("Y");

?>

<html class = 'w3-gray'>
<head>
    <title>Register Here</title>
</head>

<body>
    <div class = 'w3 container w3-left w3-third'><p></p></div>
    <div class = 'w3-center w3-third'>
        <h1 class = 'w3-center w3-xxxlarge w3-text-black'>Account Registration</h1>
    </div>
    <div class = 'w3 container w3-right w3-third'><p></p></div>
    <div class = 'w3-xlarge w3-text-black'>
        <?php include "regserver.php"; ?>
        <form action = "regserver.php" method = "POST"  class = 'w3-center'>
            <div class = 'w3-container w3-section'>
                <label for="username">Please Enter a Unique Username:<label><br>
                <input type="text" name="username" id="username" placeholder = "Username" 
                required minlength = "3" maxlength = "20"> 
            </div>

            <?php if(isset($_COOKIE["userError"])) {
                echo "<h3 class = 'w3-text-red'>$_COOKIE[userError]</h4>";
            } ?>

            <div class = 'w3-container w3-section'>
                <label for="password">Please Enter a Valid Password:<label><br>
                <input type="password" name="password" id="password" 
                placeholder = "Password" required minlength="7"><br> 
                <p class = w3-medium>*Password requires at least 7 characters, 
                    with at least 1 Uppercase letter and 1 number</p>
            </div>

            <?php if(isset($_COOKIE["passError"])) {
                echo "<h3 class = 'w3-text-red'>$_COOKIE[passError]</h4>";
            } ?>

            <div class = 'w3-container w3-section'>
                <label for = "email">Please Enter your Email (optional):<label><br>
                <input type="email" name="email" id="email" placeholder = "Email@domain.com">
            </div>

            <div class = 'w3-container w3-section'>
                <input type="submit" value="Register">
            </div>
        </form><br>
        <div  class = 'w3-center w3-text-purple'>
        <a href = "login.php">Existing user?  Login here</a>
        </div>
    </div>
</body>

<footer  class = 'w3-center w3-text-black'>&copy; <?php echo $year; ?> Richard Brawley</footer>
</html>