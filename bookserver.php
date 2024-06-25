<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $dsn = "mysql:host=localhost;dbname=project";
        $dsnUsername ="root";
        $dsnPassword = "root";
    
        try{
            $pdo = new PDO($dsn, $dsnUsername, $dsnPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("connection error".$e->getMessage());
        }

    $sql = "CREATE TABLE IF NOT EXISTS user_books (
        bookID int AUTO_INCREMENT NOT NULL,
        id int NOT NULL,
        bookName VARCHAR(100) NOT NULL,
        owned VARCHAR(10),
        haveRead VARCHAR(10),
        PRIMARY KEY(bookID),
        FOREIGN KEY(id) REFERENCES account_info(id)
    )";

    $stmt=$pdo->prepare($sql);
    $stmt->execute() or die("Not created");
    
    $username = $_SESSION["user"];
    $bookName = $_POST["bookName"];
    $own = $_POST["own"];
    $read =$_POST["read"];
    $CRUD = $_POST["crud"];

    function insert_book($bookName, $own, $read, $pdo, $username){

        $sql = "SELECT id FROM account_info WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute([$username]);
        $result = $stmt->fetch();
        $id =$result["id"];

        $sql = "INSERT INTO user_books(id, bookName, owned, haveRead) 
        VALUES (?, ?, ?, ?)";


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $bookName, PDO::PARAM_STR);
        $stmt->bindParam(3, $own, PDO::PARAM_BOOL);
        $stmt->bindParam(4, $read, PDO::PARAM_BOOL);
        
        if($stmt->execute([$id, $bookName, $own, $read])){
            setcookie("shelfChange", "$bookName sucessfully added!", time() +1);
            header("location: homepage.php");
        } 
        else {
            setCookie("shelfChange", "Failed to add $bookName", time() +1);
            header("location: homepage.php");
            
        }

    }

    function update_book($bookName, $own, $read, $pdo, $username){
        $sql = "SELECT id FROM account_info WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute([$username]);
        $result = $stmt->fetch();
        $id =$result["id"];

        $sql = "UPDATE user_books
        SET owned = ?, haveRead = ?
        WHERE bookName = ? AND id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $own, PDO::PARAM_BOOL);
        $stmt->bindParam(2, $read, PDO::PARAM_BOOL);
        $stmt->bindParam(3, $bookName, PDO::PARAM_STR);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);

    if($stmt->execute([$own, $read, $bookName, $id])){  
        setcookie("shelfChange", "$bookName has been updated!", time() +1);
        header("location: homepage.php");
    }

    }

    function delete_book($bookName, $pdo, $username){
        $sql = "SELECT id FROM account_info WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute([$username]);
        $result = $stmt->fetch();
        $id =$result["id"];

        $sql = "Delete FROM user_books
        WHERE bookName = ? AND id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $bookName, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);

        if($stmt->execute([$bookName, $id])){
            setcookie("shelfChange", "$bookName has been removed!", time() +1);
            header("location: homepage.php");
        }
        else {
            setCookie("shelfChange", "Failed to remove $bookName", time() +1);
            header("location: homepage.php");
            
        }
    }

    switch($CRUD){
        case "update":
            update_book($bookName, $own, $read, $pdo, $username);
            break;
        case "insert":
            insert_book($bookName, $own, $read, $pdo, $username);
            break;
        case "delete":
            delete_book($bookName, $pdo, $username);
            break;
        default:
            echo "Something went wrong.  Please try again";
            break;
    }    
    }
?>