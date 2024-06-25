<!DOCTYPE html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php

$year = date("Y");

?>
<html class = 'w3-blue'>
<head>
    <title>Your Bookshelf</title>
</head>

<body>
    <?php 
        session_start();
        if ($_SESSION["online"] != true){

            header("location: login.php");
        }
    ?>

<?php if(isset($_COOKIE["shelfChange"])){
    echo "<h1 class = 'w3-center'>$_COOKIE[shelfChange]</h1>";
} ?>

<?php
    $dsn = "mysql:host=localhost;dbname=project";
    $dsnUsername ="root";
    $dsnPassword = "root";
    try{
        $pdo = new PDO($dsn, $dsnUsername, $dsnPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("connection error".$e->getMessage());
    }

    $id = $_SESSION["id"];
    $sql = "SELECT bookName, owned, haveRead FROM user_books WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='w3-container w3-twothird'>";
    echo "<h2 class = 'w3-center'>Your Current Bookshelf</h2>";
    echo "<table class = 'w3-table w3-border w3-bordered w3-centered w3-xlarge w3-orange'>";
    echo "<tr>";
    echo "<th>Book Title</th>";
    echo "<th>Currently Owned?</th>";
    echo "<th>Finished the Book?</th>";
    echo "</tr>";

    foreach($result as $row){
        echo "<tr>";
        echo "<td> {$row['bookName']} </td>";
        echo "<td>{$row['owned']}</td>";
        echo "<td>{$row['haveRead']}</td>";
        echo "</tr>";

    }
    echo "</table>";
    echo "</div>";
    $pdo = null;
?>
<div class = 'w3-card-4 w3-container w3-quarter w3-margin-left w3-xlarge'>
    <form action ="bookserver.php" method = 'POST'>
        <h2>Make a change to your shelf</h2>
        <div>
            <label for="bookName">Book name:<label><br>
            <input type = "text" name= "bookName" id = "bookName" required maxlength="100"><br>
        </div>

        <p>Do you currently own this book?</p>
        <div>
            <input type = "radio" name = "own" value = "true" id = "own" required>
         <label for = "own">Own</label><br> 
        </div>

        <div>
            <input type = "radio" name = "own" value = "false" id = "unowned"required>
            <label for = "unowned">Do Not Own</label><br> 
        </div>

        <p>Have you finished this book?</p>
        <div>
            <input type = "radio" name = "read" value = "true" id = "read"required>
            <label for = "read">Read</label><br> 
        </div>

        <div>
            <input type = "radio" name = "read" value = "false" id = "unread"required>
            <label for = "unread">Have Not Read</label><br> 
        </div>

        <p>Changes to be made?</p>

        <div>
            <input type = "radio" name = "crud" value = "insert" id = "insert"required>
            <label for = "insert">Add New Book</label><br>

        </div>
        <div>
            <input type = "radio" name = "crud" value = "update" id = "update"required>
            <label for = "update">Update Book</label><br>

        </div>

        <div>
            <input type = "radio" name = "crud" value = "delete" id = "delete"required>
            <label for = "delete">Remove Book</label><br>

        </div>
        
            <input type ="submit" value = "Edit your Shelf"><br><br>
    </form>
</div>

<div  class = 'w3-center w3-text-purple w3-content w3-xlarge'>
    <a href="gamepage.php">View Your Game Library Instead</a>
</div>

<form action="logout.php" class = ' w3-center w3-content'>
    <div w3-container w3-center>
            <input type = "submit" class= "w3-button w3-red w3-round-xxlarge" value = "Logout">    
    </div>
</form>


<!--TODO 
Add in admin privilages for Creating, updating, removing, and deleting tables

-->

</body>
<footer class = 'w3-center'>&copy; <?php echo $year; ?> Richard Brawley</footer>
</html>