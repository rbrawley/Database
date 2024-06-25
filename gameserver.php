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

    $sql = "CREATE TABLE IF NOT EXISTS user_games (
        gameID int AUTO_INCREMENT NOT NULL,
        id int NOT NULL,
        gameName VARCHAR(100) NOT NULL,
        owned VARCHAR(10),
        havePlayed VARCHAR(10),
        PRIMARY KEY(gameID),
        FOREIGN KEY(id) REFERENCES account_info(id)
    )";

    $stmt=$pdo->prepare($sql);
    $stmt->execute() or die("Not created");
    
    $username = $_SESSION["user"];
    $gameName = $_POST["gameName"];
    $own = $_POST["own"];
    $played =$_POST["played"];
    $CRUD = $_POST["crud"];

    function insert_game($gameName, $own, $played, $pdo, $username){

        $sql = "SELECT id FROM account_info WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute([$username]);
        $result = $stmt->fetch();
        $id =$result["id"];

        $sql = "INSERT INTO user_games(id, gameName, owned, havePlayed) 
        VALUES (?, ?, ?, ?)";


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $gameName, PDO::PARAM_STR);
        $stmt->bindParam(3, $own, PDO::PARAM_BOOL);
        $stmt->bindParam(4, $played, PDO::PARAM_BOOL);
        
        if($stmt->execute([$id, $gameName, $own, $played])){
            setcookie("shelfChange", "$gameName sucessfully added!", time() +1);
            header("location: gamepage.php");
        } 
        else {
            setCookie("shelfChange", "Failed to add $gameName", time() +1);
            header("location: gamepage.php");
            
        }

    }

    function update_game($gameName, $own, $played, $pdo, $username){
        $sql = "SELECT id FROM account_info WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute([$username]);
        $result = $stmt->fetch();
        $id =$result["id"];

        $sql = "UPDATE user_games
        SET owned = ?, havePlayed = ?
        WHERE gameName = ? AND id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $own, PDO::PARAM_BOOL);
        $stmt->bindParam(2, $played, PDO::PARAM_BOOL);
        $stmt->bindParam(3, $gameName, PDO::PARAM_STR);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);

    if($stmt->execute([$own, $played, $gameName, $id])){  
        setcookie("shelfChange", "$gameName has been updated!", time() +1);
        header("location: gamepage.php");
    }

    }

    function delete_game($gameName, $pdo, $username){
        $sql = "SELECT id FROM account_info WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam(1, $username, PDO::PARAM_STR);

        $stmt->execute([$username]);
        $result = $stmt->fetch();
        $id =$result["id"];

        $sql = "Delete FROM user_games
        WHERE gameName = ? AND id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $gameName, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);

        if($stmt->execute([$gameName, $id])){
            setcookie("shelfChange", "$gameName has been removed!", time() +1);
            header("location: gamepage.php");
        }
        else {
            setCookie("shelfChange", "Failed to remove $gameName", time() +1);
            header("location: gamepage.php");
            
        }
    }

    switch($CRUD){
        case "update":
            update_game($gameName, $own, $played, $pdo, $username);
            break;
        case "insert":
            insert_game($gameName, $own, $played, $pdo, $username);
            break;
        case "delete":
            delete_game($gameName, $pdo, $username);
            break;
        default:
            echo "Something went wrong.  Please try again";
            break;
    }    
    }
?>