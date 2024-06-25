<?php

function verify_login($loginUsername, $loginPwd, $pdo){

    $sql = "SELECT * FROM account_info
            WHERE username=?";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$loginUsername]);
            $result = $stmt->fetch();
            if($result["username"] != $loginUsername){
                setcookie("loginError", "Username or password incorrect.  Please try again", time() +1);
                header("location: login.php");   
            }
            else{
                if(password_verify($loginPwd, $result["password"])){

                    $_SESSION["user"] = $result["username"];                    
                    $_SESSION["online"] = true;
                    $_SESSION["id"] = $result["id"];
                    header("location: homepage.php");
                }
                else{
                    setcookie("loginError", "Username or password incorrect.  Please try again", time() +1);
                    header("location: login.php");
                }  
            }
    return true;
};

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();
    $dsn = "mysql:host=localhost;dbname=project";
    $dsnUsername ="root";
    $dsnPassword = "root";


    try{
        $pdo = new PDO($dsn, $dsnUsername, $dsnPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("connection error".$e->getMessage());
    }


    $loginUsername = ($_POST["username"]); 
    $loginPwd = ($_POST["password"]);

    verify_login($loginUsername, $loginPwd, $pdo);

    

    $pdo = NULL;
}
    ?>