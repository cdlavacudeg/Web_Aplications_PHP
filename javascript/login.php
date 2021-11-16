<?php // Do not put any HTML above this line
    session_start();
    require_once 'pdo.php';
    if ( isset($_POST['cancel'] ) ) {
        // Redirect the browser to game.php
        header("Location: logout.php");
        return;
    }
    $salt = 'XyZzy12*_';

    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';// Pw is php123
    
    // Check to see if we have some POST data, if we do process it

    if ( isset($_POST['email']) && isset($_POST['pass']) ) {
        if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
            $failure = "Email and password are required";
            $_SESSION['error']=$failure;
            header("Location: login.php");
            return;
        } else{
            if(!str_contains($_POST['email'],'@')){
                
                $failure="Email must have an at-sign (@)";
                $_SESSION['error']=$failure;
                header("Location: login.php");
                return;
            }else {
                $check = hash('md5', $salt.$_POST['pass']);
                $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
                $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ( $row !== false ) {
                    // Redirect the browser to view.php
                    $_SESSION['name']=$row['name'];
                    $_SESSION['user_id']=$row['user_id'];
                    header("Location: index.php");
                    error_log("Login success ".$row['name']);
                    return;
                } else {
                    $failure = "Incorrect password";
                    $_SESSION['error']=$failure;
                    header("Location: login.php");
                    error_log("Login fail ".$_POST['email']." $check");
                    return;
                }
            } 
        }
    }

    // Fall through into the View
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <?php require_once "bootstrap.php"; ?>
    <title> Cristian David Lavacude Galvis</title>
    </head>
    <body>
    <div class="container">
    <h1>Please Log In</h1>
    <?php

    if ( isset($_SESSION['error']) ) {
        
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the name of the programming language we are learning with 123 -->
</p>
</div>
</body>
