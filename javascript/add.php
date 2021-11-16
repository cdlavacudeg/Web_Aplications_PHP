<?php 
    session_start();
    require_once 'pdo.php';
    if(!isset($_SESSION['name'])){
        die("ACCESS DENIED");
    }

    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }
    
    
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline'])&& isset($_POST['summary'])){
        if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
            $_SESSION['messague']="All fields are required";
            header('Location:add.php');
            return;
        }else {
            if(!str_contains($_POST['email'],'@')){
                $_SESSION['messague']="Email must have an at-sign (@)";
                header('Location:add.php');
                return;
            }else{
                $stmt = $pdo->prepare('INSERT INTO Profile  (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su)');
                $stmt->execute(array(
                    ':uid' => $_SESSION['user_id'],
                    ':fn' => $_POST['first_name'],
                    ':ln' => $_POST['last_name'],
                    ':em' => $_POST['email'],
                    ':he' => $_POST['headline'],
                    ':su' => $_POST['summary'])
                );
                $_SESSION['success']='Record added';
                header("Location: index.php");
                return;
            }
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
<title>Cristian David Lavacude Galvis</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
    <h1>Ading Profile for <?php echo ($_SESSION['name'])?></h1>
    <?php 
        if ( isset($_SESSION['messague'])) { 
                echo('<p style="color: red;">'.htmlentities($_SESSION['messague'])."</p>\n");
                unset($_SESSION['messague']);
            }
        ?>

        <form method="post">
        <p>Firt name:
        <input type="text" name="first_name" size="60"/></p>
        <p>Last name:
        <input type="text" name="last_name" size="60"/></p>
        <p>Email:
        <input type="text" name="email" size="30"/></p>
        <p>Headline:<br>
        <input type="text" name="headline" size="80"/></p>
        <p>
            Summary:<br>
            <textarea name="summary" rows="8" cols="80"></textarea>
        </p>
        
        <p>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
        </p>
    </form>
</div>

</body>

</html>