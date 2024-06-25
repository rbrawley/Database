<?php
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



    $username =($_POST["username"]); 
    $pwdEntered = ($_POST["password"]);
    $email = $_POST["email"];


    //creates table for user login information
    $sql = "CREATE TABLE IF NOT EXISTS account_info (
        id int AUTO_INCREMENT NOT NULL,
        username VARCHAR(20) NOT NULL,
        password VARCHAR(100) NOT NULL,
        email VARCHAR(100),
        admin BOOLEAN NOT NULL,
        PRIMARY KEY(id)
    )";
    $stmt=$pdo->prepare($sql);
    $stmt->execute() or die("Not created");
    //if (!$stmt->execute()){
    //    echo "Table was Created";
    //}else {
    //    echo "Table not Created";
    //}

    

    $sql = "SELECT username FROM account_info
    WHERE username=?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(["demon"]);

    $result = $stmt->fetch();

    


    $validUser = check_user($username);
    $validPassword = check_password($pwdEntered);

    //inserts a new user to the table if info is valid
    if($validPassword == "true" && $validUser == "true"){
        $pwdHashed = password_hash($pwdEntered, PASSWORD_BCRYPT);

        $sql = "INSERT INTO account_info(username, password, email, admin) 
        VALUES (?, ?, ?, false)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $pwdHashed, PDO::PARAM_STR);
        $stmt->bindParam(3, $pwdHashed, PDO::PARAM_STR);

        
        if($stmt->execute([$username, $pwdHashed, $email])){
            setcookie("registerSuccess", "Registration was successful!  You may now login", time() +1); 
            header("location: login.php");
        }
        

    }
    else {
        header("location: registration.php");
    }

   
}
    //Checks if username is taken
    function check_user($username){
        if(isset($username)){
            global $pdo;
            $sql = "SELECT username FROM account_info
                WHERE username=?";
                $stmt=$pdo->prepare($sql);
                $stmt->execute([$username]);

            $result = $stmt->fetch();
            if($result["username"] != $username){
                return true;   
            }
            else{
                setcookie("userError", "Username is already taken", time()+1);
                return false;
            }
        }
    };

    //checks if pw is valid
    function check_password($pwdEntered){
        $isValid = false;
    if(strlen($pwdEntered) >= 7){
        if(strtolower($pwdEntered) != $pwdEntered && preg_match('~[0-9]+~', $pwdEntered)){
            $isValid = true;
        }
        else{
            setcookie("passError", "Password not strong enough.  Password requires at least 1 Capital and 1 number", time() +1);
        }
    }
    else{
        setcookie("passError", "Password length incorrect. Password must be at least 7 characters long.", time() +1);
    }

    return $isValid;  
    }
        
    $pdo = NULL;
 
?>